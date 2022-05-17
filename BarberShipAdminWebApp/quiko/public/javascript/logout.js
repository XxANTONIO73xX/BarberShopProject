function logout(){ // cerrar session
    Swal.fire({
        title: '¿Estas seguro?', //este se cambia
        text: "Estas a punto de cerrar sesion!", //este se cambia
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Cerrar sesion!' //este se cambia
      }).then((result) => {
        if (result.isConfirmed) {
            console.log("cerrando..!!!");
            localStorage.removeItem("token");
            localStorage.removeItem("tipo");
            localStorage.removeItem("user");
            localStorage.removeItem("id")
            //localStorage.clear();
            location.href='http://localhost/quiko/public/';
        
        }
      })
      }
  
    if(!localStorage.getItem("user")){
    location.href='http://localhost/quiko/public/';
    }