document.addEventListener('DOMContentLoaded', function() {
  Scrollbar.init(document.documentElement, {
    damping: 0.09,
    renderByPixels: false
  });
});

const btn  = document.getElementById('mobile-menu-button');
const menu = document.getElementById('mobile-menu');
const iconPath = document.getElementById('menu-icon-path');

btn.addEventListener('click', () => {
  const isOpen = menu.classList.toggle('open');
  btn.setAttribute('aria-expanded', isOpen);

  if (isOpen) {
    iconPath.setAttribute('d', 'M6 18L18 6M6 6l12 12');
  } else {
    iconPath.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
  }
});