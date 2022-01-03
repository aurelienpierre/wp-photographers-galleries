/* Continuous scrolling for carousels */
function Scroll(n, id) {
  var matte = document.getElementById(id);

  // Compute the position of the center of the view relative to slider full width
  var current_position = matte.scrollLeft + matte.offsetWidth / 2.;

  // Compute the position of the center of each image relative to slider full width
  var images = matte.querySelectorAll('figure');
  var centers = [];
  var widths = [];

  images.forEach(function (img)
  {
    var half_width = img.offsetWidth / 2.;
    centers.push(img.offsetLeft + half_width);
    widths.push(half_width);
  });

  // Find the image that is currently the closest from the current position
  var current_index = 0;
  var distance = 9999999999;

  for (var i = 0; i < centers.length; i++)
  {
    var current_distance = Math.abs(current_position - centers[i]);
    if (current_distance < distance)
    {
      distance = current_distance;
      current_index = i;
    }
  }

  // Find the image requested for scrolling
  current_index += n;
  if (current_index < 0) current_index = 0;
  if (current_index > centers.length - 1) current_index = centers.length - 1;

  // Find the next position to scroll to
  var position = centers[current_index] - matte.offsetWidth / 2.;

  matte.scroll({
    left: position,
    behavior: 'smooth'
  });
}

var timer;

function updateArrows(event, id) {
  // hide navigation arrows if container is scrolled to max/min

  clearTimeout(timer);
  timer = setTimeout(function () {
    var matte = document.getElementById(id);
    var arrow_left = matte.getElementsByClassName('gallery-prev')[0];
    var arrow_right = matte.getElementsByClassName('gallery-next')[0];
    if (matte.scrollLeft == 0) arrow_left.style.display = 'none';
    else arrow_left.style.display = 'block';

    if (matte.scrollLeft == matte.scrollLeftMax) arrow_right.style.display = 'none';
    else arrow_right.style.display = 'block';
  }, 300);
}

function removeArrows(matte) {
  // remove navigation arrows if exhibition has only 1 image
  var arrow_left = matte.getElementsByClassName('gallery-prev')[0];
  var arrow_right = matte.getElementsByClassName('gallery-next')[0];
  arrow_left.style.display = 'none';
  arrow_right.style.display = 'none';
}


/* Incremental scrolling for exhibitions */

function preload(matte, next_image) {
  // Get the next image in line and preload it to prevent frustrating delays and layout wonky jumps
  var img = next_image.querySelectorAll('img')[0];

  // If already preloaded, skip
  if ('preloaded' in img.dataset && img.dataset.preloaded == 'true') return;

  // Remove lazyloading at all, native browser as well as scripts
  delete img.dataset.sizes;
  img.classList.remove('lazyload', 'lazyloaded', 'lazyautosizes');

  // Get current size
  getComputedStyle(matte);
  var gallery = matte.getElementsByClassName('gallery')[0];
  var maxHeight = Math.min(window.innerHeight, gallery.clientHeight);
  var maxWidth = Math.min(window.innerWidth, gallery.clientWidth);
  var ratio_view = maxWidth / maxHeight;
  var ratio_img = img.width / img.height;
  var ratio_ratios = ratio_view / ratio_img;

  // find the maximum exact image dimensions that fit within container while preserving display ratios
  var final_height;
  var final_width;

  if (ratio_ratios < 1. && ratio_img < 1.) {
    // portrait image in longer screen screen -> width is blocking
    final_height = maxWidth / ratio_img;
    final_width = maxWidth;
  }
  else if (ratio_ratios > 1. && ratio_img < 1.) {
    // portrait image in shorter screen -> height is blocking
    final_height = maxHeight;
    final_width = maxHeight * ratio_img;
  }
  else if (ratio_ratios < 1. && ratio_img > 1.) {
    // lanscape image in narrower screen -> width is blocking
    final_height = maxWidth / ratio_img;
    final_width = maxWidth;
  }
  else if (ratio_ratios > 1. && ratio_img > 1.) {
    // landscape image in wider screen -> height is blocking
    final_height = maxHeight;
    final_width = maxHeight * ratio_img;
  }
  else if (ratio_img == 1.) {
    // square image -> smaller dimension is blocking
    final_height = Math.min(maxHeight, maxWidth);
    final_width = Math.min(maxHeight, maxWidth);
  }
  else {
    // ratio image == ratio screen -> perfect match
    final_height = maxHeight;
    final_width = maxWidth;
  }

  img.sizes = final_width + 'px';
  img.style.width = final_width + 'px';
  img.style.height = final_height + 'px';

  // probe the different methods of image URL storing by order of highest probability
  if ('srcset' in img.dataset) img.srcset = img.dataset.srcset;
  if ('src' in img.dataset) img.src = img.dataset.src;
  if ('origSrc' in img.dataset && img.src != img.dataset.origSrc) img.src = img.dataset.origSrc;

  img.loading = 'eager';
  img.setAttribute('data-preloaded', 'true');
}

function salvageIndex(i, figures) {
  // bound check and cycling over an array of figures
  var nb_figures = figures.length;
  return (i < 0) ? nb_figures - 1 : (i > nb_figures - 1) ? 0 : i;
}

var scroll_timeout;

function ScrollInc(n, id) {
  clearTimeout(scroll_timeout);

  scroll_timeout = setTimeout(function () {

    var matte = document.getElementById(id);
    var figures = matte.querySelectorAll('figure');
    var nb_figures = figures.length;

    var current_index = 0;
    var new_index = 0;

    // standard case for scrolling
    for (var i = 0; i < nb_figures; i++) {
      if (figures[i].classList.contains('active')) {
        current_index = i;
        figures[i].classList.remove('active');
      }
    }

    // Get the next figure
    var new_index = salvageIndex(current_index + n, figures);

    // Load the current image if not loaded
    preload(matte, figures[new_index]);
    var img = figures[new_index].querySelectorAll('img')[0];

    // Write preloading state
    figures[new_index].classList.add('active');

    // Preload the neighbouring image(s)
    if (n == 0) {
      // n = 0 is a special case triggered only at init
      // load previous and next images
      preload(matte, figures[salvageIndex(-1, figures)]);
      preload(matte, figures[salvageIndex(+1, figures)]);
      if (nb_figures == 1) { removeArrows(matte); }
    }
    else {
      // load only the next image in the current direction of moving
      preload(matte, figures[salvageIndex(new_index + n, figures)]);
    }
  }, 250);
}

var resize_timeout;

// Reset image sizes and loading on window resize
window.addEventListener('resize', function ()
{
  resize_timeout = setTimeout(function ()
  {
    var mattes = document.getElementsByClassName('pg-exhibition');
    for (var j = 0; j < mattes.length; j++)
    {
      console.log('window resized, exhibitions reset');
      var figures = mattes[j].querySelectorAll('figure');
      var active_index = -1;

      for(var i = 0; i < figures.length; i++)
      {
        var img = figures[i].querySelectorAll('img')[0];

        if('preloaded' in img.dataset && img.dataset.preloaded == 'true')
        {
          img.setAttribute('data-preloaded', 'false');
          img.loading = 'lazyload';

          // FIXME: the following is probably useless since src and srcset are not supposed to be changed
          //if('src' in img.dataset) img.setAttribute('data-src', img.src);
          //if('srcset' in img.dataset) img.setAttribute('data-srcset', img.srcset);
          img.sizes = '';
          img.style.width = '';
          img.style.height = '';

          if(figures[i].classList.contains('active')) active_index = i;
        }
      }

      // if some picture is active, reload current and neighbour images
      if(active_index > -1)
      {
        preload(matte, figures[active_index]);
        preload(matte, figures[salvageIndex(active_index - 1, figures)]);
        preload(matte, figures[salvageIndex(active_index + 1, figures)]);
      }
    }
  }, 500);
});

/* Horizontal Scrolling and swiping handling */

var isScrolling = false;

function jumpScroll(event, id) {
  // Stupid Firefox scrolls line by line, we need to convert line height to pixels
  var scrollX = 0;
  var line_to_pixel = 1;
  var line_height = 1.5 * parseFloat(getComputedStyle(event.currentTarget).fontSize)
  if (event.deltaMode == 1) line_to_pixel = line_height;

  // Disable Y scrolling if deltaY is below sensitivity threshold, so we only get a clean X scrolling
  if(Math.abs(event.deltaY * line_to_pixel) < line_height) event.preventDefault();

  clearTimeout(isScrolling);
  scrollX += event.deltaX;

  isScrolling = setTimeout(function () {
    var n = (scrollX < 0) ? -1 : (scrollX > 0) ? +1 : 0;
    ScrollInc(n, id);
    scrollX = 0;
  }, 50);
}

var touchHandler = null;
const time_threshold = 80; // ms
const distance_threshold = 100; // px

function swipeStart(event, id) {
  var touchobj = event.changedTouches[0];

  // start recording the move
  touchHandler = {
    'container': document.getElementById(id),
    'startX': touchobj.pageX,
    'startY': touchobj.pageY,
    'startTime': new Date().getTime()
  };

  //event.preventDefault();
  console.log(touchHandler);
}

function swipeEnd(event, id) {
  var touchobj = event.changedTouches[0];
  var matte = document.getElementById(id);

  // If something went wrong :
  if (!touchHandler) return;
  if (matte != touchHandler.container) return;

  // Compute distances
  const distanceX = touchobj.pageX - touchHandler.startX;
  const distanceY = touchobj.pageY - touchHandler.startY;
  const duration = new Date().getTime() - touchHandler.startTime;

  if (duration > time_threshold && Math.abs(distanceX) > distance_threshold && Math.abs(distanceX) > Math.abs(distanceY)) {
    // thresholds are matched : we have a swipe move
    if(distanceX < 0)
      ScrollInc(+1, id);
    else if (distanceX > 0)
      ScrollInc(-1, id);

    console.log('swipeEnd');
  }

  // reset the handler
  touchHandler = null;
}


/* Give keyboard focus on exhibitions and carousels */

var isInViewport = function(elem) {
  // check if current object is in viewport
  // from https://gomakethings.com/how-to-test-if-an-element-is-in-the-viewport-with-vanilla-javascript/
  var bounding = elem.getBoundingClientRect();

  // if element does not perfectly fit in viewport, allow 20 % of safety margin in every direction
  var result = (
    bounding.top >= -0.1 * window.innerHeight &&
    bounding.left >= -0.2 * window.innerWidth &&
    bounding.bottom <= 1.1 * window.innerHeight &&
    bounding.right <= 1.2 * window.innerWidth
  );
  return result;
}

function scroll_to_view(elem) {
  // Ensure bloody browser scrolled for real to display the elem in viewport
  if (elem.offsetHeight <= window.innerHeight && elem.offsetHeight > 0.8 * window.innerHeight) {
    var bounding = elem.getBoundingClientRect();
    let padding = Math.max((window.innerHeight - elem.offsetHeight) / 2.0, 20.);
    window.scroll(window.scrollX, -padding + window.scrollY + bounding.top);
  }
}

window.addEventListener('scroll', function (event) {
  if(isScrolling) clearTimeout(isScrolling);
  isScrolling = setTimeout(function () {
    var carousels = document.getElementsByClassName('pg-carousel');
    var exhibitions = document.getElementsByClassName('pg-exhibition');

    for (i = 0; i < carousels.length; i++) {
      var elem = carousels[i];
      if (isInViewport(elem))
      {
        elem.focus({ preventScroll: false });
        scroll_to_view(elem);
      }
      else elem.blur();
    }
    for (i = 0; i < exhibitions.length; i++) {
      var elem = exhibitions[i];
      if (isInViewport(elem))
      {
        elem.focus({ preventScroll: false });
        scroll_to_view(elem);
      }
      else elem.blur();
    }
  }, 200);
}, { passive: true });
