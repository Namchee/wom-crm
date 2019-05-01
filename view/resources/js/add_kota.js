let regions = new SlimSelect({
  select: "#regions",
  placeholder: 'Pilih Region...'
});

let nama = document.querySelector('#namaKota')

let form = document.querySelector('form');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  let regionData = [];
  for (let value of regions.selected()) {
    regionData.push(Number(value));
  }

  let data = {
    namaKota: nama.value,
    namareg: regionData
  }

  sendRequest();
  fetch('/add_kota', {
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