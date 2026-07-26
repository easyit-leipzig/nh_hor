(() => {
  'use strict';
  const gallery = document.querySelector('[data-career-gallery]');
  const lightbox = document.querySelector('[data-career-lightbox]');
  if (!gallery || !lightbox) return;

  const buttons = Array.from(gallery.querySelectorAll('[data-gallery-index]'));
  const image = lightbox.querySelector('[data-lightbox-image]');
  const caption = lightbox.querySelector('[data-lightbox-caption]');
  const closeButton = lightbox.querySelector('[data-lightbox-close]');
  const prevButton = lightbox.querySelector('[data-lightbox-prev]');
  const nextButton = lightbox.querySelector('[data-lightbox-next]');
  let index = 0;
  let lastFocus = null;

  const render = (nextIndex) => {
    index = (nextIndex + buttons.length) % buttons.length;
    const source = buttons[index].querySelector('img');
    const text = buttons[index].querySelector('span');
    image.src = source.currentSrc || source.src;
    image.alt = source.alt;
    caption.textContent = text ? text.textContent : '';
  };

  const open = (nextIndex) => {
    lastFocus = document.activeElement;
    render(nextIndex);
    lightbox.hidden = false;
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.classList.add('career-lightbox-open');
    closeButton.focus();
  };

  const close = () => {
    lightbox.hidden = true;
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('career-lightbox-open');
    if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
  };

  buttons.forEach((button) => button.addEventListener('click', () => open(Number(button.dataset.galleryIndex || 0))));
  closeButton.addEventListener('click', close);
  prevButton.addEventListener('click', () => render(index - 1));
  nextButton.addEventListener('click', () => render(index + 1));
  lightbox.addEventListener('click', (event) => { if (event.target === lightbox) close(); });
  document.addEventListener('keydown', (event) => {
    if (lightbox.hidden) return;
    if (event.key === 'Escape') close();
    if (event.key === 'ArrowLeft') render(index - 1);
    if (event.key === 'ArrowRight') render(index + 1);
  });
})();
