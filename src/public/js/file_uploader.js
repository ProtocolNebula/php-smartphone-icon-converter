var fileUpload = document.getElementsByName("icon")[0];

fileUpload.addEventListener("change", function() {
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
		alert("File \""+file.name+"\" is too large");
		return false;
	}
	
	return true;
}

function checkFileExtension(file) {
	// TODO: Check extensions (must be received from php)
	return true;
}