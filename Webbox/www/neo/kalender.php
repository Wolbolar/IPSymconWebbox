<!doctype html>
<?php
//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:3777/api/");
//$cal = $rpc->GetValueFormatted(53091 /*[Kalender\HTML Jahreskalender mit Keywords\Jahreskalender]*/);
$cal = $rpc->GetValue(53091 /*[Kalender\HTML Jahreskalender mit Keywords\Jahreskalender]*/);
 echo $cal;
?>
