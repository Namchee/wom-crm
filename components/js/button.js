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