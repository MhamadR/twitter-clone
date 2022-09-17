function addClass(elem, className) {
  const element = document.querySelector(elem);
  element.classList.add(className);
}

function removeClass(elem, className) {
  const element = document.querySelector(elem);
  console.log(element);
  element.classList.remove(className);
}
