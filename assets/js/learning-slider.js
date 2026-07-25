
document.addEventListener('DOMContentLoaded', () => {
  const slider = document.querySelector('.hero-slider');
  if (!slider) return;

  const slides = [...slider.querySelectorAll('.hero-slider__slide')];
  const dots = [...slider.querySelectorAll('.hero-slider__dots button')];
  const previous = slider.querySelector('.hero-slider__button--prev');
  const next = slider.querySelector('.hero-slider__button--next');
  const pause = slider.querySelector('.hero-slider__pause');

  if (slides.length < 2) return;

  let index = 0;
  let paused = false;
  let timer = null;

  const show = (newIndex) => {
    index = (newIndex + slides.length) % slides.length;
    slides.forEach((slide, i) => slide.classList.toggle('is-active', i === index));
    dots.forEach((dot, i) => {
      dot.classList.toggle('is-active', i === index);
      dot.setAttribute('aria-current', i === index ? 'true' : 'false');
    });
  };

  const start = () => {
    window.clearInterval(timer);
    if (!paused && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      timer = window.setInterval(() => show(index + 1), 6500);
    }
  };

  previous?.addEventListener('click', () => { show(index - 1); start(); });
  next?.addEventListener('click', () => { show(index + 1); start(); });
  dots.forEach((dot, i) => dot.addEventListener('click', () => { show(i); start(); }));

  pause?.addEventListener('click', () => {
    paused = !paused;
    pause.setAttribute('aria-pressed', paused ? 'true' : 'false');
    pause.textContent = paused ? 'Weiter' : 'Pause';
    start();
  });

  slider.addEventListener('mouseenter', () => window.clearInterval(timer));
  slider.addEventListener('mouseleave', start);
  slider.addEventListener('focusin', () => window.clearInterval(timer));
  slider.addEventListener('focusout', start);

  show(0);
  start();
});
