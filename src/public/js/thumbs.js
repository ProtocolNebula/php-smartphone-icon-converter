/**
 * This file convert image to other sizes
 * @type type
 */

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
 * Resize the image to specific size
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
    ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0, width, height);
    ctx.fill();
    
    //document.getElementsByClassName("jumbotron")[0].append(img);
}