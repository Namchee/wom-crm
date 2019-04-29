let client = new DataTable("#client");

let dateOfBirth = flatpickr(".date-of-birth", {
  altInput: true,
  altFormat: 'F j, Y',
  dateFormat: "Y-m-d"
});

let city = new SlimSelect({
  select: "#city",
  placeholder: 'Pilih Kota...'
});

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

let profile_pic = document.querySelector('.image-uploader');

profile_pic.addEventListener('input', () => {
  getBase64(profile_pic.files[0]).then((res) => {
    console.log(res);
  })
});

function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}