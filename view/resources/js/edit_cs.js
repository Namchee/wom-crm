let client = new DataTable("#cs");
let email = new Tagify(document.querySelector(".email"));

initializeRow();
client.on('datatable.sort', initializeRow);
client.on('datatable.search', initializeRow);

function initializeRow() {
  for (let row of client.activeRows) {
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