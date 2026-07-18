nj.ready(() => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.horizontal-nav');
  const submenuLinks = document.querySelectorAll('.submenu-toggle');
  const closeAll = () => {
    nav?.classList.remove('is-open');
    document.querySelectorAll('.has-submenu.is-open').forEach(el => el.classList.remove('is-open'));
    toggle?.setAttribute('aria-expanded','false');
  };
  toggle?.addEventListener('click', () => {
    const open = nav?.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(Boolean(open)));
  });
  submenuLinks.forEach(link => link.addEventListener('click', event => {
    const parent = link.closest('.has-submenu');
    const mobile = window.matchMedia('(max-width:1050px)').matches;
    if (mobile || link.getAttribute('href') === '#') {
      event.preventDefault();
      const open = parent?.classList.toggle('is-open');
      link.setAttribute('aria-expanded', String(Boolean(open)));
    }
  }));
  document.addEventListener('keydown', e => { if(e.key === 'Escape') closeAll(); });
  window.addEventListener('resize', () => { if(window.innerWidth > 1050) closeAll(); });
});
