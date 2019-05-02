let email = document.querySelector('.email');
new Tagify(email);

let username = document.querySelector('#username');
let password = document.querySelector('#password');
let nama = document.querySelector('#nama');

let form = document.querySelector('#new_cs');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  let mailArr = [];
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

  let data = {
    username: username.value,
    password: password.value,
    nama: nama.value,
    email: mailArr
  }

  sendRequest();
  fetch('/add_cs', {
    method: 'POST',
    body: JSON.stringify(data)
  }).then((resp) => {
    return resp.json();
  }).then((resp) => {
    alert(resp.pesan);
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