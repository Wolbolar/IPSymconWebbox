<?php
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

//Prüft ob POST oder GET

//POST
if (isset($_POST["Datepicker"]))
	{
		//echo "Es wurde POST verwendet";	
		
		// Command auslesen
		$datepicker  = $_POST["Datepicker"];
		setdate($datepicker);
				
		
	}

//kein GET oder POST
else 
	{
		echo "Es wurden keine Daten empfangen";
	}

function setdate($datepicker)
	{
		$rpc->SetValue(40700, $datepicker);
		
	}


?>