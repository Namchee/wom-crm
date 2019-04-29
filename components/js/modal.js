function toggleModals() {
  let modalButtons = document.querySelectorAll('.modal-trigger');

  for (let modalButton of modalButtons) {
    modalButton.addEventListener('click', () => {
      let modal = document.querySelector(`#${modalButton.dataset.target}`);

      modal.classList.remove('remove');
      modal.classList.add('active');
      let overlay = modal.querySelector('.modal-overlay');
      let closeButton = modal.querySelector('.modal-close-button');

      overlay.addEventListener('click', () => {
        modal.classList.remove('active');
        modal.classList.add('remove');
      });

      closeButton.addEventListener('click', () => {
        modal.classList.remove('active');
        modal.classList.add('remove');
      });
    });
  }
}