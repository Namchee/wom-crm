document.addEventListener('DOMContentLoaded', () => {
  let inputs = document.querySelectorAll('.input-group > .input-field');

  for (let input of inputs) {
    input.addEventListener('blur', () => {
      if (input.value.length) {
        input.parentElement.querySelector('.input-label').classList.add('not-empty');
      } else {
        input.parentElement.querySelector('.input-label').classList.remove('not-empty');
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
});

function inputRequired(elem) {
  let parent = elem.parentElement;

  if (elem.value.length > 0) {
    parent.classList.remove('input-error');

    let message = parent.querySelector('.input-message');
    if (message)
      parent.removeChild(message);
  } else {
    parent.classList.add('input-error');

    if (parent.querySelector('.input-message') === null) {
      let message = document.createElement('span');
      message.classList.add('input-message');
      message.textContent = 'Please fill out this field';
      parent.appendChild(message);
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
}