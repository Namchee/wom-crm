let clients = new DataTable("#clients");

initializeRow();
clients.on('datatable.sort', initializeRow);
clients.on('datatable.search', initializeRow);

function initializeRow() {
  for (let row of clients.activeRows) {
    row.addEventListener('click', () => {
      // fetch, then
      sendRequest();
      let id = Number(row.querySelector('.hide-id').textContent);
      fetch(`/get_client/${id}`)
        .then(resp => {
          return resp.json();
        })
        .then(resp => {
          let modal = document.querySelector('#modal-info');
          let clientName = document.querySelector("#client-name");
          clientName.textContent = resp[0].namaClient;
          let statusKawin = document.querySelector("#client-marriage");
          statusKawin.textContent = (resp[0].statusKawin == 0) ? 'Single' : 'Married';
          let tanggalLahir = document.querySelector("#client-date");
          tanggalLahir.textContent = new Date(resp[0].tanggalLahir).toLocaleDateString();
          let nilaiInvest = document.querySelector('#client-price');
          nilaiInvest.textContent = resp[0].nilaiInvestasi;
          let alamat = document.querySelector("#client-kota");
          alamat.textContent = resp[0].namaKota;
          let gender = document.querySelector("#client-gender");
          gender.textContent = (resp[0].gender == 0) ? 'Pria' : 'Wanita';
          let umur = document.querySelector('#client-umur');
          umur.textContent = resp[0].umur;
          let pj = document.querySelector("#client-pj");
          pj.textContent = resp[0].nama;

          modal.classList.remove('remove');
          modal.classList.add('active');
          let overlay = modal.querySelector('.modal-overlay');
          let closeButton = modal.querySelector('.modal-close-button');

          overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            clientName.textContent = '';
            statusKawin.textContent = '';
            tanggalLahir.textContent = '';
            nilaiInvest.textContent = '';
            alamat.textContent = '';
            gender.textContent = '';
            umur.textContent = '';
          });

          closeButton.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            clientName.textContent = '';
            statusKawin.textContent = '';
            tanggalLahir.textContent = '';
            nilaiInvest.textContent = '';
            alamat.textContent = '';
            gender.textContent = '';
            umur.textContent = '';
          });
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          endRequest();
        })
    });
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