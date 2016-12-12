<?
header('Content-Type: text/xml; charset=utf-8'); // sorgt für die korrekte XML-Kodierung
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
// Alert Anzeige zeigt XML nicht an.
// FUNKTIONIERT ! XML

/*
* Konfiguration
*/

//Holt Variablen
		$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
		
/***********************************************************************************************/

if (isset($_POST["DenonVolumeSlider"]))
{	
	$volumeslider = ($_POST['DenonVolumeSlider']);
	//echo "Volume ".$volumeslider." %";
	if ($volumeslider == "Vol?")
		{
		$command = "Vol?";
		$volumeslider = $rpc->GetValue(24788 /*[Mediola\Testdevice\MediolaTest\NEO Denon Volume]*/);
		$volume = $volumeslider + 80;
		}
	else
		{
		$command = "x";	
		$volume = $volumeslider - 80;
		//schreibt Variable
		$rpc->SetValueFloat(24788 /*[Mediola\Testdevice\MediolaTest\NEO Denon Volume]*/  , $volume);
		$volume = $volumeslider;
		}

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<denoneventlist>\n";
		echo "<denonevent>\n";
		echo "<denonmastervolume>".$volume."</denonmastervolume>\n";
		echo "<command>".$command."</command>\n";
		echo "</denonevent>\n";
		echo "</denoneventlist>\n";
}
	
?>
