
document.addEventListener('DOMContentLoaded', () => {
  const buttons = [...document.querySelectorAll('.filter')];
  const cards = [...document.querySelectorAll('.testimonial')];

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter;

      buttons.forEach((item) => item.classList.remove('is-active'));
      button.classList.add('is-active');

      cards.forEach((card) => {
        const tags = (card.dataset.tags || '').split(' ');
        card.hidden = filter !== 'all' && !tags.includes(filter);
      });
    });
  });
});
