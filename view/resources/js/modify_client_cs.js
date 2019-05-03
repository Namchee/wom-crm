let clients = new DataTable("#clients");
let clientForm = document.querySelector('.client-form');

let selector = new SlimSelect({
  select: '#cs'
});

initializeRow();
clients.on('datatable.sort', initializeRow);
clients.on('datatable.search', initializeRow);

function initializeRow() {
  for (let row of clients.activeRows) {
    row.addEventListener('click', () => {
      // fetch, then
      sendRequest();
      let id = Number(row.querySelector('.hide-id').textContent);
      fetch(`/get_client_mod/${id}`)
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

          selector.set(resp[0].idU);

          let hid = document.createElement('input');
          hid.type = "hidden";
          hid.id = "client-id";
          hid.value = id;

          modal.classList.remove('remove');
          modal.classList.add('active');
          let overlay = modal.querySelector('.modal-overlay');
          let closeButton = modal.querySelector('.modal-close-button');
          modal.appendChild(hid);

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
            modal.removeChild(hid);
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
            modal.removeChild(hid);
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

clientForm.addEventListener('submit', (e) => {
  e.preventDefault();
  sendRequest();
  let data = {
    idClient: document.querySelector('#client-id').value,
    idCS: selector.selected()
  };
  fetch('/modify_client_cs', {
    method: 'POST',
    body: JSON.stringify(data)
  })
    .then(resp => {
      return resp.json();
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
    });
});

function sendRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.add('active');
}

function endRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.remove('active');
}