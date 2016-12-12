/*erst Dokument laden dann ausführen alles innerhlab von ready einfügen */
$(document).ready(function(){
    /* Hier der jQuery-Code */
    /*selektiert a und gibt den Titel als Meldung aus */
	// alert(jQuery('a').attr('title')); 
	
	/* Inhalte ändern */
	//$('h1').html('mit jQuery Inhalte ändern');
	
	/* Als Beispiel lassen wir einfach den Inhalt per Alert ausgeben */
	//alert($('#absatz1').html());
	/* Oder mag man den reinen Textinhalt haben */
	//alert($('#absatz1').text()); 
	
	/* CSS Klasse hinzufügen*/
	//$('p').addClass('fehlerhinweise');
	
	/* CSS Klasse entfernen*/
	//$('p').removeClass('fehlerhinweise');
	
	
	/* Auf Mouseklick reagieren */
	 $('#absatz1111').click(function(){
    	alert('Es wurde auf #absatz1 geklickt');
    	});	
	
	/* Mögliche Mausereignisse sind:
	click
	dblclick
	hover
	mouseleave
	mousedown, mouseenter, mousemove, mouseout, mouseover, mouseup
	Für aktive Formularfelder wird oft benötigt:
	focus*/
	

});