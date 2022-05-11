const input = document.querySelector("#inputGroupFile02");
let files;
var fileCurrent;

input.addEventListener('change', (e) => {
    e.preventDefault();
    files = e.target.files;
    res = showFiles(files);
    if(res == false){
    input.value = null;
    }
});

function showFiles(files){
    if(files.length === 1){
        console.log(files);
        console.log("Si es una imagen");
        res = processFile(files[0]);
        return res;
    }else{
        alert("No puedes enviar mas de una imagen");
        return false;
    }
}

function processFile(file){
    const docType = file.type;
    console.log(file.type);
    const validExtension = ['image/jpeg', 'image/jpg', 'image/png' ];

    if(validExtension.includes(docType)){
        const fileReader = new FileReader();
        fileReader.addEventListener('load', (e) =>{
            const fileUrl = fileReader.result;
            const preview = document.querySelector(".preview");
            const img = preview.querySelector('img');
            img.src = fileUrl
        });

        fileReader.readAsDataURL(file);
        return true;
    }else{
        alert("No es una imagen/archivo valido. Formatos permitidos: .jpg .jpeg .png");
        return false;
    }
}

/*var url = "http://api.kikosbarbershop.online/public"

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

    });  //fin de llenar tabla clientes*/