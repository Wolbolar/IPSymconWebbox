/*erst Dokument laden dann ausführen alles innerhalb von ready einfügen */
$(document).ready(function(){
    "use strict";
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
	// $('#absatz1112').click(function(){
    //	//alert('Es wurde auf #absatz1 geklickt');
	//	$('#absatz2').addClass('fehlerhinweise');
    //	});	
	
	/* Mögliche Mausereignisse sind:
	click
	dblclick
	hover
	mouseleave
	mousedown, mouseenter, mousemove, mouseout, mouseover, mouseup
	Für aktive Formularfelder wird oft benötigt:
	focus*/
			
	/* Auf tastatureingaben reagieren */
	//$('input').keypress(function(e){
      //if (e.which == 65)
      //{
       // alert('Es wurde A gedrückt');
      //}
  	  //});	

	/* Elemente ein und ausblenden */
	//$('#sobo-einblenden').click(function(){
    //	$('#sozialbookmarks').show();
    //})
    //$('#sobo-ausblenden').click(function(){
    //	$('#sozialbookmarks').hide();
    //})
	// Im HTML
	// <a href="#" id="sobo-einblenden">einblenden</a>
	
	/*Die Geschwindigkeit des Ein- und Ausblendens kann eingestellt werden
	Z.B. über
	show('slow')
	show('fast')
	show(500) */
	
	/* Ein- Ausblenden */
	$('#sobo-einausblenden').click(function(){
    	$('#sozialbookmarks').toggle('slow');
    });
	
		$('#sobo-ausblenden').click(function(){
    	$('#sozialbookmarkseinaus').hide('slow');
    });
	
		
		$('#sobo-einblenden').click(function(){
    	$('#sozialbookmarkseinaus').show('slow');
    });
	
		$('#dreamboxinfo-ausblenden').click(function(){
    	$('#dreamboxcurrentinfo').hide('slow');
    });
	
		
		$('#dreamboxinfo-einblenden').click(function(){
    	$('#dreamboxcurrentinfo').show('slow');
    });
	$('#dreamboxdesc-ausblenden').click(function(){
    	$('#toggledesc').hide('slow');
    });
	
		
		$('#dreamboxdesc-einblenden').click(function(){
    	$('#toggledesc').show('slow');
    });
	$('#dreamboxzap-ausblenden').click(function(){
    	$('#togglezap').hide('slow');
    });
	
		
		$('#dreamboxzap-einblenden').click(function(){
    	$('#togglezap').show('slow');
    });
	$('#dreamboxtecinfo-ausblenden').click(function(){
    	$('#dreamboxtecinfo-ausblenden').hide();
		$('#dreamboxtecinfo-einblenden').show();
		$('#dreamboxtecinfo').hide('slow');
    });
	
		
		$('#dreamboxtecinfo-einblenden').click(function(){
    	$('#dreamboxtecinfo-einblenden').hide();
		$('#dreamboxtecinfo-ausblenden').show();
		$('#dreamboxtecinfo').show('slow');
    });
			
		$('#sobo-einausblenden3').click(function(){
    	$('#sozialbookmarks3').toggle('slow');
    });
		
	
	
	//Menü Head
	// Hintergrund ändern
	/*
	$(".headnavicon").hover(function(){
    $(this).css("background-color", "yellow");
    }, function(){
    $(this).css("background-color", "pink");
	});
	*/	  
	//Bei Mouseover Farbe ändern Menü Head
	 
	 $( document ).on( "vmouseover", "#powerofffront", function(){
            $("#poweroffback").css("background-color", "rgba(92,159,72,1.00)");
          });
	 $( document ).on( "vmouseover", "#navsonosfront", function(){
           $("#navsonosback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navfernsehenfront", function(){
            $("#navfernsehenback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navfilmfront", function(){
            $("#navfilmback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navfilmscreenfront", function(){
            $("#navfilmscreenback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navfilmtvfront", function(){
            $("#navfilmtvback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navfiretvfront", function(){
          $("#navfiretvback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navappletvfront", function(){
           $("#navappletvback").css("background-color", "rgba(92,159,72,1.00)");
          });
	$( document ).on( "vmouseover", "#navlightfront", function(){
           $("#navlightback").css("background-color", "rgba(92,159,72,1.00)");
          });
		  	  	  	  	  	  	  
	// Bei Mouseout Farbe zurückändern
	
	 $( document ).on( "vmouseout", "#powerofffront", function(){
            $("#poweroffback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navsonosfront", function(){
            $("#navsonosback").css("background-color", "rgba(180,159,159,0.0)");
          });	  
	 $( document ).on( "vmouseout", "#navfernsehenfront", function(){
            $("#navfernsehenback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navfilmfront", function(){
            $("#navfilmback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navfilmscreenfront", function(){
            $("#navfilmscreenback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navfilmtvfront", function(){
            $("#navfilmtvback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navfiretvfront", function(){
            $("#navfiretvback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navappletvfront", function(){
            $("#navappletvback").css("background-color", "rgba(180,159,159,0.0)");
          });
	$( document ).on( "vmouseout", "#navlightfront", function(){
            $("#navlightback").css("background-color", "rgba(180,159,159,0.0)");
          }); 
		   
	// Menu Oben Auf Mousklick reagieren
	/*
	$('#powerofffront').click(function(){
    	$('#testchange').html('Poweroff');
    });
	$('#navsonosfront').click(function(){
    	$('#testchange').html('Sonos');
    });
	$('#navfernsehenfront').click(function(){
    	$('#testchange').html('Fernsehen');
    });	  
	$('#navfilmfront').click(function(){
    	$('#testchange').html('Film');
    });
	$('#navfilmscreenfront').click(function(){
    	$('#testchange').html('Film Screen');
    });
	$('#navfilmtvfront').click(function(){
    	$('#testchange').html('TV Screen');
    });
	$('#navappletvfront').click(function(){
    	$('#testchange').html('Apple TV');
    });
	$('#navlightfront').click(function(){
    	$('#testchange').html('Licht');
    });
	*/
		  
	// Dreambox Cursortasten
	$('#navdreamenter').click(function(){
    	$('#testchange').html('Enter');
    });
	$('#navdreamleft').click(function(){
    	$('#testchange').html('Links');
    });
	$('#navdreamright').click(function(){
    	$('#testchange').html('Rechts');
    });
	$('#navdreamup').click(function(){
    	$('#testchange').html('Oben');
    });
	$('#navdreamdown').click(function(){
    	$('#testchange').html('Unten');
    });
	
	// Dreambox Colour Tasten
	$('#dreamgreen').click(function(){
    	$('#testchange').html('Green');
    });
	$('#dreamblue').click(function(){
    	$('#testchange').html('blue');
    });
	$('#dreamyellow').click(function(){
    	$('#testchange').html('yellow');
    });
	$('#dreamred').click(function(){
    	$('#testchange').html('red');
    });	  		  		  		  		  		  		  	
	/* Auch bei der jQuery-Funktion „toggle“ – können wir Übergangszeiten angeben:
	toggle('slow')
	toggle(200)
	toggle('fast')*/
	
	/* Funktionen verschachteln Callback */
	//$('#sobo-einausblenden').click(function(){
    //$('#sozialbookmarks').toggle('slow',
    //  function callback(){
    //    alert('Umschalten ist abgeschlossen');
	//	  }
	//	);
	//  })
	
	/* Flipswitch auf an setzten */
	 //$('#absatzon').click(function(){
    	//$("#flipdreamboxstatus").val('on').flipswitch('refresh');
		//});	
	
	/* Flipswitch auf aus setzten */
	 //$('#absatzoff').click(function(){
    	//$("#flipdreamboxstatus").val('off').flipswitch('refresh');
		//});	
	
	/*disable flipswitch */
	// Getter
	//var disabled = $( ".selector" ).flipswitch( "option", "disabled" );
 
	// Setter
	//$( ".selector" ).flipswitch( "option", "disabled", true );
	
	// Setter
	//$( "#dreamboxstatus2" ).flipswitch( "option", "offText", "Go" );
	//$( "#dreamboxstatus2" ).flipswitch( "option", "onText", "Stay" );
	
	/* Wert setzten */
	//$("#flipdreamboxstatus").val('on').flipswitch('refresh');

	/*Inhalt in div schreiben */
		
	//var title	= "Aktuelle Sendung";
	//$( "#title" ).html(title);
	
	
});