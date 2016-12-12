function showResult(str) {
	if (str.length == 0) {
		document.getElementById("ls").innerHTML="";
		return;
	}
	if (str.length > 2) {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else {
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById("ls").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","ls.php?search="+str,true);
		xmlhttp.send();
	}
}

function rc_action(action) {

	if (action == 'power') {
		if (!confirm('Power down now ?')) return false;
	}

	if (action == 'reboot') {
		if (!confirm('Reboot now ?')) return false;
	}

	if (action == 'sleep') {
		alert('Sorry, not supported yet :(');
	}

	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

	}

	xmlhttp.open("GET","rc.php?action=" + action);
	xmlhttp.send();
}

function rc_action_search(string) {
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.open("GET","rc.php?action=search&string=" + string);
	xmlhttp.send();
}