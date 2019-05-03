let email = document.querySelector('.email');
new Tagify(email);

let username = document.querySelector('#username');
let oldPassword = document.querySelector('#oldpass');
let newPassword = document.querySelector("#newpass");
let nama = document.querySelector('#nama');

let form = document.querySelector('#edit-profile');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  let mailArr = [];
  if (!email.value) {
    alert('E-mail tidak boleh kosong');
    return;
  }
  for (let emaile of JSON.parse(email.value)) {
    if (!isEmail(emaile.value)) {
      alert(`E-mail '${emaile.value}' bukan merupakan e-mail`);
      return;
    } else {
      mailArr.push(emaile.value);
    }
  }

  if (mailArr.length == 0) {
    alert(`E-mail harus diisi`);
    return;
  }

  if (newPassword.value.length != 0 && newPassword.value.length < 4) {
    alert('Panjang password baru minimal 4 karakter');
    newPassword.focus();
    return;
  }

  let data = {
    user: username.value,
    oldpass: oldPassword.value,
    newpass: newPassword.value,
    nama: nama.value,
    email: mailArr
  }

  sendRequest();
  fetch('/profile_settings', {
    method: 'POST',
    body: JSON.stringify(data)
  }).then((resp) => {
    return resp.json();
  }).then((resp) => {
    alert(resp.pesan);
    if (resp.status) {
      window.location.reload();
    }
  }).catch((err) => {
    alert(err);
  }).finally(() => {
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

function isEmail(email) {
	return /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/.test( email );	
}