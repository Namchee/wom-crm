let regions = new DataTable("#region");
let regionForm = document.querySelector('.regioner');

let selector = new SlimSelect({
  select: '#city'
});

initializeRow();
regions.on('datatable.sort', initializeRow);
regions.on('datatable.search', initializeRow);

function initializeRow() {
  for (let row of regions.activeRows) {
    row.addEventListener('click', () => {
      // fetch, then
      sendRequest();
      let id = Number(row.querySelector('.hide-id').textContent);
      fetch(`/get_region/${id}`)
        .then(resp => {
          return resp.json();
        })
        .then(resp => {
          let modal = document.querySelector('#modal-info');
          let name = modal.querySelector('#reg-name');
          let head = modal.querySelector('#reg-name-head');
          let real_name = row.querySelector('#reg-real-name');
          let hid = document.createElement('input');
          hid.type = "hidden";
          hid.id = "reg-id";
          hid.value = id;
          name.textContent = real_name.textContent;
          head.textContent = real_name.textContent;

          let idSet = [];
          for (let id of resp) {
            idSet.push(id.idK);
          }
          selector.set(idSet);

          modal.classList.remove('remove');
          modal.classList.add('active');
          let overlay = modal.querySelector('.modal-overlay');
          let closeButton = modal.querySelector('.modal-close-button');
          modal.appendChild(hid);

          overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            name.textContent = '';
            head.textContent = '';
            modal.removeChild(hid);
          });

          closeButton.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.classList.add('remove');
            name.textContent = '';
            head.textContent = '';
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

regionForm.addEventListener('submit', (e) => {
  e.preventDefault();
  sendRequest();
  let data = {
    idR: document.querySelector('#reg-id').value,
    idK: selector.selected()
  };
  fetch('/edit_region', {
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