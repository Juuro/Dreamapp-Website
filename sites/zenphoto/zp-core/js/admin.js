/* Zenphoto administration javascript. */

function confirmDeleteAlbum(url, message1, message2) {
	if (confirm(message1)) {
		if (confirm(message2)) {
			window.location = url;
		}
	}
}

function confirmDeleteImage(url, message) {
	if (confirm(message)) {
		window.location = url;
	}
}

function addUploadBoxes(placeholderid, copyfromid, num) {
	for (i=0; i<num; i++) {
		jQuery('#'+copyfromid).clone().insertBefore('#'+placeholderid);
		window.totalinputs++;
		if (window.totalinputs >= 50) {
			jQuery('#addUploadBoxes').toggle('slow');
			return;
		}
	}
}

function albumSwitch(sel, unchecknewalbum, msg1, msg2) {
	var selected = sel.options[sel.selectedIndex];
	var albumtext = document.getElementById("albumtext");
	var publishtext = document.getElementById("publishtext");
	var albumbox = document.getElementById("folderdisplay");
	var titlebox = document.getElementById("albumtitle");
	var checkbox = document.getElementById("autogen");
	var newalbumbox = sel.form.newalbum;
	var folder = sel.form.folder;
	var exists = sel.form.existingfolder;

	if (selected.value == "") {
		newalbumbox.checked = true;
		newalbumbox.disabled = true;
		newalbumbox.style.display = "none";
	} else {
		if (unchecknewalbum) {
			newalbumbox.checked = false;
		}
		newalbumbox.disabled = false;
		newalbumbox.style.display = "";
	}

	var newalbum = selected.value == "" || newalbumbox.checked;
	if (newalbum) {
		albumtext.style.display = "block";
		publishtext.style.display = "block";
		albumbox.value = "";
		folder.value = "";
		titlebox.value = "";
		exists.value = false;
		checkbox.checked = true;
		document.getElementById("foldererror").style.display = "none";
		toggleAutogen("folderdisplay", "albumtitle", checkbox);
	} else {
		albumtext.style.display = "none";
		publishtext.style.display = "none";
		albumbox.value = selected.value;
		folder.value = selected.value;
		titlebox.value = selected.text;
		exists.value = true;
	}
	validateFolder(folder, msg1, msg2);
}


function contains(arr, key) {
	for (i=0; i<arr.length; i++) {
		if (arr[i].toLowerCase() == key.toLowerCase()) {
			return true;
		}
	}
	return false;
}

function updateFolder(nameObj, folderID, checkboxID, msg1, msg2) {
	var autogen = document.getElementById(checkboxID).checked;
	var folder = document.getElementById(folderID);
	var parentfolder = document.getElementById('albumselectmenu').value;
	if (parentfolder != '') parentfolder += '/';
	var name = nameObj.value;
	var fname = "";
	var fnamesuffix = "";
	var count = 1;
	if (autogen && name != "") {
		fname = name;

		fname = fname.replace(/[ÀÁÂÄÃÅàáâãå]/g, 'a');
		fname = fname.replace(/[Çç]/g, 'c');
		fname = fname.replace(/[ÈÉÊËèéêë]/g, 'e');
		fname = fname.replace(/[ÌÍÎÏìíîï]/g, 'i');
		fname = fname.replace(/[ÒÓÔÕØòóôõø]/g, 'o');
		fname = fname.replace(/[ŒœÖö]/g, 'oe');
		fname = fname.replace(/[Šš]/g, 's');
		fname = fname.replace(/[ÙÚÛùúû]/g, 'u');
		fname = fname.replace(/[Üü]/g, 'ue');
		fname = fname.replace(/[ÝŸýÿ]/g, 'y');
		fname = fname.replace(/ß/g, 'ss');
		fname = fname.replace(/[�?æä]/g, 'ae');
		fname = fname.replace(/[ÐðÞþ]/g, 'd');
		fname = fname.replace(/[Ññ]/g, 'n');

		fname = fname.toLowerCase();
		fname = fname.replace(/[\!@#$\%\^&*()\~`\'\"]/g, "");
		fname = fname.replace(/^\s+|\s+$/g, "");
		fname = fname.replace(/[^a-zA-Z0-9]/g, "-");
		fname = fname.replace(/--*/g, "-");
		while (contains(albumArray, parentfolder + fname + fnamesuffix)) {
			fnamesuffix = "-"+count;
			count++;
		}
	}
	folder.value = parentfolder + fname + fnamesuffix;
	validateFolder(folder, msg1, msg2);
}

function validateFolder(folderObj, msg1, msg2) {
	var errorDiv = document.getElementById("foldererror");
	var exists = document.uploadform.existingfolder.value != "false";
	var uploadBoxesDiv = document.getElementById("uploadboxes");
	var folder = folderObj.value;
	if (!exists && albumArray && contains(albumArray, folder)) {
		errorDiv.style.display = "block";
		errorDiv.innerHTML = msg1;
		uploadBoxesDiv.style.display = "none";
		return false;
	} else if ((folder == "") || folder.substr(folder.length-1, 1) == '/') {
		errorDiv.style.display = "block";
		errorDiv.innerHTML = msg2;
		uploadBoxesDiv.style.display = "none";
		return false;
	} else {
		errorDiv.style.display = "none";
		errorDiv.innerHTML = "";
		uploadBoxesDiv.style.display = "block";
		return true;
	}
}

function toggleAutogen(fieldID, nameID, checkbox) {
	var field = document.getElementById(fieldID);
	var name = document.getElementById(nameID);
	if (checkbox.checked) {
		window.folderbackup = field.value;
		field.disabled = true;
		updateFolder(name, fieldID, checkbox.id);
	} else {
		if (window.folderbackup && window.folderbackup != "")
			field.value = window.folderbackup;
			field.disabled = false;
	}
}


// Checks all the checkboxes in a group (with the specified name);
function checkAll(form, arr, mark) {
	for (i = 0; i <= form.elements.length; i++) {
		try {
			if(form.elements[i].name == arr) {
				form.elements[i].checked = mark;
			}
		} catch(e) {}
	}
}

function triggerAllBox(form, arr, allbox) {
	for (i = 0; i <= form.elements.length; i++) {
		try {
			if(form.elements[i].name == arr) {
				if(form.elements[i].checked == false) {
					allbox.checked = false; return;
				}
			}
		}
		catch(e) {}
	}
	allbox.checked = true;
}


function toggleBigImage(id, largepath) {
	var imageobj = document.getElementById(id);
	if (!imageobj.sizedlarge) {
		imageobj.src2 = imageobj.src;
		imageobj.src = largepath;
		imageobj.style.position = 'absolute';
		imageobj.style.zIndex = '1000';
		imageobj.sizedlarge = true;
	} else {
		imageobj.style.position = 'relative';
		imageobj.style.zIndex = '0';
		imageobj.src = imageobj.src2;
		imageobj.sizedlarge = false;
	}
}


function updateThumbPreview(selectObj) {
	if (selectObj) {
		var thumb = selectObj.options[selectObj.selectedIndex].style.backgroundImage;
		selectObj.style.backgroundImage = thumb;
	}
}

function update_direction(obj, element, element2) {
	no = obj.options[obj.selectedIndex].value;
	if((obj.options[obj.selectedIndex].value == 'Manual') || (obj.options[obj.selectedIndex].value == '')) {
		document.getElementById(element).style.display = 'none';
	}	else {
		document.getElementById(element).style.display = 'block';
	}
	document.getElementById(element2).style.display = 'none';
	if(no=='custom')
		document.getElementById(element2).style.display = 'block';
}

// Uses jQuery
function image_deleteconfirm(obj, id, msg) {
	toggleMoveCopyRename(id, '');
	if (confirm(msg)) {
		jQuery('#deletemsg'+id).show();
		obj.checked = true;
	}
}

// Uses jQuery
// Toggles the interface for move/copy (select an album) or rename (text
// field for new filename) or none.
function toggleMoveCopyRename(id, operation) {
	if (operation == '') {
		jQuery('#'+id+'-movecopydiv').hide();
		jQuery('#'+id+'-renamediv').hide();
		jQuery('#deletemsg'+id).hide();
		jQuery('#'+id+'-move').attr('checked',false);
		jQuery('#'+id+'-copy').attr('checked',false);
		jQuery('#'+id+'-rename').attr('checked',false);
		jQuery('#'+id+'-Delete').attr('checked',false);
	} else if (operation == 'movecopy') {
		jQuery('#'+id+'-movecopydiv').show();
		jQuery('#'+id+'-renamediv').hide();
		jQuery('#'+id+'-Delete').attr('checked',false);
		jQuery('#deletemsg'+id).hide();
	} else if (operation == 'rename') {
		jQuery('#'+id+'-movecopydiv').hide();
		jQuery('#'+id+'-renamediv').show();
		jQuery('#'+id+'-Delete').attr('checked',false);
		jQuery('#deletemsg'+id).hide();
	}
}

function toggleAlbumMoveCopyRename(prefix, operation) {
	if (operation == '') {
		jQuery('#a-'+prefix+'movecopydiv').hide();
		jQuery('#a-'+prefix+'renamediv').hide();
		jQuery('#a-'+prefix+'move').attr('checked',false);
		jQuery('#a-'+prefix+'copy').attr('checked',false);
		jQuery('#a-'+prefix+'rename').attr('checked',false);
	} else if (operation == 'movecopy') {
		jQuery('#a-'+prefix+'movecopydiv').show();
		jQuery('#a-'+prefix+'renamediv').hide();
	} else if (operation == 'rename') {
		jQuery('#a-'+prefix+'movecopydiv').hide();
		jQuery('#a-'+prefix+'renamediv').show();
	}
}

// Toggles the extra info in the admin edit and options panels.
function toggleExtraInfo(id, category, show) {
	var prefix = '';
	if (id != null && id != '') {
		prefix = '#'+category+'-'+id+' ';
	}
	if (show) {
		jQuery(prefix+'.'+category+'extrainfo').show();
		jQuery(prefix+'.'+category+'extrashow').hide();
		jQuery(prefix+'.'+category+'extrahide').show();
	} else {
		jQuery(prefix+'.'+category+'extrainfo').hide();
		jQuery(prefix+'.'+category+'extrashow').show();
		jQuery(prefix+'.'+category+'extrahide').hide();
	}
}

// used to toggle fields
function showfield(obj, fld) {
	no = obj.options[obj.selectedIndex].value;
	document.getElementById(fld).style.display = 'none';
	if(no=='custom')
		document.getElementById(fld).style.display = 'block';
}


