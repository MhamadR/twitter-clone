function hideElement(elem, className) {
  const element = document.querySelector(elem);
  element.classList.add(className);
}

function showElement(elem, className) {
  const element = document.querySelector(elem);
  console.log(element);
  element.classList.remove(className);
}
