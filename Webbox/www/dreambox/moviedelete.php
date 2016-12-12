<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>Movie Delete</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">

<link rel="icon" href="../../favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/dreambox.css" />

</head>

<body>
<div>
<?php
include IPS_GetKernelDir().'scripts/f_Enigma_2.ips.php'; 
// Funktionaufruf aus Formular
if(isset($_GET['DeleteMovie']))
{
		 $sref = $_GET['DeleteMovie'];
		 echo $sref;
		 //$result = ENIGMA2_MovieDelete($dm8000ip, $_GET['DeleteMovie']);
		 // neue Aufnahmeliste abfragen
		 $rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.120:3777/api/");
		 //$rpc->IPS_RunScript(31281 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\Abfragen\Movie List]*/);
		 // Popup Öffnen mit Ergebnis
		// aufnahmeliste.php öffnen
		 //header('Location: aufnahmeliste.php');
		//exit;
}

// $description = utf8_encode($rpc->GetValueFormatted(14155 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aufnahmeliste]*/)); //Formatiert
//$aufnahmeliste = utf8_encode($rpc->GetValue(14155 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aufnahmeliste]*/));
//echo $aufnahmeliste;

?>	
</div>


</body>

</html>