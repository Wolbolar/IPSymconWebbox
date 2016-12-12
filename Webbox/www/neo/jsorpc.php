<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Kanalliste</title>
<link href="css/dreambox.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6,n4:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>
</head>

<body>
<div id="main">
<?php

$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
// $description = utf8_encode($rpc->GetValueFormatted(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/)); //Formatiert
 $description = utf8_encode($rpc->GetValue(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/));
 echo $description;

 
  
?>	
</div>
</body>
</html>