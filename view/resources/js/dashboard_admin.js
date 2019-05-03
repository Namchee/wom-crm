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
          let purge =  document.querySelector("#purge");
          usernameField.textContent = result.username;
          nameField.textContent = result.nama;
          joinField.textContent = new Date(result.tanggalGabung).toLocaleDateString();
          idField.textContent = id;
          purge.disabled = false;
          purge.addEventListener('click', purgeCS);

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
            purge.disabled = true;
            purge.removeEventListener('click');
          });

          closeButton.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            usernameField.textContent = '';
            nameField.textContent = '';
            idField.textContent = '';
            joinField.textContent = '';
            purge.disabled = true;
            purge.removeEventListener('click');
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

function purgeCS(e) {
  let message = confirm('Apakah anda yakin ingin menghapus Customer Service?');
  if (message) {
    let idField = document.querySelector('.cs-id');
    let data = {
      id: idField.textContent
    }

    sendRequest();
    fetch('/delete_cs', {
      method: 'POST',
      body: JSON.stringify(data)
    })
    .then(resp => {
      return resp.text();
    })
    .then(resp => {
      alert(resp.pesan);
      if (resp.status) {
        window.location.reload();
      }
    })
    .catch(err => {
      alert(err);
    })
    .finally(() => {
      endRequest();
    })
  }
}