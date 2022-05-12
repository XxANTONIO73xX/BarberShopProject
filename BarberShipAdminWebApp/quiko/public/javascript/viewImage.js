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