/*
 * Submit form listener
 */
var formSubmit = document.getElementsByName("submitConversion")[0];
formSubmit.addEventListener("submit", function(e) {
    
    checkedItems = document.getElementById("destinationOs").getElementsByTagName("input");
    
    var totalChecked = 0;
    for (n=0; n<checkedItems.length; n++) {
        if (checkedItems[n].checked) totalChecked ++;
    }
    
    if (totalChecked < 1) {
        alert("You must choose at least 1 OS to export");
        e.preventDefault();
    }
    
    return false;
});

/*
 * Change file icon listener
 */
var fileUpload = document.getElementsByName("icon")[0];

fileUpload.addEventListener("change", function () {
    return checkFile();
});

function checkFile() {
    file = fileUpload.files[0];
    if (checkFileSize(file) && checkFileMime(file)) {
        console.log("resizing");
        
        // Alternativa:
        //    var img = document.createElement("img");
        //    img.src = window.URL.createObjectURL(file);
        
        // Abrimos la imagen y preparamos un callback para cuando haya cargado
        var img = document.createElement("img");
        img.onload = function() { doResize(img); };
  
        // Cargamos en memoria la imagen
        var reader = new FileReader();
        reader.onload = function(e) { img.src = e.target.result }
        reader.readAsDataURL(file);
        
        console.log("resized");
        return true;
    }

    // ERROR
    fileUpload.value = "";
}

function checkFileSize(file) {
    if (file.size > MAX_FILE_SIZE) {
        alert("File \"" + file.name + "\" is too large");
        return false;
    }

    return true;
}

function checkFileMime(file) {
    return file.type.match(/image.*/);
}


/*
 * Real time conversion
 */
/*function readImage(file) {
    var input = file.target;

    var reader = new FileReader();
    reader.onload = function(){
      var dataURL = reader.result;
      var output = document.getElementById('output');
      output.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
}*/

/**
 * Redimensiona la imagen a los tamaños necesarios
 * @param {type} img
 * @returns {undefined}
 */
function doResize(img) {

    resize(img, 100, 300);

}

/**
 * Redimensiona la imagen a un tamaño especifico
 * @param {type} img
 * @param {type} toWidth
 * @param {type} toHeight
 * @link https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
 * @returns {undefined}
 */
function resize(img, toWidth, toHeight) {

    var MAX_WIDTH = 800;
    var MAX_HEIGHT = 600;
    
    var width = img.naturalWidth;
    var height = img.naturalHeight;

    if (width > height) {
      if (width > MAX_WIDTH) {
        height *= MAX_WIDTH / width;
        width = MAX_WIDTH;
      }
    } else {
      if (height > MAX_HEIGHT) {
        width *= MAX_HEIGHT / height;
        height = MAX_HEIGHT;
      }
    }
    
    canvas.width = width;
    canvas.height = height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0, width, height);
    ctx.fill();
    
    //document.getElementsByClassName("jumbotron")[0].append(img);
}