<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>

<title>Mediola IP-Symcon Einbindung</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />



<link href="mediola.css" rel="stylesheet" type="text/css" /></head>

<body class="Form">
<?php

// Variable schreiben
// $rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
// $rpc->SetValue(54962 /*[Sonos\SONOSLibs\TTS Bad]*/, 18.5);

//Variable auslesen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
$ausgabe = $rpc->GetValueFormatted(18877 /*[Harmony\Laufende Harmony Aktivität\Laufende Aktivität]*/);


echo '<p>Laufende Aktivität: '.$ausgabe.'</p>';

	
?>
</body>

</html>




