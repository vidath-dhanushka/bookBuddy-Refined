function imageChanged(event) {
    let imgFile;
    let img = document.getElementById('preview')
    let reader = new FileReader();
    reader.onload = function () {
        imgFile = reader.result
        img.src = imgFile
        api.post("/book/upload-image", { image: imgFile }).then(r => {
            $("#filename").val(r.message)
        })
    }
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0])
        img.style.display = "block"

    } else {
        img.src.display = "none"
    }
}


// let url = window.location.pathname.split('/');
// let operation = url[url.length - 1];


// let add = document.querySelector('.add-book');
// let edit = document.querySelector('.edit-book');

// if (operation === 'addBook') {
//     console.log("inside if ")
//     add.style.display = "block";
//     edit.remove();
// }