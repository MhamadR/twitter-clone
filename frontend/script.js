function addClass(elem, className) {
  const element = document.querySelector(elem);
  element.classList.add(className);
}

function removeClass(elem, className) {
  const element = document.querySelector(elem);
  element.classList.remove(className);
}

function toggleClass(elem, className) {
  const element = document.querySelector(elem);
  element.classList.toggle(className);
}
