document.addEventListener('DOMContentLoaded', function(){
  const navLinks = document.querySelectorAll('nav a');
  const current = window.location.pathname.split('/').pop();
  navLinks.forEach(link=>{
    const href = link.getAttribute('href');
    if(href===current || (href==='index.html' && current==='')){
      link.style.background='rgba(255,255,255,.25)';
    }
  });

  /* ── Referências do formulário ──────────────────────── */
  const form      = document.getElementById('contactForm');
  const charCount = document.getElementById('charCount');
  const mensagem  = document.getElementById('mensagem');
  const telefone  = document.getElementById('telefone');
  const submitBtn = document.getElementById('submitBtn');

  const MAX_CHARS = 500;

  /* ── Contador de caracteres ────────────────────────── */
  if(mensagem) {
    mensagem.addEventListener('input', () => {
      const len = mensagem.value.length;
      charCount.textContent = `${len} / ${MAX_CHARS}`;
      charCount.classList.toggle('near-limit', len >= 400 && len < MAX_CHARS);
      charCount.classList.toggle('at-limit',   len >= MAX_CHARS);
      if (len > MAX_CHARS) mensagem.value = mensagem.value.slice(0, MAX_CHARS);
    });
  }

  /* ── Máscara de telefone ───────────────────────────── */
  if(telefone) {
    telefone.addEventListener('input', () => {
      let v = telefone.value.replace(/\D/g, '');
      if (v.length > 11) v = v.slice(0, 11);
      if (v.length > 10)      v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
      else if (v.length > 6)  v = v.replace(/^(\d{2})(\d{4})(\d+)$/,   '($1) $2-$3');
      else if (v.length > 2)  v = v.replace(/^(\d{2})(\d+)$/,           '($1) $2');
      telefone.value = v;
    });
  }

  /* ── Regras de validação ───────────────────────────── */
  const rules = {
    nome:     v => !v.trim() ? 'Nome é obrigatório.'
                : v.trim().length < 3 ? 'Digite ao menos 3 caracteres.' : '',
    email:    v => !v.trim() ? 'E-mail é obrigatório.'
                : !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) ? 'Informe um e-mail válido.' : '',
    assunto:  v => !v ? 'Selecione um assunto.' : '',
    mensagem: v => !v.trim() ? 'Mensagem é obrigatória.'
                : v.trim().length < 10 ? 'Mínimo de 10 caracteres.' : '',
    aceite:   c => !c ? 'Aceite a Política de Privacidade.' : '',
  };

  /* ── Aplica / limpa estado visual de um campo ──────── */
  function setFieldState(el, msg) {
    const errEl = document.getElementById(`erro-${el.id}`);
    el.classList.toggle('is-error', !!msg);
    el.classList.toggle('is-valid', !msg);
    if (errEl) errEl.textContent = msg;
    return !msg;
  }

  /* ── Valida ao sair do campo ───────────────────────── */
  if(form) {
    ['nome', 'email', 'assunto', 'mensagem'].forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      el.addEventListener('blur', () => {
        const msg = rules[id] ? rules[id](el.value) : '';
        setFieldState(el, msg);
      });
    });
  }

  /* ── Valida tudo antes de submeter ─────────────────── */
  function validateAll() {
    let ok = true;
    [['nome','nome'],['email','email'],['assunto','assunto'],['mensagem','mensagem']].forEach(([id, rule]) => {
      const el  = document.getElementById(id);
      const msg = rules[rule](el.value);
      if (!setFieldState(el, msg)) ok = false;
    });

    const aceiteEl  = document.getElementById('aceite');
    const aceiteMsg = rules.aceite(aceiteEl.checked);
    const aceiteErr = document.getElementById('erro-aceite');
    if (aceiteMsg) { if (aceiteErr) aceiteErr.textContent = aceiteMsg; ok = false; }
    else           { if (aceiteErr) aceiteErr.textContent = ''; }

    return ok;
  }

  /* ── Submit: valida e deixa o browser fazer o POST ─── */
  if(form) {
    form.addEventListener('submit', e => {
      if (!validateAll()) {
        e.preventDefault();
        const firstError = form.querySelector('.is-error');
        if (firstError) firstError.focus();
        return;
      }
      if(submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
      }
    });
  }

  /* ── Carousel ────────────────────────────────────────── */
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
