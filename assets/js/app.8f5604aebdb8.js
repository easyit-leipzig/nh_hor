nj.ready(() => {
  const navToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.horizontal-nav');
  const submenuButtons = Array.from(document.querySelectorAll('.submenu-button'));
  const desktopQuery = window.matchMedia('(min-width: 1051px)');

  const setButtonLabel = (button, open) => {
    const base = button.textContent.replace(/[▾▴]/g, '').trim();
    if (button.classList.contains('submenu-button--label')) {
      button.setAttribute('aria-label', `${base}: Untermenü ${open ? 'schließen' : 'öffnen'}`);
    } else {
      const item = button.closest('.has-submenu');
      const link = item?.querySelector(':scope > .menu-entry > .menu-link');
      button.setAttribute('aria-label', `Untermenü ${link?.textContent.trim() || base} ${open ? 'schließen' : 'öffnen'}`);
    }
  };

  const setSubmenu = (button, open, focusFirst = false) => {
    const item = button.closest('.has-submenu');
    if (!item) return;
    item.classList.toggle('is-open', open);
    button.setAttribute('aria-expanded', String(open));
    setButtonLabel(button, open);
    if (open && focusFirst) {
      item.querySelector(':scope > .submenu-panel a, :scope > .submenu-panel button')?.focus();
    }
  };

  const closeDescendants = item => {
    item.querySelectorAll('.has-submenu.is-open').forEach(child => {
      child.classList.remove('is-open');
      const button = child.querySelector(':scope > .menu-entry > .submenu-button');
      if (button) {
        button.setAttribute('aria-expanded', 'false');
        setButtonLabel(button, false);
      }
    });
  };

  const closeAllSubmenus = (except = null) => {
    submenuButtons.forEach(button => {
      if (button !== except) setSubmenu(button, false);
    });
  };

  const closeNavigation = () => {
    nav?.classList.remove('is-open');
    navToggle?.setAttribute('aria-expanded', 'false');
    closeAllSubmenus();
  };

  navToggle?.addEventListener('click', () => {
    const open = nav?.classList.toggle('is-open') || false;
    navToggle.setAttribute('aria-expanded', String(open));
    navToggle.querySelector('.sr-only').textContent = open ? 'Menü schließen' : 'Menü öffnen';
    if (open) nav?.querySelector('a, button')?.focus();
  });

  submenuButtons.forEach(button => {
    setButtonLabel(button, false);

    button.addEventListener('click', event => {
      event.stopPropagation();
      const open = button.getAttribute('aria-expanded') !== 'true';
      const item = button.closest('.has-submenu');
      if (desktopQuery.matches) {
        const siblings = item?.parentElement?.children || [];
        Array.from(siblings).forEach(sibling => {
          if (sibling !== item && sibling.classList.contains('is-open')) {
            const siblingButton = sibling.querySelector(':scope > .menu-entry > .submenu-button');
            if (siblingButton) setSubmenu(siblingButton, false);
          }
        });
      }
      setSubmenu(button, open);
      if (!open && item) closeDescendants(item);
    });

    button.addEventListener('keydown', event => {
      const item = button.closest('.has-submenu');
      if (!item) return;
      if (event.key === 'ArrowDown' || event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        setSubmenu(button, true, event.key === 'ArrowDown');
      } else if (event.key === 'ArrowRight' && desktopQuery.matches) {
        event.preventDefault();
        setSubmenu(button, true, true);
      } else if (event.key === 'ArrowLeft' && desktopQuery.matches) {
        event.preventDefault();
        setSubmenu(button, false);
        button.focus();
      }
    });
  });

  nav?.addEventListener('keydown', event => {
    const focusable = Array.from(nav.querySelectorAll('a, button')).filter(el => el.offsetParent !== null);
    const index = focusable.indexOf(document.activeElement);

    if (event.key === 'Escape') {
      event.preventDefault();
      const item = document.activeElement?.closest('.has-submenu');
      const button = item?.querySelector(':scope > .menu-entry > .submenu-button');
      if (button && item.classList.contains('is-open')) {
        setSubmenu(button, false);
        button.focus();
      } else {
        closeNavigation();
        navToggle?.focus();
      }
    } else if ((event.key === 'ArrowDown' || event.key === 'ArrowUp') && index >= 0) {
      event.preventDefault();
      const direction = event.key === 'ArrowDown' ? 1 : -1;
      focusable[(index + direction + focusable.length) % focusable.length]?.focus();
    } else if (event.key === 'Home' && focusable.length) {
      event.preventDefault();
      focusable[0].focus();
    } else if (event.key === 'End' && focusable.length) {
      event.preventDefault();
      focusable[focusable.length - 1].focus();
    }
  });

  document.addEventListener('pointerdown', event => {
    if (!event.target.closest('.site-header')) closeAllSubmenus();
  });

  document.addEventListener('focusin', event => {
    if (!event.target.closest('.site-header')) closeAllSubmenus();
  });

  window.addEventListener('resize', () => {
    if (desktopQuery.matches) {
      nav?.classList.remove('is-open');
      navToggle?.setAttribute('aria-expanded', 'false');
    }
    closeAllSubmenus();
  });
});
