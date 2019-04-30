function debounce(func, delay) {
  let inDebounce;
  inDebounce = undefined;
  return function () {
    let args, context;
    context = this;
    args = arguments;
    clearTimeout(inDebounce);
    return inDebounce = setTimeout(function () {
      return func.apply(context, args);
    }, delay);
  };
}

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
    let errorIcon = parent.querySelector('.error-icon');
    if (message || errorIcon) {
      parent.removeChild(message);
      parent.removeChild(errorIcon);
    }
  } else {
    if (parent.querySelector('.input-message') === null) {
      parent.classList.add('input-error');
      if (parent.querySelector('i.right-icon') === null) {
        parent.classList.add('icon-right');

        let icon = document.createElement('i');
        icon.classList.add('material-icons');
        icon.classList.add('right-icon');
        icon.classList.add('error-icon');
        icon.textContent = 'error';
        parent.appendChild(icon);
      }

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
  revealer.classList.add('right-icon');
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

function toggleModals() {
  let modalButtons = document.querySelectorAll('button.modal-trigger');

  for (let modalButton of modalButtons) {
    modalButton.addEventListener('click', () => {
      let modal = document.querySelector(`#modal`);

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

function toggleButtons() {
  let buttons = document.querySelectorAll('[ripple]');
  for (let button of buttons) {
    rippleContainer = document.createElement('div');
    rippleContainer.className = 'ripple--container';
    button.addEventListener('mousedown', addRipple);
    button.addEventListener('mouseup', debounce(cleanUp, 2000));
    button.rippleContainer = rippleContainer;
    button.appendChild(rippleContainer);
  }
}

function addRipple(e) {
  let pos, ripple, rippler, size, style, x, y;
  ripple = this;
  rippler = document.createElement('span');
  size = ripple.offsetWidth;
  pos = ripple.getBoundingClientRect();
  x = e.pageX - pos.left - (size / 2);
  y = e.pageY - pos.top - (size / 2);
  style = 'top:' + y + 'px; left: ' + x + 'px; height: ' + size + 'px; width: ' + size + 'px;';
  ripple.rippleContainer.appendChild(rippler);
  return rippler.setAttribute('style', style);
}

function cleanUp() {
  while (this.rippleContainer.firstChild) {
    this.rippleContainer.removeChild(this.rippleContainer.firstChild);
  }
}

function toggleNavbars() {
  let navbar = document.querySelector('.navbar');
  let date = document.querySelector('#date');
  date.textContent = moment().format('LLLL');

  setInterval(() => {
    date.textContent = moment().format('LLLL');
  }, 500);

  let prevScrollPos = window.pageYOffset;

  window.onscroll = () => {
    let currentScrollPos = window.pageYOffset;
    if (prevScrollPos > currentScrollPos) {
      navbar.style.top = '0';
    } else {
      navbar.style.top = '-10vh';
    }

    prevScrollPos = currentScrollPos;
  }
}

function toggleDropdowns() {
  let dropdowns = document.querySelectorAll('.dropdown');

  for (let dropdown of dropdowns) {
    let content = dropdown.querySelector('.dropdown-content');

    window.addEventListener('click', e => dropdownState(e, dropdown));

    for (let choice of content.children) {
      choice.addEventListener('click', () => selectDropdown(dropdown, choice, content.children));
    }
  }
};

function dropdownState(e, elem) {
  let label = elem.querySelector('.dropdown-toggler');
  let toggler = elem.querySelector('.dropdown-input');
  let symbol = elem.querySelector('.dropdown-icon');

  if (!toggler.checked && (e.target === label || e.target === toggler)) {
    toggler.checked = true;
    symbol.classList.add('active');
  } else {
    toggler.checked = false;
    symbol.classList.remove('active');
  }
}

function selectDropdown(elem, choice, rest) {
  for (let choice of rest) {
    choice.classList.remove('selected');
  }

  let value = choice.dataset.value;
  let content = choice.textContent;
  let display = elem.querySelector('.dropdown-value');

  choice.classList.add('selected');
  elem.dataset.value = value;
  display.textContent = content;
}

function autoInit() {
  let buttons = document.querySelector('.button');
  let inputs = document.querySelector('.input-group');
  let dropdowns = document.querySelector('.dropdown');
  let navbars = document.querySelector('.navbar');
  let modals = document.querySelector('.modal');

  if (buttons) {
    toggleButtons();
  }

  if (inputs) {
    toggleInputs();
  }

  if (dropdowns) {
    toggleDropdowns();
  }

  if (navbars) {
    toggleNavbars();
  }

  if (modals) {
    toggleModals();
  }
}

document.addEventListener('DOMContentLoaded', () => {
  autoInit();
})