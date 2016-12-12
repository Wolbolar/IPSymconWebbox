<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dynamische Slider</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript" src="js/dynamicslider.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default.js" type="text/javascript"></script>
<link href="css/jquery.mobile-1.4.5.iframe.css" rel="stylesheet" type="text/css">
<!-- CSS für Dynamischen Slider -->
<link href="css/dynamicslider.css" rel="stylesheet" type="text/css">
<!-- Request Senden und Daten von PHP Seite abholen -->
    <!--<script type="text/javascript">

	var request = false;

	// Request senden
	function setRequest(value) {
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
					document.getElementById('currentvolume').innerHTML = content;
				}
				break;
			default:
				break;
		}
	}
  
  </script>//-->
  
<!-- IP Symcom Variablen für Javascript bereitstellen -->
<?
    $rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
    //Holt Variablen
    $volume = utf8_encode($rpc->GetValue(56959 /*[DENON\Main Zone\MasterVolume]*/));
    $volumeslider = round($volume + 80); // Rechnet Wert für Slider um und rundet Float
	//$volumesliderdiv = "<div hidden='true' id='volumeserver'>".$volumeslider."</div>";
?>
</head>

<body>
  
<div data-role="page" id="page1">
  
    <div role="main" class="ui-content">
      <div id="example8" class="example full-width-slider">
        <form action="slidersend.php" method="post">
        	<label for="theSlider8" class="ui-hidden-accessible">Tooltip:</label>
            <input type="range" name="theSlider8" id="theSlider8" min="0" max="98" value="<? echo $volumeslider; ?>" data-popup-enabled="true" data-highlight="true" />
        </form> 
      </div>
	  <div id="currentvolume"></div>  
		
    <!-- Schreibt aktuelles Volume vom AV Reciever -->
      <script type="text/javascript">
      var Volumeslider="<?php echo "Volume ".$volumeslider." %"; ?>";
      document.getElementById('currentvolume').innerHTML = Volumeslider;
	  
      </script>
    <!-- Sendet Request beim Ändern der Lautstärke -->
     <script type="text/javascript">
      $("#example8").change(function() {
      var slider_value = $("#theSlider8").val();
      // Sendet Request bei Ändern der Lautstärke
      setRequest(slider_value);
      });
      </script>
                
    </div>
</div>
</body>
</html>