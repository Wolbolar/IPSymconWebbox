<?php
header('Content-Type: text/xml; charset=utf-8'); // sorgt für die korrekte XML-Kodierung
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE

/*
// übermittelte Option auswerten
$option	= $_POST['option'];
switch ($option) {
	case 2:
		$name		= strtolower($_POST['name']);
		$alternate	= "Kleinbuchstaben";
		$image		= "images/smaller.png";
		break;
	case 3:
		$name		= strtoupper($_POST['name']);
		$alternate	= "Grossbuchstaben";
		$image		= "images/bigger.png";
		break;
	default:
		$name		= strtoupper(substr($_POST['name'], 0, 1)).strtolower(substr($_POST['name'], 1));
		$alternate	= "Normalansicht";
		$image		= "images/normal.png";
		break;
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<formatname>\n";
echo " <newname name=\"".$name."\" alternate=\"".$alternate."\" image=\"".$image."\" />\n";
echo "</formatname>\n";
*/

//Datenaustausch IP Symcon
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
	$value = ($_POST['value']);
	$option	= $_POST['option'];
		
	// Skript starten
	if ($value == "off")// Befehl ausführen
	{
    $rpc->IPS_RunScript(48973 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Standby]*/);
	$alternate	= "Aus";
	}
	elseif ($value == "on")// Befehl ausführen
	{
    $rpc->IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
	$alternate	= "An";
	}
	elseif ($value == "reload")// Befehl ausführen
	{
    //$rpc->IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
	$alternate	= "Reload";
	}
	
	$image		= "picon.png";
	
	//echo "Dreambox ist ".$status;
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<formatname>\n";
	echo " <newname value=\"".$value."\" alternate=\"".$alternate."\" image=\"".$image."\" />\n";
	echo "</formatname>\n";
	
	//schreibt Variable
	//$rpc->SetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/  , $status);


?>