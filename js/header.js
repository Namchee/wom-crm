document.addEventListener('DOMContentLoaded', () => {
  let date = document.querySelector('#date');
  date.textContent = new Date().toLocaleString();

  setInterval(() => {
    date.textContent = new Date().toLocaleString();
  }, 500);
});