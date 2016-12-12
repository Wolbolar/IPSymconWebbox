<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>EPG Dreambox</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">

<link rel="icon" href="../../favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/dreambox.css" />

</head>

<body>
<div>
<?php

$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.120:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
// $description = utf8_encode($rpc->GetValueFormatted(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/)); //Formatiert
 $description = utf8_encode($rpc->GetValue(28896 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Folgende Sendungen]*/));
 echo $description;

 
  
?>	
</div>


</body>

</html>