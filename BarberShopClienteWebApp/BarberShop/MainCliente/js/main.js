window.addEventListener('scroll', function(){
    var header = document.querySelector('.navigation_bar');
    header.classList.toggle('active', window.scrollY >0);
})

function darkMode() {
    var element = document.body;
    element.classList.toggle("dark-mode");
}

var counter = 1; 
setInterval(function(){
    document.getElementById('radio' + counter).checked =true;
    counter ++;
    if(counter > 4) {
        counter = 1;
    }
}, 10000)

document.querySelector(".bars__menu").addEventListener("click", animateBars);

var line1__bars = document.querySelector(".line1__bars-menu");
var line2__bars = document.querySelector(".line2__bars-menu");
var line3__bars = document.querySelector(".line3__bars-menu");
var container__menu = document.querySelector(".container__menu")

function animateBars(){
    line1__bars.classList.toggle("activeline1__bars-menu");
    line2__bars.classList.toggle("activeline2__bars-menu");
    line3__bars.classList.toggle("activeline3__bars-menu");
    
    container__menu.classList.toggle("menu__active")

}

