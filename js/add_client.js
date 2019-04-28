let dateOfBirth = flatpickr(".date-of-birth", {
  altInput: true,
  altFormat: 'F j, Y',
  dateFormat: "Y-m-d"
});

let city = new SlimSelect({
  select: "#city",
  placeholder: 'Pilih Kota...'
});