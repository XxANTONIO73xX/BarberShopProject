window.addEventListener('scroll', function(){
    var header = document.querySelector('.navigation_bar');
    header.classList.toggle('active', window.scrollY >0);
})

const colorSwitch = document.querySelector('#switch input[type="checkbox"]');
            function cambiaTema(ev){
                if(ev.target.checked){
                    document.documentElement.setAttribute('tema', 'light');
                } else {
                    document.documentElement.setAttribute('tema', 'dark');
                }
            }
            colorSwitch.addEventListener('change', cambiaTema);
