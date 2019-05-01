let form = document.getElementById('login');

form.addEventListener('submit', login);

function login(e) {
  e.preventDefault();
  sendRequest();
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;
  let data = {
    user: username,
    password: password
  };

  fetch('/login', {
    method: "POST",
    body: JSON.stringify(data)
  }).then((resp) => {
    return resp.json();
  }).then(resp => {
    if (!resp.status) {
      throw resp.pesan;
    } else {
      window.location.href = '/dashboard';
    }
  }).catch(err => {
    alert(err);
  }).finally(() => {
    endRequest();
  });
}

function sendRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.add('active');
}

function endRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.remove('active');
}