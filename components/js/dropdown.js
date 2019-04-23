document.addEventListener('DOMContentLoaded', () => {
  let dropdowns = document.querySelectorAll('.dropdown');

  for (let dropdown of dropdowns) {
    let content = dropdown.querySelector('.dropdown-content');

    window.addEventListener('click', e => dropdownState(e, dropdown));

    for (let choice of content.children) {
      choice.addEventListener('click', () => selectDropdown(dropdown, choice, content.children));
    }
  }
});

function dropdownState (e, elem) {
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

function selectDropdown (elem, choice, rest) {
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