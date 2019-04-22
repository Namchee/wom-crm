document.addEventListener('DOMContentLoaded', () => {
  let modalButtons = document.querySelectorAll('button.modal-trigger');
  console.log(modalButtons);

  for (let modalButton of modalButtons) {
    modalButton.addEventListener('click', () => {
      let modal = document.querySelector(`#${modalButton.dataset.target}`);

      modal.classList.add('active');
      let overlay = modal.querySelector('.modal-overlay');

      overlay.addEventListener('click', () => {
        modal.classList.remove('active');
        modal.classList.add('remove');
      });
    });
  }
});