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

const accordionItemHeaders = document.querySelectorAll(".accordion-item-header");
const accordionDatos = document.querySelectorAll(".accordion-cita-datos");


accordionItemHeaders.forEach(accordionItemHeaders => {
    accordionItemHeaders.addEventListener("click", event => {
        accordionItemHeaders.classList.toggle("active");
    });
});

accordionDatos.forEach(accordionDatos => {
    accordionDatos.addEventListener("click", event => {
        accordionDatos.classList.toggle("active");
    });    
});

function statusCita() {
    var statusCita = document.getElementById("status-label");
    var buttonStatusCita = document.getElementById("button-cancelar");

    if (statusCita.innerHTML === "ACTIVA") {
        statusCita.innerHTML = "PENDIENTE";
        buttonStatusCita.innerHTML = "Activar cita";
    } else {
        statusCita.innerHTML = "ACTIVA";
        buttonStatusCita.innerHTML = "Cancelar cita";
    }
}