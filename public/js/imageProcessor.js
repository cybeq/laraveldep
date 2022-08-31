let imgupload = document.getElementById('image-upload');
imgupload.addEventListener('change', function (e) {
    if (e.target.files) {
        let imageVal = e.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.createElement("img");
            img.onload = function (event) {
                // This line is dynamically creating a canvas element
                var canvas = document.createElement("canvas");



                var ctx = canvas.getContext("2d");


                //This line shows the actual resizing of image
                ctx.drawImage(img, 0, 0, 400, 350);


                //This line is used to display the resized image in the body
                var url = canvas.toDataURL(imageVal.type);
                document.getElementById("img-content").src = url;
            }
            img.src = e.target.result;

        }
        reader.readAsDataURL(imageVal);
    }
});



// function preview(){
//     let imageInput = document.getElementById('image-input');
//     let imgPreview = document.getElementById('preview');
//     imgPreview.src=URL.createObjectURL(imageInput .files[0]);
//     const canvas = document.getElementById("canvas");
//     canvas.height=200;
//     canvas.width=200;
//
//     let image = new Image();
//     image.src=URL.createObjectURL(imageInput .files[0]);
//
//
//
// }
