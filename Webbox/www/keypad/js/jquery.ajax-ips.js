/// JavaScript Document
//--------------------------------------------------------------------------
/*erst Dokument laden dann ausführen alles innerhalb von ready einfügen */

$(document).ready(function(){

//Nach Start initial aktuellen Status abfragen und Variablen aktualisieren
"use strict";
	

//Dreambox Zap

	$('#ARDZap').click(function(){
		$('#pushedbutton').html('ARD');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=ARD');		
	});
	$('#ZDFZap').click(function(){
		$('#pushedbutton').html('ZDF');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=ZDF');		
	});
	$('#RTLZap').click(function(){
		$('#pushedbutton').html('RTL');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=RTL');		
	});
	$('#Pro7Zap').click(function(){
		$('#pushedbutton').html('Pro7');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=PRO7');		
	});
	$('#Sat1Zap').click(function(){
		$('#pushedbutton').html('Sat1');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=Sat1');		
	});
	$('#VoxZap').click(function(){
		$('#pushedbutton').html('Vox');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=Vox');		
	});
	$('#Kabel1Zap').click(function(){
		$('#pushedbutton').html('Kabel1');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=Kabel1');		
	});
	$('#RTL2Zap').click(function(){
		$('#pushedbutton').html('RTL2');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=RTL2');		
	});
	$('#HRZap').click(function(){
		$('#pushedbutton').html('HR');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=HR');		
	});
	$('#NDRZap').click(function(){
		$('#pushedbutton').html('NDR');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=NDR');		
	});
	$('#SWRZap').click(function(){
		$('#pushedbutton').html('SWR');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=SWR');		
	});
	$('#WDRZap').click(function(){
		$('#pushedbutton').html('WDR');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=WDR');		
	});
	$('#BRZap').click(function(){
		$('#pushedbutton').html('BR');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=BR');		
	});
	$('#NeoHDZap').click(function(){
		$('#pushedbutton').html('NeoHD');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=NeoHD');		
	});
	$('#Sixx').click(function(){
		$('#pushedbutton').html('Sixx');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=Sixx');		
	});
	$('#Tageschau24Zap').click(function(){
		$('#pushedbutton').html('Tageschau24');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=Tageschau24');		
	});
	$('#KikaHDZap').click(function(){
		$('#pushedbutton').html('KikaHD');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=KikaHD');		
	});
	$('#SuperRTLZap').click(function(){
		$('#pushedbutton').html('SuperRTL');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=SuperRTL');		
	});
	$('#DisneyChannelZap').click(function(){
		$('#pushedbutton').html('DisneyChannel');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=DisneyChannel');		
	});
	$('#Tele5Zap').click(function(){
		$('#pushedbutton').html('Tele5');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=Tele5');		
	});
	

//Dreambox Cursor
	
	$('#navdreamleft').click(function(){
		$('#testchange').html('Links');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamleft');		
	});
	$('#navdreamright').click(function(){
		$('#testchange').html('Rechts');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamright');		
	});
	$('#navdreamup').click(function(){
		$('#testchange').html('Oben');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamup');		
	});
	$('#navdreamdown').click(function(){
		$('#testchange').html('Unten');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamdown');		
	});
	$('#navdreamenter').click(function(){
		$('#testchange').html('Enter');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamenter');		
	});
	
//Dreambox Colour Tasten
	$('#dreamred').click(function(){
		$('#testchange').html('red');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamred');		
	});	
	$('#dreamblue').click(function(){
		$('#testchange').html('blue');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamblue');		
	});	
	$('#dreamyellow').click(function(){
		$('#testchange').html('yellow');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamyellow');		
	});	
	$('#dreamgreen').click(function(){
		$('#testchange').html('Green');
    	ajaxrequest('cmd/dreambox/dreamboxrequest.php', 'get', 'command=dreamgreen');		
	});													

// Zap ein und Ausblenden
$('#dreamboxzap-ausblenden').click(function(){
    	$('#togglezap').hide('slow');
    });
	
		
		$('#dreamboxzap-einblenden').click(function(){
    	$('#togglezap').show('slow');
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
						
			if (firstnode === "statuslist")
			{
				
				$(data).find('status').each(function()
				{
						var status = $(this).find('neostatus').text();
						alert (status);
						if (status === "Alles Prima")
							{
								
								$("#responseips").html(status);
								alert ("Status "+status+" !");
								
							}
						if (status === "Alles Bunt")
							{
								
								$("#responseips").html(status);
								alert ("Status "+status+" !");
								
							}
				
				});
		
			}
	
		}
	
	


	
//End Ready Function
});
// 