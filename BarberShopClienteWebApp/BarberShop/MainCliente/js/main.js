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
