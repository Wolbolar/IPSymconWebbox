// JavaScript Document
/*erst Dokument laden dann ausführen alles innerhalb von ready einfügen */
$(document).ready(function(){

<!-- Request Senden und Daten von PHP Seite abholen -->
	var request = false;

	// Request senden
	function setRequest(id, option) {
		// Request erzeugen
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest(); // Mozilla, Safari, Opera
		} else if (window.ActiveXObject) {
			try {
				request = new ActiveXObject('Msxml2.XMLHTTP'); // IE 5
			} catch (e) {
				try {
					request = new ActiveXObject('Microsoft.XMLHTTP'); // IE 6
				} catch (e) {}
			}
		}

		// überprüfen, ob Request erzeugt wurde
		if (!request) {
			alert("Kann keine XMLHTTP-Instanz erzeugen");
			return false;
		} else {
			//var url = "../cmd/dreambox/status1.php";
			var url = "../cmd/dreambox/ipsdreambox.php";
			// Name auslesen
			//Prüfen ob Schalter oder Event
			if (id == "reload") {
				//alert('Es wurde auf reload gesendet');
				var value = "reload";
				}
			//Wert des Schalters auslesen	
			else {
				//alert('Es wurde der Slider benutzt');
				var value = $( '#'+id ).val();
				}
			
			//var value = document.getElementById('source_'+id).innerHTML;
			// Option auslesen
			var option = 1;
			//var infotext = document.getElementById('option_0'+option).innerHTML;
			// Request öffnen
			request.open('post', url, true);
			// Requestheader senden
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			// Request senden
			request.send("value="+value+"&option="+option);
			// Request auswerten
			request.onreadystatechange = function() {
				interpretRequest(id, option);
			};
		}
	}

	// Request auswerten
	function interpretRequest(id, option) {
		switch (request.readyState) {
			// wenn der readyState 4 und der request.status 200 ist, dann ist alles korrekt gelaufen
			case 4:
				if (request.status != 200) {
					alert("Der Request wurde abgeschlossen, ist aber nicht OK\nFehler:"+request.status);
				} else {
					// Hier muss der Request ausgewertet werden und dem passenden Element zugewiesen werden
					// den Inhalt des Requests in das passende <div> schreiben
					
					// Antwort des Servers -> als XML-Dokument
					var xmlDoc	= request.responseXML;
					// Name aus dem XML-Dokument herauslesen
					var newvalue	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('value');
					// Bildurl aus dem XML-Dokument herauslesen
					var picon	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('image');
					// Alternativtext aus dem XML-Dokument herauslesen
					var alternate	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('alternate');
					// Bild erstellen
					var image	= "<img src=\""+picon+"\" alt=\""+picon+"\" />";
					
					// Prüfen was der Response ist und abhäng davon Aktion ausführen
					//Dreambox an
					//if (newvalue == "on") {
					//	$( "#flipdreamboxstatus").val(newvalue).flipswitch('refresh');
					//	$( "#aktuellerDreamboxstatus" ).html(newvalue);
					//	}
					//Dreambox aus
					//else if (newvalue == "off") {
						/* Flipswitch Status setzten */
					//	$( "#flipdreamboxstatus").val(newvalue).flipswitch('refresh');
					//	$( "#aktuellerDreamboxstatus" ).html(newvalue);
					//	}
					// kein Sender aktiv
					//else if (newvalue == "unbekannt") {
					//	$( "#currentchannel" ).html(newvalue);
					//	}
					// Alle gelieferten Variablen aktualisieren
					//else {
					//	$( "#currentchannel" ).html(newvalue);
					//	}
					$( "#aktuellerDreamboxstatus" ).html(newvalue);
					//document.getElementById('aktuellerDreamboxstatus').innerHTML = "Status der Dreambox ist "+newvalue;
					//$( "#currentchannel" ).html(currentchannel);
								
					
					
				}
				break;
			default:
				break;
		}
	}

	// einem HTML-Tag ein Attribut anhängen
	function addAttribute(object, nr) {
		object.setAttribute('id', 'option_'+nr, 0);
	}
	
/* Auf Mouseklick reagieren und Reload*/
	$('#reload').click(function(){
    setRequest('reload', 1);
	//alert('Es wurde auf reload geklickt');
	});	


// Funtionen zum Übergeben der Variablen aus PHP

	//Sender
	function aktuellerSender(currentchannel){
	//var currentchannel	= "Sender aktualisiert";
	$( "#currentchannel" ).html(currentchannel);	
	}

//noch unklar wie mit Seite starten
	// Sender
	var currentchannel	= "Aktueller Sender";
	$( "#currentchannel" ).html(currentchannel);
	
	// Sendungstitel
	var title	= "Aktuelle Sendung";
	$( "#title" ).html(title);
	
	// Startzeit
	var start	= "Aktuelle Startzeit";
	$( "#start" ).html(start);
	
	// Endzeit
	var ende	= "Aktuelle Endzeit";
	$( "#ende" ).html(ende);
	
	// Dauer
	var dauer	= "Aktuelle Dauer";
	$( "#dauer" ).html(dauer);
	
	// Vorbei
	var vorbei	= "Aktuelle Vorbei";
	$( "#vorbei" ).html(vorbei);
	
	// Verbleibend
	var verbl	= "Aktuelle Verbleibend";
	$( "#verbl" ).html(verbl);
	
	// Beschreibung
	var description	= "Aktuelle Beschreibung";
	$( "#description" ).html(description);
	
	// Fortschritt
	var fortschritt	= "Aktuelle Fortschritt";
	$( "#fortschritt" ).html(fortschritt);
	
	// Endeint
	var endeint	= "Aktuelle endeint";
	$( "#endeint" ).html(endeint);
	
	// sref
	var sref	= "Aktuelle sref";
	$( "#sref" ).html(sref);
	
	// pref
	var pref	= "Aktuelle pref";
	$( "#pref" ).html(pref);
	
	// snrdb
	var snrdb	= "Aktuelle snrdb";
	$( "#snrdb" ).html(snrdb);
	
	// snr
	var snr	= "Aktuelle snr";
	$( "#snr" ).html(snr);
	
	// ber
	var ber	= "Aktuelle ber";
	$( "#ber" ).html(ber);
	
	// acg
	var acg	= "Aktuelle acg";
	$( "#acg" ).html(acg);
	
	//---------------------------------
	
	// Schalter für Dreambox
	
	// Status
	 $("#dreamboxstatus").change(function() {
               var dreambox_statusflip = $("#flipdreamboxstatus").val();
               // Sendet Request bei Ändern des Status
			   setRequest('flipdreamboxstatus', 1);
			   });
	
	// Schreibt den aktuellen Status als Text
	
	
	//------------------------
	//Umschalten
	$('#ZDF').click(function(){
	//setRequest('ZDF', 1);
	alert('Es wurde auf ZDF geklickt');
	});
		
	$('#ARD').click(function(){
	setRequest('ARD', 1);
	});	

});