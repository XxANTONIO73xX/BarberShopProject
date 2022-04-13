window.addEventListener('scroll', function(){
    var header = document.querySelector('.navigation_bar');
    header.classList.toggle('active', window.scrollY >0);
})

function darkMode() {
    var element = document.body;
    element.classList.toggle("dark-mode");
}
