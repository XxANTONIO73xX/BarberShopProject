function getCorte() {
    var url = 'http://api.kikosbarbershop.online/public/corte'
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        dataType: "json",
        headers: {
            token: localStorage.getItem("token")
        }
    })
        .done(function (data, textStatus, jqXHR) { // lo que regresamos desde la API esta en data

            var rows = " ";
            console.log("info select corte")
            console.log(data)

            data.cortes.forEach(r => {
                $('#idCorte').append("<option value='" + r.id + "'>" + r.nombre + "</option>")
            });

        });
}