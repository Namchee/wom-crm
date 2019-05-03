let dateOfBirth = flatpickr(".date-of-birth", {
  altInput: true,
  altFormat: 'F j, Y',
  dateFormat: "Ymd",
  maxDate: Date.now()
});

let gender = new SlimSelect({
  select: '#gender'
});

let alamat = new SlimSelect({
  select: '#alamat'
});

let marriage = new SlimSelect({
  select: '#marriage'
});

let form = document.querySelector('form');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  let namaClient = document.getElementById("nama").value;
  let nilaiInvestasi = Number(document.getElementById("nilai").value);
  let gendere = gender.selected();
  let alamate = alamat.selected();
  let statusKawine = marriage.selected();
  if (dateOfBirth.selectedDates.length == 0) {
    alert('Tanggal Lahir harus diisi');
    return;
  }
  let tanggalLahir = dateOfBirth.selectedDates[0].toJSON().slice(0, 10);
  
  let data = {
    namaClient,
    nilaiInvestasi,
    gender: gendere,
    alamat: alamate,
    statusKawin: statusKawine,
    tanggalLahir
  }

  sendRequest();
  fetch('/add_client', {
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
  })
});

function sendRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.add('active');
}

function endRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.remove('active');
}