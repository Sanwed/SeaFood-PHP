const body = document.body;
const btn = document.querySelector('.nav-toggle');
const nav = document.querySelector('.nav');

btn.addEventListener('click', () => {
  nav.classList.toggle('active');
  body.classList.toggle('no-scroll');
})