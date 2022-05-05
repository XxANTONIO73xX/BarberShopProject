function login() { //inicio login al dar clic al boton
    var url = "http://api.kikosbarbershop.online/public/auth";

    $.ajax({   //iniciar ajax para crar token   
        url: url,
        data: {
            "user": $("#user").val(),
            "password": $("#password").val(),
            "tipo": "administrador"
        },
        type: "POST",
        dataType: "json",
    })
        .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

            console.log("hola le di clic al boton")
            console.log(data)

            if (typeof data.error !== "string") {
                localStorage.setItem("token", data.token);
                localStorage.setItem("tipo", data.tipo);
                var user = JSON.parse(JSON.stringify(data.user));
                localStorage.setItem("user", user);
                localStorage.setItem("id", user["id"]);
                console.log("Encontro el usuario");
                location.href = "http://localhost/quiko/public/home"
            } else {
                alert(data.error);
            }


        })
        .fail(function (jqXHR, textStatus, errorThrown) { // si hay algun error, esta en textStatus

            console.log("La solicitud a fallado: " + textStatus);

        });
}