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
    if (checkFileSize(file) && checkFileExtension(file)) {
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

function checkFileExtension(file) {
    // TODO: Check extensions (must be received from php)
    return true;
}