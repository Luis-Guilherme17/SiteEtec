document.addEventListener('DOMContentLoaded', function(){
  const navLinks = document.querySelectorAll('nav a');
  const current = window.location.pathname.split('/').pop();
  navLinks.forEach(link=>{
    const href = link.getAttribute('href');
    if(href===current || (href==='index.html' && current==='')){
      link.style.background='rgba(255,255,255,.25)';
    }
  });

  const form = document.querySelector('form[action="contato.php"]');
  if(form){
    form.addEventListener('submit', function(event){
      const fone = document.getElementById('fone');
      if(fone && fone.value.trim() !== ''){
        const regex = /^\(?\d{2}\)?\s*\d{4,5}[-\s]?\d{4}$/;
        if(!regex.test(fone.value.trim())){
          event.preventDefault();
          alert('Por favor, insira um telefone válido no formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.');
          fone.focus();
        }
      }
    });
  }

  // Carousel
  const slides = document.querySelectorAll('.carousel .slide');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotsContainer = document.getElementById('carouselDots');
  let currentSlide = 0;
  let carouselInterval;

  function showSlide(index) {
    slides.forEach((slide, idx) => {
      slide.classList.toggle('active', idx === index);
    });
    const dots = dotsContainer.querySelectorAll('.dot');
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === index);
    });
    currentSlide = index;
  }

  function nextSlide() {
    showSlide((currentSlide + 1) % slides.length);
  }

  function prevSlide() {
    showSlide((currentSlide - 1 + slides.length) % slides.length);
  }

  if (slides.length > 0 && dotsContainer) {
    slides.forEach((_, idx) => {
      const dot = document.createElement('button');
      dot.className = 'dot' + (idx === 0 ? ' active' : '');
      dot.addEventListener('click', () => {
        showSlide(idx);
        resetInterval();
      });
      dotsContainer.appendChild(dot);
    });

    if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });

    function resetInterval() {
      clearInterval(carouselInterval);
      carouselInterval = setInterval(nextSlide, 6500);
    }

    carouselInterval = setInterval(nextSlide, 6500);
  }
});
