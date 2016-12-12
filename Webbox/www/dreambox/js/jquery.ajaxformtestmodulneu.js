/// JavaScript Document
//--------------------------------------------------------------------------
/*erst Dokument laden dann ausführen alles innerhalb von ready einfügen */

$(document).ready(function(){

//Nach Start initial aktuellen Status abfragen und Variablen aktualisieren
"use strict";
ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'post', 'DenonVolumeSlider=Vol?');

// Holt Initial Dreambox Daten
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=getcurrent');
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=epgservice&sref=1:0:19:2B66:3F3:1:C00000:0:0:0:');


//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=movielist.html');
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=status?');
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=epgnow');

// Gibt aktive Harmony Activity zurück
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=harmonyactivity');

//Test
//ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamleft');	

// Elemente verbergen
//$("#currentvolume").hide();

//aktuelle Lautstärke
//$("#DenonVolumeSlider").val(slider_value);
//$("#DenonVolumeSlider").flipswitch('refresh');	

/* Auf Mouseklick reagieren */
	 $('#kanaltest').click(function(){
    	alert('Es wurde auf Kanalliste geklickt');
		ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=epgnow');
	
    	});	
// Logitech Hub Befehle senden
		 $('#hpoweroff').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=hpoweroff');
	   	});	
		 $('#htv').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=htv');
	   	});
		 $('#hsonos').click(function(){
		ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=hsonos');
	   	});	
		 $('#hmovietv').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=hmovietv');
	   	});
		$('#hmoviescreen').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=hmoviescreen');
	   	});	
		$('#htvscreen').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=htvscreen');
	   	});	
		$('#hfiretv').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=hfiretv');
	   	});	
		$('#happletv').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=happletv');
	   	});	

//Dreambox

//Dreambox Cursor
	
	$('#navdreamleft').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamleft');		
	});
	$('#navdreamright').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamright');		
	});
	$('#navdreamup').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamup');		
	});
	$('#navdreamdown').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamdown');		
	});
	$('#navdreamenter').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamenter');		
	});
	
//Dreambox Colour Tasten
	$('#dreamred').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamred');		
	});	
	$('#dreamblue').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamblue');		
	});	
	$('#dreamyellow').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamyellow');		
	});	
	$('#dreamgreen').click(function(){
    	ajaxrequest('cmd/dreambox/ipsrequestneu.php', 'get', 'command=dreamgreen');		
	});													
//Umschalten auf andere NEO Seite

//Orientation Change
/*
$(window).on("orientationchange",function(){
  alert("The orientation has changed!");
});
*/

// Bei Mousedown Befehl wiederholen


// Slider beim Bewegen aktualisieren
// Sendet Request beim Ändern der Lautstärke
         
          $("#DenonVolumeSlider").change(function() {
          var slider_value = $("#DenonVolumeSlider").val();
		  $( "#currentvolume" ).html(slider_value + " %");
          // Sendet Request bei Ändern der Lautstärke
		  ajaxrequest("cmd/dreambox/ipsrequestneu.php", "post", "DenonVolumeSlider="+slider_value);
		          
          });
		  
		  $("#DenonVolumeSlider1").change(function() {
          var slider_value = $("#DenonVolumeSlider1").val();
		  $( "#currentvolume1" ).html(slider_value + " %");
          // Sendet Request bei Ändern der Lautstärke
		  ajaxrequest("slidersend.php", "post", "DenonVolumeSlider1="+slider_value);
		          
          });
		  
// Sendet Dreambox Status		  
 			$("#dreamboxstatus").change(function() {
            var dreambox_statusflip = $("#flipdreamboxstatus").val();
            // Sendet Request bei Ändern des Status
			// alert ("Befehl: command=" + dreambox_statusflip + " gesendet");
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
					//alert("Erfolgreich:\n XML Response:\n" + data);
					
					//Daten auswerten
					// Antwort des Servers -> als XML-Dokument
					e2response(data);	
					return data;
			}).fail(function() {
				// Bei Fehler
				alert("Fehler Ajax!");
				
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
			// XML Antworten Child names sind je nach Funktion unterschiedlich daher muss der Name vom ersten Child geprüft werden
			//alert ("e2response: Ok");
			
			// Prüft auf den ersten Childname des XML
			var firstnode = data.documentElement.nodeName;
			//alert ("Name der ersten Node:\n" + firstnode);
						
			if (firstnode === "e2currentserviceinformation")
			{
				//var command = $(data).first().text();
				//alert ("First Node e2currentserviceinformation\n Funktion "+command+" wurde aufgerufen");
				//Funktion getcurrent
				getcurrent(data);
			}
			
			else if (firstnode === "e2deviceinfo")
			{
				//var command = "about";
				//alert ("First Node e2deviceinfo\n Funktion "+command+" wurde aufgerufen");
				//Funktion about
				e2about(data);
			}
			else if (firstnode === "e2remotecontrol")
			{
				//alert("Dreambox Remotebefehl");
			/*
			<e2remotecontrol>
			<e2result>True</e2result>
			<e2resulttext>RC command '401' has been issued</e2resulttext>
			</e2remotecontrol>*/	
				
			}
			
			else if (firstnode === "harmonyhublist")
			{
				$(data).find('harmonyevent').each(function()
				{
					//var command = $(this).find('command').text();
					var currentactivity = $(this).find('harmonyactivity').text();
					//alert (activity);
					//Activity Anzeige aktualisieren
					harmonyhub(currentactivity);
					
				});
				
				//alert ("First Node harmonyhublist\n Funktion "+command+" wurde aufgerufen");
								
			}
			
			else if (firstnode === "denoneventlist")
			{
				$(data).find('denonevent').each(function()
				{
						var volume = $(this).find('denonmastervolume').text();
						var commandvol = $(this).find('command').text();
						if (commandvol === "Vol?")
							{
								//alert ("initial:" + volume + " %");
								// value als Integer setzten
								var volumeint = parseInt(volume);
								$("#DenonVolumeSlider").val(volumeint).slider("refresh");
								//Lautstärke setzen
								$( "#currentvolume" ).html(volume + " %");		
							}
				
				});

			}
			
			else if (firstnode === "e2eventlist")
			{
				
				$(data).find('e2event').each(function()
				{
						var e2command = $(this).find('command').text();
						//alert (e2command);
						// Funktionen epgservicenow, epgnow
						if (e2command === "epgnow")
							{
								//Ausführen bei epg now Anforderung
								$("senddreamboxcommand").html(e2command);
								//alert ("Funktion "+e2command+" wurde aufgerufen");
								e2epgnow(data);	
							}
						else if (e2command === "epgservice")
							{
								//Ausführen bei epg now Anforderung
								$("senddreamboxcommand").html(e2command);
								//alert ("Funktion "+e2command+" wurde aufgerufen");
								e2epgservice(data);	
							}
						
				
				});
		
			}
			
			else if (firstnode === "e2movielist")
			{
				
				$(data).find('e2movie').each(function()
				{
						var e2command = $(this).find('command').text();
						//alert (e2command);
						// Funktionen epgservicenow, epgnow
						if (e2command === "movielist.html")
							{
								//Ausführen bei epg now Anforderung
								$("senddreamboxcommand").html(e2command);
								alert ("Funktion "+e2command+" wurde aufgerufen");
								e2movielistHTML(data);
							}
						
				
				});
		
			}
	
		}
	
	
	//XML Response auswerten
	
//************************************************
//Harmony Hub Activity anzeigen
//************************************************
function harmonyhub(currentactivity)
	{
		//alert ("Harmony Activity: \n" + currentactivity);
		if (currentactivity === "All Off")
						{
							//alert ("Aktivität aktualisieren");
							$("#poweroffback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "Fernsehen")
						{
							$("#navfernsehenback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "Amazon Prime")
						{
							$("#navfiretvback").css("background-color", "rgba(92,159,72,1.00)");
						}				
		else if (currentactivity === "AppleTV")
						{
							$("#navappletvback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "Wohnzimmer")
						{
							$("#navsonosback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "Film FTV Leinwand")
						{
							$("#navfilmtvback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "TV Leinwand")
						{
							$("#navfilmtvback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "Film anschauen")
						{
							$("#navfilmback").css("background-color", "rgba(92,159,72,1.00)");
						}
		else if (currentactivity === "Film Leinwand")
						{
							$("#navfilmscreenback").css("background-color", "rgba(92,159,72,1.00)");
						}																						
	}


	
	
	
//*
//Dreambox


//get Current
	function getcurrent(data)
		{
			//alert ("Funktion Dreambox getcurrent\n XML:\n"+ data);
						//durchsucht XML Response
				// Technische Sendungsinfo Schreiben			
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
				
				
				var i = 0;
				//Info der nächsten zwei Sendungen schreiben
				$(data).find('e2event').each(function()
				{
						// Auskommentiert wird nicht von Dreambox geliefert
						i = i+1;
								
						var e2currentservicereference = $(this).find('e2eventservicereference').text();
						var e2currentservicename = $(this).find('e2eventservicename').text();
						var e2currentprovidername = $(this).find('e2eventprovidername').text();
						var e2currentid = $(this).find('e2eventid').text();
						var e2currentname = $(this).find('e2eventname').text();
						var e2currenttitle = $(this).find('e2eventtitle').text();
						var e2currentdescription = $(this).find('e2eventdescription').text();
						var e2currentstart = $(this).find('e2eventstart').text();
						var e2currentduration = $(this).find('e2eventduration').text();
						var e2currentremaining = $(this).find('e2eventremaining').text();
						var e2currenttime = $(this).find('e2eventcurrenttime').text();
						var e2currentdescriptionextended = $(this).find('e2eventdescriptionextended').text();
						
						/*
						//Ausgabe Dreambox
						<e2eventstart>1441026000</e2eventstart>
						<e2eventduration>3600</e2eventduration>
						<e2eventremaining>2868</e2eventremaining>
						<e2eventcurrenttime>1441026732.82</e2eventcurrenttime>
						*/	
						
						// Uhrzeit und Start und Endzeit berechnen
						var currenttime = e2currenttime; // Umrechnen von Unix
						//var date = new Date(unixTimestamp*1000); // *1000 because of date takes milliseconds
						currenttime = new Date(currenttime*1000);
						var e2currentelapsed = e2currentduration - e2currentremaining;
						
						$("#currenttime").html("Uhrzeit: " + currenttime);
						// Unix Uhrzeit umrechen
						var currentstart = new Date(e2currentstart*1000);
						var currentend = e2currentstart + e2currentduration;
						//var start = e2eventstart;
						
						//Ausgabe der Dreambox in Sekunden
						e2currentremaining = sToTime(e2currentremaining);
						// Ausgabe der Dreambox in Sekunden
						e2currentduration = sToTime(e2currentduration);
						e2currentelapsed = sToTime(e2currentelapsed);
									
						
						//Wenn Dreambox keine Antwort gibt
						if (e2currenttitle === "")
							{
								var statusoff = "dreamboxoff";
								//alert ("Der Status ist aus");
								$( "#currentchannel" ).html("Die Dreambox ist aus");
								$( "#currenttitle" ).html("");
								$( "#currentstart" ).html("");
								$( "#currentend" ).html("");
								$( "#currentduration" ).html("");
								$( "#currentelapsed" ).html("");
								$( "#currentremaining" ).html("");
								$("#flipdreamboxstatus").val(statusoff).flipswitch('refresh');
								//Icon Bild verwenden
								$( "#aktuellerDreamboxstatus" ).html("Die Dreambox ist aus");
								// Elemente verbergen
								$("#toggledesc").hide();
								$("#dreamboxtecinfo").hide();
							}
						else if (e2currenttitle !== "")
							{
								// Schreibe wenn die Dreambox an ist
								var statuson = "dreamboxon";
								//alert ("Der Status ist an");
								$("#flipdreamboxstatus").val(statuson).flipswitch('refresh');
								//Icon Bild verwenden
								$( "#aktuellerDreamboxstatus" ).html("Die Dreambox ist an");
								
								//Info zur aktuellen Sendung schreiben
								if (i === 1)
								{
									//alert ("Aktuelle Sendungsdaten");
									$( "#currentchannel" ).html(e2currentservicename);
									$( "#currenttitle" ).html(e2currenttitle);
									$( "#currentstart" ).html("Start: " + currentstart);
									$( "#currentend" ).html("Ende: " + currentend);
									$( "#currentduration" ).html("Dauer: " + e2currentduration);
									$( "#currentelapsed" ).html("Vorbei: " + e2currentelapsed);
									$( "#currentremaining" ).html("Verbleibend: " + e2currentremaining);
									
									// Bild erstellen
									var prefcurrent = e2currentservicereference.replace(/:/g, "_");
									prefcurrent = prefcurrent.substring(0,prefcurrent.length-1);
									//Reflex class muss noch geändert werden funktioniert nur bei festen Bild nicht nach einblenden
									var image	= "<img class=\"reflex\" idistance=\"0\" iheight=\"33\" iopacity=\"33\" iborder=\"0\" src=\"images/piconhd/"+prefcurrent+".png\" alt=\""+prefcurrent+".png\">";
									//alert (image);
									$( "#piconbig" ).html(image);
									
								}
								
								
								
								
								
								
								// Nächste zwei Sendungen ausgeben
								$("<li></li>").html("Servicename: " + e2currentservicename).appendTo("#dreamboxinfo");
								//$("<li></li>").html("ID: " + e2currentid).appendTo("#dreamboxinfo");
								$("<li></li>").html("Name: " + e2currentname).appendTo("#dreamboxinfo");
								//$("<li></li>").html("SREF: " + e2currentservicereference).appendTo("#dreamboxinfo");
								//$("<li></li>").html("Titel: " + e2currenttitle).appendTo("#dreamboxinfo");
								$("<li></li>").html("Dauer:" + e2currentduration).appendTo("#dreamboxinfo");
								$("<li></li>").html("Start: " + currentstart).appendTo("#dreamboxinfo");
								$("<li></li>").html("Ende: " + currentend).appendTo("#dreamboxinfo");
								$("<li></li>").html("Verbleiben: " + e2currentremaining).appendTo("#dreamboxinfo");
								$("<li></li>").html("Provider: " + e2currentprovidername).appendTo("#dreamboxinfo");
								$("<li></li>").html("Beschreibung" + e2currentdescription + "</p>").appendTo("dreamboxinfo");
								$("<li></li>").html("Lang: " + e2currentdescriptionextended + "</p>").appendTo("dreamboxinfo");
															
															
									
							}
						
						
								
								
						
 					});
					
		}
		
	
	//Infos zur Dreambox
	function e2about(data)
		{
			/*
						<e2deviceinfo>
			<e2enigmaversion>2015-05-28-tarball</e2enigmaversion>
			<e2imageversion>Experimental 2014-06-27</e2imageversion>
			<e2webifversion>1.7.5</e2webifversion>
			<e2fpversion>7</e2fpversion>
			<e2devicename>dm8000</e2devicename>
			<e2frontends>
			<e2frontend>
			<e2name>Tuner A</e2name>
			<e2model>BCM4506 (internal) (DVB-S2)</e2model>
			</e2frontend>
			<e2frontend>
			<e2name>Tuner B</e2name>
			<e2model>BCM4506 (internal) (DVB-S2)</e2model>
			</e2frontend>
			<e2frontend>
			<e2name>Tuner C</e2name>
			<e2model>(leer)</e2model>
			</e2frontend>
			<e2frontend>
			<e2name>Tuner D</e2name>
			<e2model>(leer)</e2model>
			</e2frontend>
			</e2frontends>
			<e2network>
			<e2interface>
			<e2name>eth0</e2name>
			<e2mac>00:09:34:1c:ad:93</e2mac>
			<e2dhcp>True</e2dhcp>
			<e2ip>0.0.0.0</e2ip>
			<e2gateway>0.0.0.0</e2gateway>
			<e2netmask>0.0.0.0</e2netmask>
			</e2interface>
			</e2network>
			<e2hdds>
			<e2hdd>
			<e2model>ATA-SAMSUNG HD204UI</e2model>
			<e2capacity>2000.398 GB</e2capacity>
			<e2free>732.231 GB</e2free>
			</e2hdd>
			<e2hdd>
			<e2model>USB 2.0-Flash Disk</e2model>
			<e2capacity>1.054 GB</e2capacity>
			<e2free>778 MB</e2free>
			</e2hdd>
			</e2hdds>
			</e2deviceinfo>
			*/	
		}
		
	// Zeigt Aufnahmeliste an	
	function e2movielistHTML(data)
		{
			// Aufruf durch http://".$ipadr."/web/movielist.html?dirname=&tag=
			$("#movielist").show();
			$("#timerlist").hide();
			$("#dreamboxepg").hide();
			
			var i = 0;
			$(data).find('e2movie').each(function()
				{
					var e2movielistHTMLsref = $(this).find('e2servicereference').text();
					var e2movielistHTMLtitle = $(this).find('e2title').text();
					var e2movielistHTMLdesc = $(this).find('e2description').text();
					var e2movielistHTMLdescext = $(this).find('e2descriptionextended').text();
					var e2movielistHTMLservicename = $(this).find('e2servicename').text();
					var e2movielistHTMLtime = $(this).find('e2time').text();
					var e2movielistHTMLlength = $(this).find('e2length').text();
					var e2movielistHTMLtags = $(this).find('e2tags').text();
					var e2movielistHTMLfilename = $(this).find('e2filename').text();
					var e2movielistHTMLfilesize = $(this).find('e2filesize').text();
					var prefmovielistHTML = e2movielistHTMLsref.replace(/:/g, "_");
					prefmovielistHTML = prefmovielistHTML.substring(0,prefmovielistHTML.length-1);
					
					i = i+1;
								//Layout Wechseln
								if (i % 2 !== 0)
				 					{
										//Timer Aufnahme hinzufügen
										$("#movielist").append("<table class=\"row_0\"><tr><td rowspan=\"2\"><img src=\"picon/" + prefmovielistHTML + ".png\" alt=\"logo\"></td><td>" + e2movielistHTMLtitle + "</td><td><a href=\"http://192.168.55.37/web/moviedelete?sRef=" + e2movielistHTMLsref + "\">Delete</a></td></tr><tr><td>" + e2movielistHTMLservicename + "</td><td></td></tr><tr><td>" + e2movielistHTMLtime + "</td><td>" + e2movielistHTMLdesc + "</td><td>Play</td></tr><tr><td></td><td rowspan=\"3\">" + e2movielistHTMLdescext + "</td><td></td></tr><tr><td>" + e2movielistHTMLtime + " Uhr</td><td></td></tr><tr><td>" + e2movielistHTMLlength + " Minuten</td><td></td></tr><tr><td></td><td></td><td></td></tr><tr><td></td><td>sref</td><td></td></tr><tr><td></td><td>" + e2movielistHTMLfilename + "</td><td>" + e2movielistHTMLfilesize + " MB</td></tr><tr><td></td><td></td><td></td></tr></table>");
										
									}
								else
									{
																				//Timer Aufnahme hinzufügen
										$("#movielist").append("<table class=\"row_1\"><tr><td rowspan=\"2\"><img src=\"picon/" + prefmovielistHTML + ".png\" alt=\"logo\"></td><td>" + e2movielistHTMLtitle + "</td><td><a href=\"http://192.168.55.37/web/moviedelete?sRef=" + e2movielistHTMLsref + "\">Delete</a></td></tr><tr><td>" + e2movielistHTMLservicename + "</td><td></td></tr><tr><td>" + e2movielistHTMLtime + "</td><td>" + e2movielistHTMLdesc + "</td><td>Play</td></tr><tr><td></td><td rowspan=\"3\">" + e2movielistHTMLdescext + "</td><td></td></tr><tr><td>" + e2movielistHTMLtime + " Uhr</td><td></td></tr><tr><td>" + e2movielistHTMLlength + " Minuten</td><td></td></tr><tr><td></td><td></td><td></td></tr><tr><td></td><td>sref</td><td></td></tr><tr><td></td><td>" + e2movielistHTMLfilename + "</td><td>" + e2movielistHTMLfilesize + " MB</td></tr><tr><td></td><td></td><td></td></tr></table>");
									}
						
				});
			
		}
		
	//Zeigt EPG eines Senders an
	function e2epgservice(data)
		{
			// Aufruf durch /web/epgservice?sRef=&time=&endTime=
			$("#dreamboxepg").show();
			$("#movielist").hide();
			$("#timerlist").hide();
			//durchsucht XML Response
			//alert ("Funktion e2epgservice\n");	
			//alert("XML Response:\n" + data);
			var i = 0;
			$(data).find('e2event').each(function()
				{
					i = i+1;
					var e2epgserviceid = $(this).find('e2eventid').text();
					var e2epgservicestart = parseInt($(this).find('e2eventstart').text());
					var e2epgserviceduration = parseInt($(this).find('e2eventduration').text());
					var e2epgservicecurrenttime = parseInt($(this).find('e2eventcurrenttime').text());
					var e2epgservicetitle = $(this).find('e2eventtitle').text();
					var e2epgservicedescription = $(this).find('e2eventdescription').text();
					var e2epgservicedescriptionextended = $(this).find('e2eventdescriptionextended').text();
					var e2epgserviceservicereference = $(this).find('e2eventservicereference').text();
					var e2epgserviceservicename = $(this).find('e2eventservicename').text();
					var startepgservice = new Date(e2epgservicestart*1000);
					var startepgserviceH = startepgservice.getHours();
					var startepgserviceMin = startepgservice.getMinutes();
					var endepgservice = new Date(((e2epgservicestart + e2epgserviceduration)*1000));
					var endepgserviceH = endepgservice.getHours();
					var endepgserviceMin = endepgservice.getMinutes();
					// Umrechnung in Minuten
					e2epgserviceduration = Math.round(e2epgserviceduration / 60);
					
					// Bild erstellen
					var prefepgservice = e2epgserviceservicereference.replace(/:/g, "_");
					prefepgservice = prefepgservice.substring(0,prefepgservice.length-1);
					
					if (i % 2 !== 0)
				 					{
										
										$("#dreamboxepg").append("<table class=\"row_0\"><tr><td rowspan=\"2\" width=\"120\" valign=\"top\" align=\"left\"><figure class=\"picon\"><a href=\"http://192.168.55.37/web/zap?sRef=" + e2epgserviceservicereference + "\"><img src=\"images/picon/" + prefepgservice + ".png\" alt=\"logo\"></a><figcaption>" + e2epgserviceservicename + "</figcaption></figure></td><td class=\"titel\">" + e2epgservicetitle + "<div class=\"startepg\">" + startepgserviceH + ":" + startepgserviceMin + " Uhr</div><div class=\"endepg\">Dauer: " + e2epgserviceduration + "min Ende: " + endepgserviceH + ":" + endepgserviceMin + "Uhr</div></td></tr><tr><td align=\"left\" valign=\"top\" class=\"description\"><p>" + e2epgservicedescription + "</p> " + e2epgservicedescriptionextended + "</td></tr></table>");
										
									}
								else
									{
										$("#dreamboxepg").append("<table class=\"row_1\"><tr><td rowspan=\"2\" width=\"120\" valign=\"top\" align=\"left\"><figure class=\"picon\"><a href=\"http://192.168.55.37/web/zap?sRef=" + e2epgserviceservicereference + "\"><img src=\"images/picon/" + prefepgservice + ".png\" alt=\"logo\"></a><figcaption>" + e2epgserviceservicename + "</figcaption></figure></td><td class=\"titel\">" + e2epgservicetitle + "<div class=\"startepg\">" + startepgserviceH + ":" + startepgserviceMin + " Uhr</div><div class=\"endepg\">Dauer: " + e2epgserviceduration + "min Ende: " + endepgserviceH + ":" + endepgserviceMin + "Uhr</div></td></tr><tr><td align=\"left\" valign=\"top\" class=\"description\"><p>" + e2epgservicedescription + "</p> " +e2epgservicedescriptionextended + "</td></tr></table>");
										
									}
												
				});
			
		}
		
		
		// Zeigt Daten der aktuell laufenden Sender an
	function e2epgnow(data)
		{
			// Aufruf durch http://".$ipadr."/web/epgnow?bRef=$bouquet
			$("#dreamboxepg").show();
			$("#movielist").hide();
			$("#timerlist").hide();
			//durchsucht XML Response
			//alert ("Funktion e2epgnow\n");	
			//alert("XML Response:\n" + data);
			var i = 0;
			$(data).find('e2event').each(function()
				{

						var e2epgnowid = $(this).find('e2eventid').text();
						var e2epgnowstart = parseInt($(this).find('e2eventstart').text());
						var e2epgnowduration = parseInt($(this).find('e2eventduration').text());
						var e2epgnowcurrenttime = parseInt($(this).find('e2eventcurrenttime').text());
						var e2epgnowtitle = $(this).find('e2eventtitle').text();
						var e2epgnowdescription = $(this).find('e2eventdescription').text();
						var e2epgnowdescriptionextended = $(this).find('e2eventdescriptionextended').text();
						var e2epgnowservicereference = $(this).find('e2eventservicereference').text();
						var e2epgnowservicename = $(this).find('e2eventservicename').text();
											
						var epgnowcurrenttime = e2epgnowcurrenttime; // Umrechnen von Unix
						//var date = new Date(unixTimestamp*1000); // *1000 because of date takes milliseconds
						epgnowcurrenttime = new Date(epgnowcurrenttime*1000);
						
						$("currenttime").html("Uhrzeit: " + epgnowcurrenttime);
						// Unix Uhrzeit umrechen
						var startepgnow = new Date(e2epgnowstart*1000);
						var startepgnowH = startepgnow.getHours();
						var startepgnowMin = startepgnow.getMinutes();
						//var startepgnowH = startepgnow;
						//e2epgnowduration = e2epgnowduration*1000;
						var endepgnow = new Date(((e2epgnowstart + e2epgnowduration)*1000));
						var endepgnowH = endepgnow.getHours();
						var endepgnowMin = endepgnow.getMinutes();
						// Umrechnung in Minuten
						e2epgnowduration = Math.round(e2epgnowduration / 60);
						//var endepgnow = (e2epgnowstart + (e2epgnowduration*1000));
						//endepgnow = new Date(endepgnow);
						
						
						//var start = e2eventstart;
						
						//Prüfung ob Daten geliefert werden bzw on Box erreichbar
						
						
								// Schreibe wenn die Dreambox an ist
								// Bild erstellen
								var prefepgnow = e2epgnowservicereference.replace(/:/g, "_");
								prefepgnow = prefepgnow.substring(0,prefepgnow.length-1);
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
										//Timer Aufnahme hinzufügen
										$("#dreamboxepg").append("<table class=\"row_0\"><tr><td rowspan=\"2\" width=\"120\" valign=\"top\" align=\"left\"><figure class=\"picon\"><a href=\"http://192.168.55.37/web/zap?sRef=" + e2epgnowservicereference + "\"><img src=\"images/picon/" + prefepgnow + ".png\" alt=\"logo\"></a><figcaption>" + e2epgnowservicename + "</figcaption></figure></td><td class=\"titel\">" + e2epgnowtitle + "<div class=\"startepg\">" + startepgnowH + ":" + startepgnowMin + " Uhr</div><div class=\"endepg\">Dauer: " + e2epgnowduration + "min Ende: " + endepgnowH + ":" + endepgnowMin + "Uhr</div></td></tr><tr><td align=\"left\" valign=\"top\" class=\"description\"><p>" + e2epgnowdescription + "</p> " + e2epgnowdescriptionextended + "</td></tr></table>");
										/*
										$("<li></li>").html("Name: " + e2epgnowservicename).appendTo("#dreamboxepg");
										$("<li></li>").html("Start: " + start).appendTo("#dreamboxepg");
										$("<li></li>").html("Ende: " + end).appendTo("#dreamboxepg");
										$("<li></li>").html("Titel: " + e2epgnowtitle).appendTo("#dreamboxepg");
										$("<li></li>").html("Dauer:" + e2epgnowduration).appendTo("#dreamboxepg");
										$("<li></li>").html("<div><h3>Beschreibung</h3>").appendTo("#dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescription + "</p>").appendTo("#dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescriptionextended + "</p></div>").appendTo("#dreamboxepg");
										*/	
									}
								else
									{
										$("#dreamboxepg").append("<table class=\"row_1\"><tr><td rowspan=\"2\" width=\"120\" valign=\"top\" align=\"left\"><figure class=\"picon\"><a href=\"http://192.168.55.37/web/zap?sRef=" + e2epgnowservicereference + "\"><img src=\"images/picon/" + prefepgnow + ".png\" alt=\"logo\"></a><figcaption>" + e2epgnowservicename + "</figcaption></figure></td><td class=\"titel\">" + e2epgnowtitle + "<div class=\"startepg\">" + startepgnowH + ":" + startepgnowMin + " Uhr</div><div class=\"endepg\">Dauer: " + e2epgnowduration + "min Ende: " + endepgnowH + ":" + endepgnowMin + "Uhr</div></td></tr><tr><td align=\"left\" valign=\"top\" class=\"description\"><p>" + e2epgnowdescription + "</p> " +e2epgnowdescriptionextended + "</td></tr></table>");
										
										
										/*
										$("<li></li>").html("Name: " + e2epgnowservicename).appendTo("#dreamboxepg");
										$("<li></li>").html("Start: " + start).appendTo("#dreamboxepg");
										$("<li></li>").html("Ende: " + end).appendTo("#dreamboxepg");
										$("<li></li>").html("Titel: " + e2epgnowtitle).appendTo("#dreamboxepg");
										$("<li></li>").html("Dauer:" + e2epgnowduration).appendTo("#dreamboxepg");
										$("<li></li>").html("").appendTo("dreamboxepg");
										$("<li></li>").html("<div><h3>Beschreibung</h3>").appendTo("dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescription + "</p>").appendTo("dreamboxepg");
										$("<li></li>").html("<p>" + e2epgnowdescriptionextended + "</p></div>").appendTo("dreamboxepg");
										*/
										
									}
								
							
	
 					});
	// End e2epgnow		
		}
	//
	function sToTime (seconds) {
        var minutes = parseInt(seconds/60, 10);
        seconds = seconds%60;
        var hours = parseInt(minutes/60, 10);
        minutes = minutes%60;
        
        return hours + ' h : ' + minutes + ' min';
        //return hours + ':' + minutes + ':' + seconds;
    }

	
//End Ready Function
});
// 