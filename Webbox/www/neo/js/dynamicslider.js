

//$(document).on("pagecreate", "#page1", function(){
$(document).ready(function(){

"use strict";


    //EXAMPLE 1 - change highlight color based on slider value
    HighlightColor($("#theSlider1"));
    $("#theSlider1").on("change", function(){
        HighlightColor($(this));
    });
    function HighlightColor(slider){
        var theVal = slider.val();
        var color = "#0DB8B5";
        if (theVal < 20){
            color = "#D92727";
        } else if (theVal < 40){
            color = "#FC8F12";
        } else if (theVal < 60){
            color = "#FFE433";
        } else if (theVal < 80){
            color = "#6FCC43";
        }        
        slider.closest(".ui-slider").find(".ui-slider-bg").css("background-color", color);        
    }
    
    //EXAMPLE 2 - add labled color scale to slider track
    var colorback  = '<div class="sliderBackColor green">Low</div>';
        colorback += '<div class="sliderBackColor orange">Medium</div>';
        colorback += '<div class="sliderBackColor red">High</div>';
    
    $("#example2 .ui-slider-track").prepend(colorback);
    
    //EXAMPLE 2a - add tick marks to slider track    
    var ticks  = '<div class="sliderTickmarks "><span>0%</span></div>';
        ticks += '<div class="sliderTickmarks "><span>25%</span></div>';
        ticks += '<div class="sliderTickmarks "><span>50%</span></div>';
        ticks += '<div class="sliderTickmarks "><span>75%</span></div>';
        ticks += '<div class="sliderTickmarks "><span>100%</span></div>';
    
    $("#example2a .ui-slider-track").prepend(ticks);
    
    //EXAMPLE 3 - change active handle's glow color
    GlowColor($("#theSlider3"));
    $("#theSlider3").on("change", function(){
        GlowColor($(this));
    }); 
    function GlowColor(slider){
        var theVal = slider.val();
        var glowClass = "glowRed";
        if (theVal < 25){
            glowClass = "glowGreen";
        } else if (theVal < 50){
            glowClass = "glowBlue";
        } else if (theVal < 75){
            glowClass = "glowYellow";
        }      
        slider.parents(".glow").removeClass("glowBlue glowYellow glowRed glowGreen").addClass(glowClass);    
    }
    
    //EXAMPLE 4 - value on handle
    $("#theSlider4").closest(".ui-slider").find(".ui-slider-handle").text($("#theSlider4").val());
    $("#theSlider4").on("change", function(){
        $(this).closest(".ui-slider").find(".ui-slider-handle").text($(this).val());
    });  
    
    //EXAMPLE 5 - multi-state flip switch
    var switchBack  = '<div id="sw1" class="switch5BackColor pos1">pos 1</div>';
        switchBack += '<div id="sw2" class="switch5BackColor pos2">pos 2</div>';
        switchBack += '<div id="sw3" class="switch5BackColor pos3">pos 3</div>';
        switchBack += '<div id="sw4" class="switch5BackColor pos4">pos 4</div>';
        switchBack += '<div id="sw5" class="switch5BackColor pos5">pos 5</div>';    
    
    $("#example5 .ui-slider-track").on('click', '.switch5BackColor', function(){
        //make sure switch is in correct position
        var val = 1;
        if ($(this).hasClass("pos2")) {val = 2;}
        if ($(this).hasClass("pos3")) {val = 3;}
        if ($(this).hasClass("pos4")) {val = 4;}
        if ($(this).hasClass("pos5")) {val = 5;}
        $("#theSlider5").val(val).slider( "refresh" ).trigger("change");
        return false;
    });
    
    $("#example5 .ui-slider-track").prepend(switchBack);
    PositionSwitchHandle($("#theSlider5"));
    $("#theSlider5").on("change", function(){
        PositionSwitchHandle($(this));
    });
    
	//EXAMPLE 8 - change highlight color based on slider value
	// Farbe wird alle 10 Stufen geändert
    HighlightColorDenon($("#theSlider8"));
    $("#theSlider8").on("change", function(){
        HighlightColor($(this));
    });
	HighlightColorDenon($("#DenonVolumeSlider"));
    $("#DenonVolumeSlider").on("change", function(){
        HighlightColor($(this));
    });
	
    function HighlightColorDenon(slider){
        var theVal = slider.val();
        var color = "#cac82a";
        if (theVal < 10){
            color = "#48ad3a";
        } else if (theVal < 20){
            color = "#59ab83";
		} else if (theVal < 30){
            color = "#46b7b0";
		} else if (theVal < 40){
            color = "#2390b9";
		} else if (theVal < 50){
            color = "#2c54a6";			
        } else if (theVal < 60){
            color = "#844da1";
		} else if (theVal < 70){
            color = "#c27ebb";
		} else if (theVal < 80){
            color = "#df6ea3";
		} else if (theVal < 90){
            color = "#cb3030";			
        } else if (theVal < 99){
            color = "#7d1412";
        }        
        slider.closest(".ui-slider").find(".ui-slider-bg").css("background-color", color);        
    }
    
	//EXAMPLE 8 - change active handle's glow color
    GlowColorDenon($("#theSlider8"));
    $("#theSlider8").on("change", function(){
        GlowColorDenon($(this));
    }); 
	GlowColorDenon($("#DenonVolumeSlider"));
    $("#DenonVolumeSlider").on("change", function(){
        GlowColorDenon($(this));
    }); 
    function GlowColorDenon(slider){
        var theVal = slider.val();
        var glowClass = "glowRed";
        if (theVal < 25){
            glowClass = "glowGreen";
        } else if (theVal < 50){
            glowClass = "glowBlue";
        } else if (theVal < 75){
            glowClass = "glowYellow";
        }      
        slider.parents(".glow").removeClass("glowBlue glowYellow glowRed glowGreen").addClass(glowClass);    
    }
	
	
});


$(document).on( "pagecontainershow", function(){
    PositionSwitchHandle($("#theSlider5"));     
});
$(window).on("resize orientationchange", function(){
    PositionSwitchHandle($("#theSlider5"));
});

function PositionSwitchHandle(slider){
    var $handle = slider.closest(".ui-slider").find(".ui-slider-track");
    var handleWidth = $handle.width();
    var mgPct = (30 * 100) / handleWidth; //half thumb handle in pct of track
    var theVal = parseInt(slider.val());
    var margLeft = -mgPct;
    var glowClass = "pos3glow";
    var theText = "pos 3";
    if (theVal <= 1){
        margLeft = 10 - mgPct;
        glowClass = "pos1glow";
        theText = "pos 1";
    } else if (theVal === 2){
        margLeft = 5 - mgPct;
        glowClass = "pos2glow";
        theText = "pos 2";
    } else if (theVal === 4){
        margLeft = -5 - mgPct;
        glowClass = "pos4glow";
        theText = "pos 4";
    } else if (theVal >= 5){
        margLeft = -10 - mgPct;
        glowClass = "pos5glow";
        theText = "pos 5";
    }
    slider.closest(".ui-slider").find(".ui-slider-handle").css("marginLeft", margLeft + "%").text(theText);  
    slider.parents(".glow").removeClass("pos1glow pos2glow pos3glow pos4glow pos5glow").addClass(glowClass);
}


// Request des Sliders senden
var request = false;

	// Request senden
	function setRequest(value) {
		//alert ("Value erhalten: " + value);
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
			//var url = "slidersend.php";
			// Ändern wenn Seite in andern Verzeichnis liegt
			var url = "slidersend.php";
			// Request öffnen
			request.open('post', url, true);
			// Requestheader senden
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			//request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			// Request senden
			request.send('name='+value);
			// Request auswerten
			request.onreadystatechange = interpretRequest;
		}
	}

	// Request auswerten
	function interpretRequest() {
		switch (request.readyState) {
			// wenn der readyState 4 und der request.status 200 ist, dann ist alles korrekt gelaufen
			case 4:
				if (request.status != 200) {
					alert("Der Request wurde abgeschlossen, ist aber nicht OK\nFehler:"+request.status);
				} else {
					var content = request.responseText;
					// den Inhalt des Requests in das <div> schreiben
					
					$("currentvolume").html(currentvolume + " %");
					//document.getElementById('currentvolume').innerHTML = content;
				}
				break;
			default:
				break;
		}
	}