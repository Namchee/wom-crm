let cs = new DataTable("#cs");

initializeRow();
cs.on('datatable.sort', initializeRow);
cs.on('datatable.search', initializeRow);

function initializeRow() {
  for (let row of cs.activeRows) {
    row.addEventListener('click', () => {
      let id = Number(row.querySelector('.hide-id').textContent);

      sendRequest();
      fetch(`/get_cs/${id}`)
        .then((resp) => {
          return resp.json();
        }).then(result => {
          let usernameField = document.querySelector('.cs-username');
          let nameField = document.querySelector('.cs-name');
          let joinField = document.querySelector('.cs-join');
          let idField = document.querySelector('.cs-id');
          usernameField.textContent = result.username;
          nameField.textContent = result.nama;
          joinField.textContent = new Date(result.tanggalGabung).toLocaleDateString();
          idField.textContent = id;

          let modal = document.querySelector('#modal-info');

          modal.classList.remove('remove');
          modal.classList.add('active');
          let overlay = modal.querySelector('.modal-overlay');
          let closeButton = modal.querySelector('.modal-close-button');

          overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            usernameField.textContent = '';
            nameField.textContent = '';
            joinField.textContent = '';
            idField.textContent = '';
          });

          closeButton.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            usernameField.textContent = '';
            nameField.textContent = '';
            idField.textContent = '';
            joinField.textContent = '';
          });
        }).catch(err => {
          console.log(err);
        })
        .finally(() => {
          endRequest();
        });
    })
  }
}

function sendRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.add('active');
}

function endRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.remove('active');
}