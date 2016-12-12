// JavaScript Document
//--------------------------------------------------------------------------
/*erst Dokument laden dann ausführen alles innerhalb von ready einfügen */

$(document).ready(function(){

	$('#dm8000ajax').click(function (event){ 
			var dreamboxurl = $(this).attr('href');
			alert ("Es wurde geklickt: " + dreamboxurl);
			event.preventDefault(); 
		
		$.ajax({
			url: dreamboxurl
			//url: $(this).attr('href'),
			//type : method,
			//data : data,
			dataType: "xml",
		}).done(function (data) {
			// Bei Erfolg
				alert("Erfolgreich:" + data);
				
		}).fail(function(data) {
			// Bei Fehler
			alert("Fehler!" + data);
			
		}).always(function() {
			// Immer
			alert("Beendet!");
		});	
				
		});

/*
	$('#dm8000ajax').click(function (event){ 
			var dreamboxurl = $(this).attr('href');
			//alert ("Es wurde geklickt" + dreamboxurl);
			event.preventDefault(); 
		$.ajax({
			url: dreamboxurl
			//url: $(this).attr('href'),
			//type : method,
			//data : data,
			dataType: "xml",
		}).done(function (url) {
			// Bei Erfolg
				alert("Erfolgreich:" + url);
				
		}).fail(function() {
			// Bei Fehler
			alert("Fehler!" + url);
			
		}).always(function() {
			// Immer
			alert("Beendet!");
		});
	});

*/

	$("form").submit(function(event) {
		// Das eigentliche Absenden verhindern
		event.preventDefault();
		
		// Das sendende Formular und die Metadaten bestimmen
		var form = $(this); // Dieser Zeiger $(this) oder $("form"), falls die ID form im HTML exisitiert, klappt übrigens auch ohne jQuery ;)
		var action = form.attr("action"), // attr() kann enweder den aktuellen Inhalt des gennanten Attributs auslesen, oder setzt ein neuen Wert, falls ein zweiter Parameter gegeben ist
			method = form.attr("method"),
			data   = form.serialize(); // baut die Daten zu einem String nach dem Muster vorname=max&nachname=Müller&alter=42 ... zusammen
			alert (data);
			// Test Dreambox
			//data = "/web/deviceinfo";	
		// Der eigentliche AJAX Aufruf
		$.ajax({
			url : action,
			type : method,
			data : data,
			//dataType: "xml",
		}).done(function (data) {
			// Bei Erfolg
				alert("Erfolgreich:\n XML Response:\n" + data);
				//alert("Erfolgreich:");
				// Sender
				//$( "#currentchannel" ).html(data);
				
				//Daten auswerten
				// Antwort des Servers -> als XML-Dokument
				
				$(data).find('e2event').each(function(){
				var e2eventstart = $(this).find('e2eventstart').text();
				var e2eventduration = $(this).find('e2eventduration').text();
				var e2eventtitle = $(this).find('e2eventtitle').text();
				var e2eventservicereference = $(this).find('e2eventservicereference').text();
				var e2eventservicename = $(this).find('e2eventservicename').text();
				var e2eventdescriptionextended = $(this).find('e2eventdescriptionextended').text();
				
				//alert("Sendername:" + e2eventservicename);
				var image = e2eventservicereference;
				//$("<li></li>").html(Titles + ", " + Manufacturers).appendTo("#cars");
				$("<li></li>").html("Name: " + e2eventservicename).appendTo("#dreamboxinfo");
				$("<li></li>").html("SREF: " + e2eventservicereference).appendTo("#dreamboxinfo");
				$("<li></li>").html("Titel: " + e2eventtitle).appendTo("#dreamboxinfo");
				$("<li></li>").html("Dauer:" + e2eventduration).appendTo("#dreamboxinfo");
				$("<li></li>").html("Start: " + e2eventstart).appendTo("#dreamboxinfo");
				$("<li></li>").html("Beschreibung: " + e2eventdescriptionextended).appendTo("#dreamboxinfo");
				//$( "#pref" ).html(image);
			
				});
				
				
					// Bild erstellen
					//var image	= "<img src=\""+picon+".png\" alt=\""+picon+"\" />";
				
				// Status
				//$( "#status" ).html(status);
				
				// Sender
				//var currentchannel	= "ZDF";
				//$( "#currentchannel" ).html(currentchannel);
				
				// Picon
				//var title	= "Suppitruppi";
				//$( "#pref" ).html(image);
				
		}).fail(function() {
			// Bei Fehler
			alert("Fehler!");
			
		}).always(function() {
			// Immer
			alert("Beendet!");
		});
	});
});