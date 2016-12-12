<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Formular</title>
</head>

<body>
<?php
$tts = $_GET['vorname'];
echo "eingetragener Vorname: ". $tts;
?>
<form action="senden.html" method="get">
        <label for="texttospeech">Textausgabe Sonos Bad</label> 
        <input type="text" id="Text" maxlength="30">
 
        <button type="reset">Eingaben zurücksetzen</button>
        <button type="submit">Eingaben absenden</button>
    </form>
<?php
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
$ausgabe = $rpc->GetValueFormatted(59450 /*[Mediola\JSON-RPC\Test Switch]*/);

echo '<p>Beschreibung: '.$ausgabe.'</p>';
?>
</body>
</html>


