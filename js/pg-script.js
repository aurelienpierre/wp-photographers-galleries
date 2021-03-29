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
    top: 0,
    left: position,
    behavior: 'smooth'
  });
}

/* Incremental scrolling for exhibitions */

function preload(matte, next_image) {
  // Get the next image in line and preload it to prevent frustrating delays and layout wonky jumps
  var img = next_image.querySelectorAll('img')[0];

  // If already preloaded, skip
  if ('preloaded' in img.dataset && img.dataset.preloaded == 'true' && img.complete) return;

  // Remove lazyloading at all, native browser as well as scripts
  delete img.dataset.sizes;
  img.classList.remove('lazyload', 'lazyloaded', 'lazyautosizes');
  img.loading = 'eager';

  // Get current size
  getComputedStyle(matte);
  var gallery = matte.getElementsByClassName('gallery')[0];
  var maxHeight = Math.min(window.innerHeight, gallery.clientHeight);
  var maxWidth = Math.min(window.innerWidth, gallery.clientWidth);
  var ratio_view = maxWidth / maxHeight;
  var ratio_img = img.width / img.height;
  var ratio_ratios = ratio_view / ratio_img;

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
  else {
    // ratio image == ratio screen -> perfect match
    final_height = maxHeight;
    final_width = maxWidth;
  }

  img.sizes = final_width + 'px';
  img.style.width = final_width + 'px';
  img.style.height = final_height + 'px';

  if ('srcset' in img.dataset) img.srcset = img.dataset.srcset;
  if ('src' in img.dataset) img.src = img.dataset.src;
}

function ScrollInc(n, id) {
  var matte = document.getElementById(id);
  var figures = matte.querySelectorAll('figure');
  var nb_figures = figures.length;

  function salvageIndex(i) {
    // bound check and cycling over array
    return (i < 0) ? nb_figures - 1 : (i > nb_figures - 1) ? 0 : i;
  }

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
  var new_index = salvageIndex(current_index + n);

  // Load the current image if not loaded
  preload(matte, figures[new_index]);
  var img = figures[new_index].querySelectorAll('img')[0];

  // Write preloading state
  img.setAttribute('data-preloaded', 'true');
  figures[new_index].classList.add('active');

  // Preload the next image in the current direction
  if (n != 0) {
    preload(matte, figures[salvageIndex(new_index + n)]);
  }
  else {
    preload(matte, figures[salvageIndex(-1)]);
    preload(matte, figures[salvageIndex(+1)]);
  }
}

var resize_timeout;

// Recompute image sizes on window resize
window.addEventListener('resize', function () {
  clearTimeout(resize_timeout);
  resize_timeout = setTimeout(function () {
    var mattes = document.getElementsByClassName('pg-exhibition');
    for (var j = 0; j < mattes.length; j++) {
      var figures = mattes[j].querySelectorAll('figure');

      for (var i = 0; i < figures.length; i++) {
        var img = figures[i].querySelectorAll('img')[0];

        if (img.dataset.preloaded == 'true') {
          img.setAttribute('data-preloaded', 'false');
          img.setAttribute('data-src', img.src);
          img.setAttribute('data-srcset', img.srcset);
          img.sizes = '';
          img.style.width = '';
          img.style.height = '';

          if (figures[i].classList.contains('active')) {
            preload(matte, figures[i]);
          }
        }
      }
    }
  }, 500);
});


/* Horizontal Scrolling and swiping handling */

var isScrolling;

function jumpScroll(event, id) {
  // Stupid Firefox scrolls line by line, we need to convert line height to pixels
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


/* Give keyboard focus on exhibitions and carousels */
/*
var carousels = document.getElementsByClassName('pg-carousel');
var exhibitions = document.getElementsByClassName('pg-exhibition');
var sections = document.querySelectorAll('.pg-exhibition,.pg-carousel');

console.log(sections);
*/


document.addEventListener("keydown", function (event) {
  if (event.code == 'KeyT') {
    stopPrntScr();
    console.log('copy is disabled');
  }
});


function stopPrntScr() {
  var inpFld = document.createElement("input");
  inpFld.setAttribute("value", ".");
  inpFld.setAttribute("width", "0");
  inpFld.style.height = "0px";
  inpFld.style.width = "0px";
  inpFld.style.border = "0px";
  document.body.appendChild(inpFld);
  inpFld.select();
  document.execCommand("copy");
  inpFld.remove(inpFld);

  function AccessClipboardData() {
    try {
      window.clipboardData.setData('text', "Access   Restricted");
    } catch (err) {
    }
  }
  setInterval("AccessClipboardData()", 300);
}
