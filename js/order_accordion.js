const btns = document.querySelectorAll('.toggle-accordion');
btns.forEach((btn) => {
  btn.addEventListener('click', (evt) => {
    const btnId = btn.dataset.accordionButton;

    const list = document.querySelector(`.order__list[data-accordion-elem="${btnId}"]`);
    list.classList.toggle('active');
    btn.classList.toggle('active');
  });
});