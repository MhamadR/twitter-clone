function hideElement(elem) {
  const element = document.querySelector(elem);
  element.classList.add("hide");
}

function showElement(elem) {
  const element = document.querySelector(elem);
  console.log(element);
  element.classList.remove("hide");
}
