let cs = new DataTable("#client");

initializeRow();
cs.on('datatable.sort', initializeRow);
cs.on('datatable.search', initializeRow);

function initializeRow() {
  for (let row of cs.activeRows) {
    row.addEventListener('click', () => {
      // fetch, then
      let modal = document.querySelector('#modal-info');

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