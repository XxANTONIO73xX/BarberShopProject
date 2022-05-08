window.addEventListener('scroll', function(){
    var header = document.querySelector('.navigation_bar');
    header.classList.toggle('active', window.scrollY >0);
})

document.querySelector(".bars__menu").addEventListener("click", animateBars);

var line1__bars = document.querySelector(".line1__bars-menu");
var line2__bars = document.querySelector(".line2__bars-menu");
var line3__bars = document.querySelector(".line3__bars-menu");
var container__menu = document.querySelector(".container__menu");

function animateBars(){
    line1__bars.classList.toggle("activeline1__bars-menu");
    line2__bars.classList.toggle("activeline2__bars-menu");
    line3__bars.classList.toggle("activeline3__bars-menu");
    container__menu.classList.toggle("menu__active");
}

var btnModal = document.querySelector('.button-agendar-cita');
var modalBg = document.querySelector('.modal-bg');
var modalClose = document.querySelector('.modal-close');

btnModal.addEventListener('click', function(){
    modalBg.classList.add('bg-active');
    console.log("si estoy jalando xd");
});

modalClose.addEventListener('click', function(){
    modalBg.classList.remove('bg-active');
});
