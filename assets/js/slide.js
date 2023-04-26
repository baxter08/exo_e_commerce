var slides = document.querySelector('.slides');
var prev = document.querySelector('.prevp');
var next = document.querySelector('.nextm');
var slideWidth = slides.children[0].offsetWidth;
var currentIndex = 0;

next.addEventListener('click', function() {
  if (currentIndex < slides.children.length - 1) {
    currentIndex++;
    slides.style.transform = 'translateX(-' + currentIndex * slideWidth + 'px)';
  }
});

prev.addEventListener('click', function() {
  if (currentIndex > 0) {
    currentIndex--;
    slides.style.transform = 'translateX(-' + currentIndex * slideWidth + 'px)';
  }
});