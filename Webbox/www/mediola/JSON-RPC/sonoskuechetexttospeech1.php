<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Formular</title>
</head>

<body>
<?php
$tts = $_POST['speech'];

echo $tts." gesendet";

// Variable schreiben
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
$rpc->SetValue(59544 /*[Sonos\SONOSLibs\TTS Küche]*/, $tts);


?>
</body>
</html>



