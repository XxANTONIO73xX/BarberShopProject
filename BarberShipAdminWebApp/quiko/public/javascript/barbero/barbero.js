var url = "http://api.kikosbarbershop.online/public"

$.ajax({   //iniciar ajax para crar token   
    url: url + '/barbero',
    data: {},
    type: "GET",
    dataType: "json",
    headers: {
        token: localStorage.getItem("token")
    }
})
    .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

        var rows = " ";
        console.log("info tabla")
        console.log(data)

        if (!data) {
            rows = "<h2 style='color:red; text-align:center;'>No hay registros</h2>";
        } else {
            data.barberos.forEach(r => {
                rows += `
                <tr>    
                <td>${r.id}</td>
                <td>${r.nombre}</td>
                <td>${r.apodo}</td>
                <td>${r.apellidos}</td>
                <td>${r.correo}</td>
                <td>${r.telefono}</td>
                <td>${r.barberia["nombre"]}</td>

                <td><a href= "" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></td>

                <td><a href= "" data-toggle="modal" data-target="#confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a></td>
                </tr>
        `;
            });
        }

        $("#table tbody").html(rows);

    });  //fin de llenar tabla clientes