function logout(){ // cerrar session

    console.log("cerrando..!!!");
    localStorage.removeItem("token");
    localStorage.removeItem("tipo");
    localStorage.removeItem("user");
    localStorage.removeItem("id")
    //localStorage.clear();
    location.href="http://localhost/quiko/public/";

    }

    if(!localStorage.getItem("user")){
    location.href="http://localhost/quiko/public/";
    }