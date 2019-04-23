document.addEventListener('DOMContentLoaded', () => {
  let navbar = document.querySelector('.navbar');
  let date = document.querySelector('#date');
  date.textContent = new Date().toLocaleString();

  setInterval(() => {
    date.textContent = new Date().toLocaleString();
  }, 500);

  let prevScrollPos = window.pageYOffset;

  window.onscroll = () => {
    let currentScrollPos = window.pageYOffset;
    if (prevScrollPos > currentScrollPos) {
      navbar.style.top = '0';
    } else {
      navbar.style.top = '-10vh';
    }

    prevScrollPos = currentScrollPos;
  }
});