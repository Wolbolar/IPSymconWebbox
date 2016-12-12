/// JavaScript Document
//--------------------------------------------------------------------------
/*erst Dokument laden dann ausführen alles innerhalb von ready einfügen */

$(document).ready(function(){

//Nach Start initial aktuellen Status abfragen und Variablen aktualisieren
"use strict";
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'post', 'DenonVolumeSlider=Vol?');

// Holt Initial Dreambox Daten
//Weiter Differnzieren damit klar ist welche Daten zurückgeliefert werden Variablen dürfen für jede Anfrage andere sein sonst werden bei rückgabe werte überschrieben.
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=status?');
ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=epgnow');

// Elemente verbergen
//$("#currentvolume").hide();

//aktuelle Lautstärke
//$("#DenonVolumeSlider").val(slider_value);
//$("#DenonVolumeSlider").flipswitch('refresh');	

/* Auf Mouseklick reagieren */
	 $('#kanaltest').click(function(){
    	alert('Es wurde auf Kanalliste geklickt');
		ajaxrequest('ipsrequestneu.php', 'get', 'command=kanalliste');
	
    	});	


// Slider beim Bewegen aktualisieren
// Sendet Request beim Ändern der Lautstärke
         
          $("#DenonVolumeSlider").change(function() {
          var slider_value = $("#DenonVolumeSlider").val();
		  $( "#currentvolume" ).html(slider_value + " %");
          // Sendet Request bei Ändern der Lautstärke
		  ajaxrequest("cmd/dreambox/ipsrequestneu.php", "post", "DenonVolumeSlider="+slider_value);
		          
          });
		  
// Sendet Dreambox Status		  
 			$("#dreamboxstatus").change(function() {
            var dreambox_statusflip = $("#flipdreamboxstatus").val();
            // Sendet Request bei Ändern des Status
			alert (dreambox_statusflip+" gesendet");
            ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command='+dreambox_statusflip);
            }); 
          


//Ajax aufrufen
	function ajaxrequest(action, method, data)
		{
			// Der eigentliche AJAX Aufruf
			$.ajax({
				url : action,
				type : method,
				//contentType: "application/x-www-form-urlencoded; charset=UTF-8";
				data : data,
				//dataType: "xml",
			}).done(function (data) {
				// Bei Erfolg
					alert("Erfolgreich:\n XML Response:\n" + data);
					
					//Daten auswerten
					// Antwort des Servers -> als XML-Dokument
					e2response(data);	
					return data;
			}).fail(function() {
				// Bei Fehler
				alert("Fehler!");
				
			}).always(function() {
				// Immer
				 //alert("Beendet!");
				// Funktionen bei Beenden
				//cue the page loader
				//$.mobile.loading( 'hide' );
			});
		}


//Formular für Ajax 
	$("form").submit(function(event) {
		// Das eigentliche Absenden verhindern
		event.preventDefault();
		//cue the page loader
		//$.mobile.loading( 'show' );
		// Das sendende Formular und die Metadaten bestimmen
		var form = $(this); // Dieser Zeiger $(this) oder $("form"), falls die ID form im HTML exisitiert, klappt übrigens auch ohne jQuery ;)
		var action = form.attr("action"), // attr() kann enweder den aktuellen Inhalt des gennanten Attributs auslesen, oder setzt ein neuen Wert, falls ein zweiter Parameter gegeben ist
			method = form.attr("method"),
			data   = form.serialize(); // baut die Daten zu einem String nach dem Muster vorname=max&nachname=Müller&alter=42 ... zusammen
			//alert (data);
			ajaxrequest(action, method, data);
	});
	
//XML Response auswerten
//*
//Dreambox
// Auf command prüfen und die passende function aufrufen 
	function e2response(data)
		{
			// Dreambox Funktionsanfrage prüfen und passende Auswertung aufrufen
			//alert ("e2response: Ok");
			//Abschnitt geht nicht Volume und Command nicht gefunden
			
			//Volume wird nicht ausgegeben
			/*
			$(data).find('denonevent').each(function()
				{
					var volume = $(this).find('denonvolume').text();
					//Lautstärke setzen
					$("#DenonVolumeSlider").val(volume);
					$("#DenonVolumeSlider").flipswitch('refresh');
					$( "#currentvolume" ).html(volume + " %");
					alert ("Lautstärke : "+volume);			
					return volume;
				});	
				*/
				//alert(volume);
	
			/*
			var command = $(data).find('e2event').each(function(){
					var command = $(this).find('command').text();
					$("senddreamboxcommand").html(command);
					alert ("Dreambox Aufruf : " + command);
					return command;
 				});
			
			
			//alert (command);
				
			
		
			//schleife geht nicht
			if (command !== "")
			{
				//Ausführen wenn nicht Lautstärke zurückgegeben wurde bzw. bei epg now Anforderung
				alert ("Command gefunden : "+command);
				e2epgnow(data);
			}
			*/	
			 //getcurrent(data);
			e2epgnow(data);
		}
	
	
	//XML Response auswerten
//*
//Dreambox


//get Current
	function getcurrent(data)
		{
			alert ("Funktion Dreambox getcurrent\n XML:\n"+ data);
						//durchsucht XML Response
							
				$(data).find('e2service').each(function()
				{
						var e2sid = $(this).find('e2sid').text();
						var e2onid = $(this).find('e2onid').text();
						var e2tsid = $(this).find('e2tsid').text();
						var e2txtpid = $(this).find('e2txtpid').text();
						var e2pmtpid = $(this).find('e2pmtpid').text();
						var e2pcrpid = $(this).find('e2pcrpid').text();
						var e2vpid = $(this).find('e2vpid').text();
						var e2apid = $(this).find('e2apid').text();
						var e2iswidescreen = $(this).find('e2iswidescreen').text();
						var e2servicevideosize = $(this).find('e2servicevideosize').text();
						var e2videoheight = $(this).find('e2videoheight').text();
						var e2videowidth = $(this).find('e2videowidth').text();
						
						// liefert x wenn Box aus möglicher Selektor für Status<e2servicevideosize>x</e2servicevideosize>
						
						// Var Technische Info schreiben
						$("#e2sid").text(e2sid);
						$("#e2onid").text(e2onid);
						$("#e2tsid").text(e2tsid);
						$("#e2txtpid").text(e2txtpid);
						$("#e2pmtpid").text(e2pmtpid);
						$("#e2pcrpid").text(e2pcrpid);
						$("#e2vpid").text(e2vpid);
						$("#e2apid").text(e2apid);
						$("#e2iswidescreen").text(e2iswidescreen);
						$("#e2servicevideosize").text(e2servicevideosize);
						$("#e2videoheight").text(e2videoheight);
						$("#e2videowidth").text(e2videowidth);
						// Ausblenden wenn leer
					
 					});

				$(data).find('e2event').each(function()
				{
						//var volume = $(this).find('e2eventvolume').text();
						//var status = $(this).find('e2eventstatus').text();
						var e2eventstart = $(this).find('e2eventstart').text();
						//var e2eventend = $(this).find('e2eventend').text();
						//var e2eventvorbei = $(this).find('e2eventvorbei').text();
						//var e2eventverbl = $(this).find('e2eventverbl').text();
						var e2eventfortschritt = $(this).find('e2eventfortschritt').text();
						var e2eventduration = $(this).find('e2eventduration').text();
						var e2eventtitle = $(this).find('e2eventtitle').text();
						var e2eventservicereference = $(this).find('e2eventservicereference').text();
						var e2eventid = $(this).find('e2eventid').text();
						var e2eventname = $(this).find('e2eventname').text();
						var e2eventservicename = $(this).find('e2eventservicename').text();
						var e2eventdescription = $(this).find('e2eventdescription').text();
						var e2eventdescriptionextended = $(this).find('e2eventdescriptionextended').text();
						var e2eventcurrenttime = $(this).find('e2eventcurrenttime').text();
						var e2eventremaining = $(this).find('e2eventremaining').text();
						var e2eventprovidername = $(this).find('e2eventprovidername').text();
						
						// Uhrzeit und Start und Endzeit berechnen
						var currenttime = e2eventcurrenttime; // Umrechnen von Unix
						//var date = new Date(unixTimestamp*1000); // *1000 because of date takes milliseconds
						currenttime = new Date(currenttime*1000);
						
						$("currenttime").html("Uhrzeit: " + currenttime);
						// Unix Uhrzeit umrechen
						var start = new Date(e2eventstart*1000);
						var end = e2eventstart + e2eventduration;
						//var start = e2eventstart;
						
						// Kurzinfo zur aktuellen Sendung beschreiben
						/* 
						$( "#currentchannel" ).html(e2eventservicename);
								$( "#title" ).html(e2eventtitle);
								$( "#start" ).html(e2eventstart);
								$( "#ende" ).html(e2eventend);
								$( "#dauer" ).html(e2eventduration);
								$( "#vorbei" ).html(e2eventvorbei);
								$( "#verbl" ).html(e2eventremaining);
						* Offen wie nur die erste XMl auslesen wahrscheinlich mit i
						*/
						
						//Wenn Dreambox keine Antwort gibt
						if (e2eventtitle === "")
							{
								var statusoff = "off";
								alert ("Der Status ist: " + statusoff);
								$( "#currentchannel" ).html("Dreambox Status: " + statusoff);
								$("#flipdreamboxstatus").val(statusoff).flipswitch('refresh');
								//Icon Bild verwenden
								$( "#aktuellerDreamboxstatus" ).html("Die Dreambox ist aus");
								// Elemente verbergen
								$("#toggledesc").hide();
								$("#dreamboxtecinfo").hide();
							}
						else if (e2eventtitle !== "")
							{
								// Schreibe wenn die Dreambox an ist
								var statuson = "on";
								$("#flipdreamboxstatus").val(statuson).flipswitch('refresh');
								//Icon Bild verwenden
								$( "#aktuellerDreamboxstatus" ).html("Dreambox Status: " + statuson);
								// Bild erstellen
								var pref = e2eventservicereference.replace(/:/g, "_");
								pref = pref.substring(0,pref.length-1);
								//Reflex class muss noch geändert werden funktioniert nur bei festen Bild nicht nach einblenden
								var image	= "<img class=\"reflex\" idistance=\"0\" iheight=\"33\" iopacity=\"33\" iborder=\"0\" src=\"images/piconhd/"+pref+".png\" alt=\""+pref+".png\">";
								//alert (image);
								$( "#piconbig" ).html(image);
								
								// Nächste zwei Sendungen ausgeben
								$("<li></li>").html("Name: " + e2eventservicename).appendTo("#dreamboxinfo");
								$("<li></li>").html("Name: " + e2eventid).appendTo("#dreamboxinfo");
								$("<li></li>").html("Name: " + e2eventname).appendTo("#dreamboxinfo");
								$("<li></li>").html("SREF: " + e2eventservicereference).appendTo("#dreamboxinfo");
								$("<li></li>").html("Titel: " + e2eventtitle).appendTo("#dreamboxinfo");
								$("<li></li>").html("Dauer:" + e2eventduration).appendTo("#dreamboxinfo");
								$("<li></li>").html("Start: " + start).appendTo("#dreamboxinfo");
								$("<li></li>").html("Ende: " + end).appendTo("#dreamboxinfo");
								//$("<li></li>").html("Vorbei: " + e2eventvorbei).appendTo("#dreamboxinfo");
								//$("<li></li>").html("Verbleiben: " + e2eventverbl).appendTo("#dreamboxinfo");
								$("<li></li>").html("Verbleiben: " + e2eventremaining).appendTo("#dreamboxinfo");
								$("<li></li>").html("Fortschritt: " + e2eventfortschritt).appendTo("#dreamboxinfo");
								$("<li></li>").html("Provider: " + e2eventprovidername).appendTo("#dreamboxinfo");
								
								$("<li></li>").html("<div>").appendTo("dreamboxinfo");
								$("<li></li>").html("<h3>Beschreibung</h3>").appendTo("dreamboxinfo");
								$("<li></li>").html("<p>" + e2eventdescription + "</p>").appendTo("dreamboxinfo");
								$("<li></li>").html("<p>" + e2eventdescriptionextended + "</p>").appendTo("dreamboxinfo");
								$("<li></li>").html("</div>").appendTo("dreamboxinfo");
								
								$("<li></li>").html("Beschreibung: " + e2eventdescriptionextended).appendTo("#dreamboxinfo");
								
									
							}
						
						
								
								
						
 					});
					
		}
		
		// Zeigt Daten der aktuell laufenden Sender an
	function e2epgnow(data)
		{
			// Aufruf durch http://".$ipadr."/web/epgnow?bRef=$bouquet

			
			//durchsucht XML Response
			alert ("Funktion e2epgnow\n");	
			alert("XML Response:\n" + data);
			var i = 0;
			$(data).find('e2event').each(function()
				{
						
						var e2epgnowstart = $(this).find('e2eventstart').text();
						var e2epgnowduration = $(this).find('e2eventduration').text();
						var e2epgnowcurrenttime = $(this).find('e2eventcurrenttime').text();
						var e2epgnowtitle = $(this).find('e2eventtitle').text();
						var e2epgnowdescription = $(this).find('e2eventdescription').text();
						var e2epgnowdescriptionextended = $(this).find('e2eventdescriptionextended').text();
						var e2epgnowservicereference = $(this).find('e2eventservicereference').text();
						var e2epgnowservicename = $(this).find('e2eventservicename').text();
											
						var currenttime = e2epgnowcurrenttime; // Umrechnen von Unix
						//var date = new Date(unixTimestamp*1000); // *1000 because of date takes milliseconds
						currenttime = new Date(currenttime*1000);
						
						$("currenttime").html("Uhrzeit: " + currenttime);
						// Unix Uhrzeit umrechen
						var start = new Date(e2epgnowstart*1000);
						var end = e2epgnowstart + e2epgnowduration;
						//var start = e2eventstart;
						
						//Prüfung ob Daten geliefert werden bzw on Box erreichbar
						
						
								// Schreibe wenn die Dreambox an ist
								// Bild erstellen
								var pref = e2epgnowservicereference.replace(/:/g, "_");
								pref = pref.substring(0,pref.length-1);
								//Reflex class muss noch geändert werden funktioniert nur bei festen Bild nicht nach einblenden
								//var image	= "<img class=\"reflex\" idistance=\"0\" iheight=\"33\" iopacity=\"33\" iborder=\"0\" src=\"images/piconhd/"+pref+".png\" alt=\""+pref+".png\">";
								//alert (image);
								//Small Picon Einfügen für Liste
								//$( "#piconsmall" ).html(image);
								
								// Liste der laufenden Sendungen erstellen
								
								//HTML Layout einfügen
								i = i+1;
								//Layout Wechseln
								if (i % 2 !== 0)
				 					{
										$("<li></li>").html("Name: " + e2epgnowservicename).appendTo("#dreamboxepg");
										$("<li></li>").html("Start: " + start).appendTo("#dreamboxepg");
										$("<li></li>").html("Ende: " + end).appendTo("#dreamboxepg");
										$("<li></li>").html("Titel: " + e2epgnowtitle).appendTo("#dreamboxepg");
										$("<li></li>").html("Dauer:" + e2epgnowduration).appendTo("#dreamboxepg");
										$("<li></li>").html("<div>").appendTo("#dreamboxepg");
										$("<li></li>").html("<h3>Beschreibung</h3>").appendTo("#dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescription + "</p>").appendTo("#dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescriptionextended + "</p>").appendTo("#dreamboxepg");
										$("<li></li>").html("</div>").appendTo("#dreamboxepg");	
									}
								else
									{
										$("<li></li>").html("Name: " + e2epgnowservicename).appendTo("#dreamboxepg");
										$("<li></li>").html("Start: " + start).appendTo("#dreamboxepg");
										$("<li></li>").html("Ende: " + end).appendTo("#dreamboxepg");
										$("<li></li>").html("Titel: " + e2epgnowtitle).appendTo("#dreamboxepg");
										$("<li></li>").html("Dauer:" + e2epgnowduration).appendTo("#dreamboxepg");
										$("<li></li>").html("<div>").appendTo("dreamboxepg");
										$("<li></li>").html("<h3>Beschreibung</h3>").appendTo("dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescription + "</p>").appendTo("dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescriptionextended + "</p>").appendTo("dreamboxepg");
										$("<li></li>").html("</div>").appendTo("dreamboxepg");
										
									}
								
							
	
 					});
	// End e2epgnow		
		}
	//
	
//End Ready Function
});
// 