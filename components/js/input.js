function toggleInputs() {
  let inputs = document.querySelectorAll('.input-group > .input-field');

  for (let input of inputs) {
    input.addEventListener('blur', () => {
      if (input.value.length) {
        input.parentElement.classList.add('not-empty');
      } else {
        input.parentElement.classList.remove('not-empty');
      }
    });

    if (input.hasAttribute('required')) {
      input.addEventListener('input', () => {
        inputRequired(input);
      });
      input.addEventListener('blur', () => {
        inputRequired(input);
      });
    }

    if (input.hasAttribute('password-reveal')) {
      passwordReveal(input);
    }

    input.parentElement.addEventListener('click', (e) => {
      input.focus();
    });
  }
}

function inputRequired(elem) {
  let parent = elem.parentElement;

  if (elem.value.length > 0) {
    parent.classList.remove('input-error');

    let message = parent.querySelector('.input-message');
    let errorIcon = parent.querySelector('.error');
    if (message || errorIcon) {
      parent.removeChild(message);
      parent.removeChild(errorIcon);
    }
  } else {
    if (parent.querySelector('.input-message') === null) {
      parent.classList.add('input-error');
      parent.classList.add('icon-right');
  
      let icon = document.createElement('i');
      icon.classList.add('material-icons');
      icon.classList.add('error');
      icon.textContent = 'error';
      let message = document.createElement('span');
      message.classList.add('input-message');
      message.textContent = 'Please fill out this field';
      parent.appendChild(message);
      parent.appendChild(icon);
    }
  }
}

function passwordReveal(elem) {
  let revealer = document.createElement('i');
  revealer.classList.add('material-icons');
  revealer.classList.add('password-reveal');
  revealer.textContent = 'visibility';

  revealer.addEventListener('click', () => {
    if (elem.type === 'text') {
      revealer.textContent = 'visibility';
      elem.type = 'password';
    } else {
      revealer.textContent = 'visibility_off';
      elem.type = 'text';
    }
  });

  elem.parentElement.appendChild(revealer);
  elem.parentElement.classList.add('icon-right');
}