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
        resize(file, 300, 300);
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
  
function resize(file, toWidth, toHeight) {
    // THANKS TO: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
    console.log(file);
//    var img = document.createElement("img");
//    img.src = window.URL.createObjectURL(file);

    var img = document.createElement("img");
    var reader = new FileReader();
    reader.onload = function(e) {img.src = e.target.result}
    reader.readAsDataURL(file);

    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);

    var MAX_WIDTH = 800;
    var MAX_HEIGHT = 600;
    var width = img.width;
    var height = img.height;

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
    
    //document.getElementsByClassName("jumbotron")[0].append(img);
    
}