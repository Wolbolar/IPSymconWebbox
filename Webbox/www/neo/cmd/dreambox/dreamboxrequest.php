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
				SetValue(22247, "Das Erste HD");
				//$status = GetValue(12345); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'Das Erste HD');
				$status = "Das Erste HD";
				//Code to create XML file
				sendstatusresponse($command, $status);
			}
		elseif ($command == "ZDF")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'ZDF HD');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "RTL")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'RTL Television');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}	
		elseif ($command == "PRO7")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'ProSieben');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}		
		elseif ($command == "Sat1")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'SAT.1');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "Vox")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'VOX');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}			
		elseif ($command == "Kabel1")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'kabel eins');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "RTL2")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'RTL2');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}	
		elseif ($command == "HR")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'hr-fernsehen');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}	
		elseif ($command == "NDR")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'NDR FS HH HD');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}			
		elseif ($command == "SWR")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'SWR BW HD');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "WDR")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'WDR HD Köln');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}						
		elseif ($command == "BR")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'BR Nord HD');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "NeoHD")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'zdf_neo HD');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "Sixx")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'SIXX');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "Tagesschau24")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'tagesschau24');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "KikaHD")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'KiKA HD');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}		
		elseif ($command == "SuperRTL")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'SUPER RTL');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "DisneyChannel")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'Disney Channel');
				$status = "ZDF";
				sendstatusresponse($command, $status);
			}
		elseif ($command == "Tele5")// Befehl ausführen
			{
				//IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				SetValue(22247, "ZDF");
				//$status = GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				Enigma2BY_ZapTo(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'TELE 5');
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
				if($command == "dreamleft")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'ArrowLeft', 'short');	
					}
				elseif($command == "dreamright")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'ArrowRight', 'short');	
					}
				elseif($command == "dreamup")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'ArrowUp', 'short');	
					}
				elseif($command == "dreamdown")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'ArrowDown', 'short');	
					}
				elseif($command == "dreamenter")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'OK', 'short');	
					}		
				$status = "Alles Prima";
				sendstatusresponse($command, $status);
			}
		
		//Dreambox Remote
		else if ($command == "dreamred" OR $command == "dreamblue" OR $command == "dreamyellow" OR $command == "dreamgreen")
			{
				//Befehl absetzten
				if($command == "dreamred")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'RED', 'short');
					}
				elseif($command == "dreamblue")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'BLUE', 'short');
					}
				elseif($command == "dreamyellow")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'YELLOW', 'short');
					}
				elseif($command == "dreamgreen")
					{
						Enigma2BY_SendKey(20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/, 'GREEN', 'short');
					}			
				$status = "Alles Bunt";
				sendstatusresponse($command, $status);
			}
												
		
		
	

	}






?>