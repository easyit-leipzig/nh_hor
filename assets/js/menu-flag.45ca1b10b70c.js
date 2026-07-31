(() => {
  'use strict';

  const header = document.querySelector('.site-header');
  const sourceNav = document.querySelector('#main-navigation');
  if (!header || !sourceNav) return;

  const cssHref = (() => {
    const script = document.currentScript;
    if (!script || !script.src) return 'assets/css/menu-flag.css';
    return new URL('../css/menu-flag.css', script.src).href;
  })();

  if (!document.querySelector('link[data-menu-flag-css]')) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = cssHref;
    link.dataset.menuFlagCss = '1';
    document.head.appendChild(link);
  }

  const flag = document.createElement('button');
  flag.type = 'button';
  flag.className = 'menu-flag';
  flag.hidden = true;
  flag.setAttribute('aria-expanded', 'false');
  flag.setAttribute('aria-controls', 'floating-menu-panel');
  flag.setAttribute('aria-label', 'Header und Hauptmenü einblenden');
  flag.title = 'Header und Menü einblenden';
  flag.innerHTML = '<span class="menu-flag__cloth" aria-hidden="true"><span class="menu-flag__label">MENÜ</span></span>';

  const panel = document.createElement('section');
  panel.id = 'floating-menu-panel';
  panel.className = 'floating-menu-panel';
  panel.setAttribute('aria-label', 'Eingeblendete Hauptnavigation');
  panel.setAttribute('aria-hidden', 'true');

  const panelHeader = document.createElement('header');
  panelHeader.className = 'floating-menu-panel__header';

  const headingGroup = document.createElement('div');
  headingGroup.className = 'floating-menu-panel__heading-group';

  const logo = header.querySelector('img');
  if (logo) {
    const logoClone = logo.cloneNode(true);
    logoClone.removeAttribute('id');
    logoClone.className = 'floating-menu-panel__logo';
    logoClone.alt = logo.alt || 'easyIT Nachhilfe Leipzig';
    headingGroup.appendChild(logoClone);
  }

  const headingText = document.createElement('div');
  headingText.className = 'floating-menu-panel__heading-text';
  headingText.innerHTML = '<span class="floating-menu-panel__eyebrow">easyIT Nachhilfe Leipzig · Hauptnavigation</span><strong>Verstehen. Vorbereiten. Verbessern.</strong><span>Individuell vorbereitete Nachhilfe mit messbaren Lernerfolgen.</span>';
  headingGroup.appendChild(headingText);

  const close = document.createElement('button');
  close.type = 'button';
  close.className = 'floating-menu-panel__close';
  close.setAttribute('aria-label', 'Menü schließen');
  close.innerHTML = '<span aria-hidden="true">&times;</span>';

  panelHeader.append(headingGroup, close);

  const navWrap = document.createElement('div');
  navWrap.className = 'floating-menu-panel__navigation';

  const clonedNav = sourceNav.cloneNode(true);
  clonedNav.id = 'floating-main-navigation';
  clonedNav.querySelectorAll('[id]').forEach((node) => node.removeAttribute('id'));
  navWrap.appendChild(clonedNav);

  const backdrop = document.createElement('div');
  backdrop.className = 'floating-menu-backdrop';
  backdrop.hidden = false;

  panel.append(panelHeader, navWrap);
  document.body.append(backdrop, panel, flag);

  let open = false;

  const setOpen = (next) => {
    open = next;
    panel.classList.toggle('is-open', open);
    backdrop.classList.toggle('is-open', open);
    document.body.classList.toggle('floating-menu-open', open);
    panel.setAttribute('aria-hidden', open ? 'false' : 'true');
    flag.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) close.focus({ preventScroll: true });
  };

  flag.addEventListener('click', () => setOpen(!open));
  close.addEventListener('click', () => {
    setOpen(false);
    flag.focus({ preventScroll: true });
  });
  backdrop.addEventListener('click', () => setOpen(false));

  panel.addEventListener('click', (event) => {
    const link = event.target.closest('a');
    if (link) setOpen(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && open) {
      setOpen(false);
      flag.focus({ preventScroll: true });
    }
  });

  const updateFlag = () => {
    const rect = header.getBoundingClientRect();
    const headerGone = rect.bottom <= 0;
    flag.hidden = !headerGone;
    if (!headerGone && open) setOpen(false);
  };

  updateFlag();
  window.addEventListener('scroll', updateFlag, { passive: true });
  window.addEventListener('resize', updateFlag, { passive: true });
})();
