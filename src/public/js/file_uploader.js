// Global vars
var img; // Image uploaded
var ctx; // Canvas context
var zip; // Zip container

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

    // New javascript method! Forced from javascript
    // TODO: Check if "doResize" worked, else redirect to PHP
    doResize(img);
    //e.preventDefault();
    
    
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
        img = document.createElement("img");
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


/**
 * Redimensiona la imagen a los tamaños necesarios
 * @param {type} img
 * @returns {undefined}
 */


function doResize(img) {
    zip = new JSZip();
    
    // TODO: Foreach all files
    resize(img, 100, 300);
    //addToZip(name);
    
    // Generate ZIP file to download
    zip.generateAsync({type:"blob"})
    .then(function(content) {
        // see FileSaver.js
        saveAs(content, "Mobile-Icons.zip");
    });
}

function addToZip(name) {
    var save = new Image();
    save.src = canvas.toDataURL();
    
    // Read image from canvas
    //var imgContent = canvas.toDataURL("image/jpg");
    var imgContent = save.src.substr(save.src.indexOf(',')+1);
    
    // Add image to ZIP
    zip.file(name, imgContent, {base64: true});
    //var img = zip.folder("images");
    //img.file("smile.jpg", imgContent, {binary: true});
}