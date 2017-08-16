<?php
header('Content-Type: text/xml; charset=utf-8'); // sorgt für die korrekte XML-Kodierung
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
// Alert Anzeige zeigt XML nicht an.
// FUNKTIONIERT ! XML


/***********************************************************************************************/

//Prüft ob POST oder GET

//POST
if (isset($_POST["command"]))
	{
		//echo "Es wurde POST verwendet";	
		
		// Command auslesen
		$command  = $_POST["command"];
		getdataips($command);
				
		// Leerzeichen vor und hinter den namen entfernen, sowie alles zu Kleinschreibung ändern
		//$vorname  = trim(strtolower($vorname));
		//$nachname = trim(strtolower($nachname));
		
	}
//GET
elseif (isset($_GET["command"]))
	{
		//echo "Es wurde GET verwendet";
		// Command auslesen
		
		$command = $_GET["command"];
		getdataips($command);
	}
//kein GET oder POST
else 
	{
		echo "Es wurden keine Daten empfangen";
	}

function sendstatusresponse($command, $status)
	{
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<statuslist>\n";
		echo "<status>\n";
		echo "<command>".$command."</command>\n";
		echo "<neostatus>".$status."</neostatus>\n";
		echo "</status>\n";
		echo "</statuslist>\n";
	}

function getdataips($command)
	{
		// Den gesendeten Befehl prüfen und passende Daten liefern
				
		// Skript starten
		if ($command == "ARD")// Befehl ausführen
			{
				//IPS_RunScript(48973 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Standby]*/);	
				SetValue(22247, "ARD");
				//$status = GetValue(12345); /* Status Dreambox */
				$status = "ARD";
				//Code to create XML file
				sendstatusresponse($command, $status);
			}
		elseif ($command == "ZDF")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "neooff")// Befehl ausführen
			{
			
				$status = $rpc->GetValue(22705 /*[Mediola\Testdevice\MediolaTest\Status]*/);
				//Code to create XML file
				if ($status == "true")
				{
					$rpc->SetValue(22705 /*[Mediola\Testdevice\MediolaTest\Status]*/, false);
				}
				$status = "false";
				sendstatusresponse($command, $status);

			}
		elseif ($command == "neoon")// Befehl ausführen
			{
			
				$status = $rpc->GetValue(22705 /*[Mediola\Testdevice\MediolaTest\Status]*/);
				//Code to create XML file
				if ($status == "false")
				{
					$rpc->SetValue(22705 /*[Mediola\Testdevice\MediolaTest\Status]*/, true);
				}
				$status = "true";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "neostatus?")// Befehl ausführen
			{
				$status = $rpc->GetValue(22705 /*[Mediola\Testdevice\MediolaTest\Status]*/);
				sendstatusresponse($command, $status);
			}			
		
		//Dreambox Cursor
		else if ($command == "dreamleft" OR $command == "dreamright" OR $command == "dreamup" OR $command == "dreamdown" OR $command == "dreamenter" )
			{
				//Befehl absetzten
				$status = "Alles Prima";
				sendstatusresponse($command, $status);
			}
		
		//Dreambox Remote
		else if ($command == "dreamred" OR $command == "dreamblue" OR $command == "dreamyellow" OR $command == "dreamred")
			{
				//Befehl absetzten
				$status = "Alles Bunt";
				sendstatusresponse($command, $status);
			}
												
		
		
	

	}






?>