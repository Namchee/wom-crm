let kotas = new SlimSelect({
  select: "#kotas",
  placeholder: 'Pilih Kota...'
});

let nama = document.querySelector('#namaRegion');

let form = document.querySelector('form');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  let kotasData = [];
  for (let value of kotas.selected()) {
    kotasData.push(Number(value));
  }

  let data = {
    namaRegion: nama.value,
    namakot: kotasData
  }

  sendRequest();
  fetch('/add_region', {
    method: 'POST',
    body: JSON.stringify(data)
  }).then(resp => {
    return resp.json();
  }).then(resp => {
    alert(resp.pesan);
  }).catch(err => {
    alert(err);
  }).finally(() => {
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