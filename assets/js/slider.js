let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

// Please feel free to comment for improve the code...

$ (function() {
  //we target slider (carroussel) div
  var $carroussel = $('#carroussel'),
                    // we target images in slider
                    $img = $('#carroussel img'),
                    // define document index
                    indexImg = $img.length - 1,
                    // starting count
                    i = 0,
                    // finnaly, we target current image, wich has index i (0 for now)
                    $currentImg = $img.eq(i);
  
  // hidding images
  $img.css('display', 'none');
  // displaying current image only
  $currentImg.css('display', 'block');
  
  // injecting html
  $carroussel.append('<div class="controls"><span class="prev"></span><span class="next"></span></div>')
  
  $('.next').click(function() {
    i++;
    
    if( i <= indexImg ){
      // hidding image
      $img.css('display', 'none');
      // define new image
      $currentImg = $img.eq(i);
      // display it
      $currentImg.css('display', 'block');
    }
    else{
      i = indexImg;
    }
  });
  
  $('.prev').click(function() {
    i--;
    
    if( i >= 0 ){
      // hide image
      $img.css('display', 'none');
      // se new image
      $currentImg = $img.eq(i);
      // display it
      $currentImg.css('display', 'block');
    }
    else{
      i = 0;
    }
  });
  function slideImg() {
    setTimeout(function() {
      
    if(i < indexImg) {
      // increment
      i++;
    }
    else {
      i = 0;
    }
    
    $img.css('display', 'none');
    $currentImg = $img.eq(i);
    $currentImg.css('display', 'block');
    // we reflate the function at the end
    slideImg();
    },1000);
  }
  slideImg();
});

