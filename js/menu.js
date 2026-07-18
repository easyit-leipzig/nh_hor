(() => {
  'use strict';

  const nav = document.querySelector('.main-nav');
  const mobileToggle = document.querySelector('.menu-toggle');
  const submenuButtons = [...document.querySelectorAll('.submenu-toggle')];
  const desktopQuery = window.matchMedia('(min-width: 901px)');

  const closeItem = (item) => {
    item.classList.remove('open');
    const button = item.querySelector(':scope > .submenu-toggle');
    if (button) button.setAttribute('aria-expanded', 'false');
    item.querySelectorAll('.has-submenu.open').forEach((child) => {
      child.classList.remove('open');
      child.querySelector(':scope > .submenu-toggle')?.setAttribute('aria-expanded', 'false');
    });
  };

  const closeSiblings = (item) => {
    [...item.parentElement.children].forEach((sibling) => {
      if (sibling !== item && sibling.classList.contains('has-submenu')) closeItem(sibling);
    });
  };

  submenuButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      const item = button.parentElement;
      const willOpen = !item.classList.contains('open');
      closeSiblings(item);
      item.classList.toggle('open', willOpen);
      button.setAttribute('aria-expanded', String(willOpen));
    });

    button.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeItem(button.parentElement);
        button.focus();
      }
    });
  });

  mobileToggle.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('open');
    mobileToggle.setAttribute('aria-expanded', String(isOpen));
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('.main-nav') && !event.target.closest('.menu-toggle')) {
      document.querySelectorAll('.has-submenu.open').forEach(closeItem);
      if (!desktopQuery.matches) {
        nav.classList.remove('open');
        mobileToggle.setAttribute('aria-expanded', 'false');
      }
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      document.querySelectorAll('.has-submenu.open').forEach(closeItem);
      if (!desktopQuery.matches) {
        nav.classList.remove('open');
        mobileToggle.setAttribute('aria-expanded', 'false');
      }
    }
  });

  desktopQuery.addEventListener('change', (event) => {
    if (event.matches) {
      nav.classList.remove('open');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
    document.querySelectorAll('.has-submenu.open').forEach(closeItem);
  });
})();
