let clients = new DataTable("#clients");
let form = document.querySelector('form');

let gender = new SlimSelect({
  select: '#gender'
});

let alamat = new SlimSelect({
  select: '#alamat'
});

let marriage = new SlimSelect({
  select: '#marriage'
});

let dateOfBirth = flatpickr(".date-of-birth", {
  altInput: true,
  altFormat: 'F j, Y',
  dateFormat: "Ymd",
  maxDate: Date.now()
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
      fetch(`/get_client/${id}`)
        .then(resp => {
          return resp.json();
        })
        .then(resp => {
          let modal = document.querySelector('#modal-info');
          let nama = document.querySelector('#nama');
          let nilai = document.querySelector('#nilai');
          nama.value = resp[0].namaClient;
          nama.dispatchEvent(new CustomEvent('change'));
          nilai.value = Number(resp[0].nilaiInvestasi);
          nilai.dispatchEvent(new CustomEvent('change'));
          gender.set(resp[0].gender);
          alamat.set(resp[0].idK);
          marriage.set(resp[0].statusKawin);
          dateOfBirth.setDate(resp[0].tanggalLahir, true, "Y-m-d");

          let ide = document.createElement('input');
          ide.id = "client-id";
          ide.type = 'hidden';
          ide.value = id;

          modal.classList.remove('remove');
          modal.classList.add('active');
          let overlay = modal.querySelector('.modal-overlay');
          let closeButton = modal.querySelector('.modal-close-button');
          modal.appendChild(ide);

          overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            modal.removeChild(ide);
            nama.value = '';
            nilai.value = '';
          });

          closeButton.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            modal.removeChild(ide);
            nama.value = '';
            nilai.value = '';
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

form.addEventListener('submit', (e) => {
  e.preventDefault();
  let nama = document.querySelector('#nama');
  let nilai = document.querySelector('#nilai');
  let id = document.querySelector("#client-id");
  let tanggalLahir = dateOfBirth.selectedDates[0].toJSON().slice(0, 10);

  let data = {
    idC: id.value,
    namaClient: nama.value,
    gender: gender.selected(),
    nilaiInvestasi: Number(nilai.value),
    statusKawin: marriage.selected(),
    alamat: alamat.selected(),
    tanggalLahir
  }
  sendRequest();
  fetch('/edit_client', {
    method: 'POST',
    body: JSON.stringify(data)
  })
  .then(resp => {
    return resp.json();
  })
  .then(resp => {
    alert(resp.pesan);
  })
  .catch(err => {
    alert(err);
  })
  .finally(() => {
    endRequest();
  });
})

function sendRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.add('active');
}

function endRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.remove('active');
}