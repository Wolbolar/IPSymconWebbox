<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Grafik auslesen</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript" src="js/dynamicslider.js"></script>
<script type="text/javascript" src="js/jquery.ajaxformtestmodulneu.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default.js" type="text/javascript"></script>
<link href="css/jquery.mobile-1.4.5.iframe.css" rel="stylesheet" type="text/css">
<!-- CSS für Dynamischen Slider -->
<link href="css/dynamicslider.css" rel="stylesheet" type="text/css">
</head>

<body>
<div data-role="page" id="page1">
  
    <div role="main" class="ui-content">
    	<?php

		// Variable schreiben
		// $rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
		// $rpc->SetValue(54962 /*[Sonos\SONOSLibs\TTS Bad]*/, 18.5);

		//Media Grafik auslesen
		$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
		//$image = $rpc->IPS_GetMedia(40259 /*[Album_cover_Sonos_WohnzimmerBig.jpg]*/);
		//https://www.symcon.de/service/dokumentation/befehlsreferenz/medienverwaltung/ips-getmedia/
		$image = $rpc->IPS_GetMedia(40259 /*[Album_cover_Sonos_WohnzimmerBig.jpg]*/)['MediaFile'];
		
		print_r($image);


		echo "<img class='reflex' src='../../../media/Album_cover_Sonos_WohnzimmerBig.jpg' Big width='340' height='340' border='0' alt='Cover Sonos Wohnzimmer Big'></a>";
		//echo "<img class='reflex' src='../../../".$image." width='340' height='340' border='0' alt='Cover Sonos Wohnzimmer Big'></a>";
		

			
		?>
    </div>
</div>
</body>
</html>

