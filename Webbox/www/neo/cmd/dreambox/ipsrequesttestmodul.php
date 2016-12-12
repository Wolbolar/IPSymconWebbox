<?php
// Mit Header geht nicht aber Beschreibung wird falsch codiert
//header('Content-Type: text/xml; charset=utf-8'); // sorgt für die korrekte XML-Kodierung
//header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE

// FUNKTIONIERT ! XML

/*
* Konfiguration
*/
$ipadr = "192.168.55.37"; // IP Adresse der Dreambox
$bouquet = "1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
//Holt Variablen
		$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
		
/***********************************************************************************************/

//Prüft ob POST oder GET

//POST
if (isset($_POST["command"]))
	{
		echo "Es wurde POST verwendet";	
		
		// Command auslesen
		$command  = $_POST["command"];
		//getdataips($command, $ipadr, $rpc);
				
		// Leerzeichen vor und hinter den namen entfernen, sowie alles zu Kleinschreibung ändern
		//$vorname  = trim(strtolower($vorname));
		//$nachname = trim(strtolower($nachname));
		
	}
//GET
elseif (isset($_GET["command"]))
	{
		echo "Es wurde GET verwendet";
		// Command auslesen
		
		$command = $_GET["command"];
		//getdataips($command, $ipadr, $rpc);
	}
elseif (isset($_POST["volume"]))
{	
	$volumeslider = ($_POST['volume']);
	//echo "Volume ".$volumeslider." %";
	$volume = $volumeslider - 80;
	//schreibt Variable
	$rpc->SetValueFloat(24788 /*[Mediola\Testdevice\MediolaTest\NEO Denon Volume]*/  , $volume);
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<e2eventlist>\n";
		echo "<e2event>\n";
		echo "<e2eventvolume>".$volumeslider."</e2eventvolume>\n";
		echo "</e2event>\n";
		echo "</e2eventlist>\n";
	
	
}

//kein GET oder POST
else 
	{
		echo "Es wurden keine Daten empfangen";
	}


function getdataips($command, $ipadr, $rpc)
	{
		// Den gesendeten Befehl prüfen und passende Daten liefern
		//$dreamboxwebapi
		
		//switch case einbauen
		
		// Skript starten
		if ($command == "dreamboxoff")// Befehl ausführen
		{
		//$rpc->IPS_RunScript(48973 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Standby]*/);
	
		// Prüfen ob Box wirklich an an ist
		// Funktion aufrufen
		// Wert zurücksenden
		// Ausgabe an aufrufende javascriptseite als XML
		//Code to create XML file
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<command>".$command."</command>\n";
		echo "<e2eventlist>\n";
		echo "<e2event>\n";
		echo "<e2eventstatus>off</e2eventstatus>\n";
		echo "</e2event>\n";
		echo "</e2eventlist>\n";
		}
		elseif ($command == "dreamboxon")// Befehl ausführen
		{
		//$rpc->IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
		// Prüfen ob Box wirklich an an ist
		// Funktion aufrufen
		// Wert zurücksenden
		// Ausgabe an aufrufende javascriptseite als XML
		//Code to create XML file
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<command>".$command."</command>\n";
		echo "<e2eventlist>\n";
		echo "<e2event>\n";
		echo "<e2eventstatus>on</e2eventstatus>\n";
		echo "</e2event>\n";
		echo "</e2eventlist>\n";
		}
		elseif ($command == "status?")// Befehl ausführen
			{
			GetIPSVars($rpc, $command);
			}
		else if ($command == "kanalliste")
			{
			$bouquet = "1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
			Enigma2_getChannelList ($ipadr, $bouquet);
			}
		else{
		ENIGMA2_Getcurrent($ipadr);
		}
		// command abfragen und passende Funktion abrufen
		
		//XML generieren
		/*
		include "class.xmlresponse.php";

		  $retval = "output of PHP script";
		
		  $xml = new xmlResponse();
		  $xml->start();
		
		  $xml->command("setstyle",
			array("target" => "output", "property" => "display", "value" => "block")
		  );
		
		  $xml->command("setcontent", 
			array("target" => "samplecode"), 
			array("content" => htmlentities($retval))
		  );
		
		  $xml->end();
		*/

	}

function GetIPSVars($rpc, $command)
{
//Daten von IPS auslesen

		// Skript starten
		// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
		$sender = $rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/);
		$status = $rpc->GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); // Status der Dreambox
		$picon = $rpc->GetValue(19948 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Picture Reference]*/); /* Picture Referenz */
		$URL = $rpc->GetValue(59613 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender Stream]*/);
		$title = $rpc->GetValue(57911 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Sendungstitel]*/); /* Sendertitel */
		$start = $rpc->GetValue(29169 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Start]*/); /* Startzeit */
		$ende = $rpc->GetValue(24681 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Ende]*/); /* Endzeit */				
		$sref = $rpc->GetValue(24168 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\aktuelle Servicereferenz]*/); /* aktuelle Servicereferenz */			
		$dauer = $rpc->GetValue(16988 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Dauer]*/); /* Dauer */
		$vorbei = $rpc->GetValue(26828 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Vergangen]*/); /* vergangene Zeit */
		$verbl = $rpc->GetValue(26663 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Verbleiben]*/); /* verbleibende Zeit */
		$description = $rpc->GetValue(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/); /* Beschreibung */
		$fortschritt = $rpc->GetValue(20384 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Sendungsfortschritt]*/ ); /* Sendungsfortschritt */
		$snr = $rpc->GetValue(31373 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\SNR]*/ ); /* SNR= Signal to Noise (Signal/Rauschabstand)  */
		$ber = $rpc->GetValue(50887 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\BER]*/ ); /*  BER = Bit Errr Rate (Soll immer 0 sein) */
		$acg = $rpc->GetValue(43413 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Empfangspegel (AGC)]*/ ); /* AGC = Automatic Gain Controll */
		$snrdb = $rpc->GetValue(44386 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\snrdb]*/ ); /* SNR= Signal to Noise (Signal/Rauschabstand) dB */
		
				
		//Daten zurücksenden
		// Ausgabe an aufrufende javascriptseite als XML
		//Code to create XML file
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<command>".$command."</command>\n";
		echo "<e2eventlist>\n";
		echo "<e2event>\n";
		echo "<e2eventid>53554</e2eventid>\n";
		echo "<e2eventstart>".$start."</e2eventstart>\n";
		echo "<e2eventend>".$ende."</e2eventend>\n";
		echo "<e2eventvorbei>".$vorbei."</e2eventvorbei>\n";
		echo "<e2eventverbl>".$verbl."</e2eventverbl>\n";
		echo "<e2eventprogress>".$fortschritt."</e2eventfortschritt>\n";
		echo "<e2eventduration>".$dauer."</e2eventduration>\n";
		echo "<e2eventcurrenttime>1440284815</e2eventcurrenttime>\n";
		echo "<e2eventtitle>".$title."</e2eventtitle>\n";
		echo "<e2eventdescription/>\n";
		echo "<e2eventdescriptionextended>".$description."</e2eventdescriptionextended>\n"; // Lange Beschreibung
		echo "<e2eventservicereference>".$sref."</e2eventservicereference>\n";
		echo "<e2eventservicename>".$sender."</e2eventservicename>\n";
		echo "<e2eventstatus>".$status."</e2eventstatus>\n";
		echo "</e2event>\n";
		echo "</e2eventlist>\n";
			
}


//Test


/**
*  Prüft über Ping ob Gerät erreichbar
*  Return
*  true  -  wenn erreichbar
*  false -  nicht erreichbar
**/

function ENIGMA2_GetAvailable($ipadr)
{
   $result = false;
   if ($ipadr > "" )
    {
       $result = (Boolean) Sys_Ping($ipadr, 1000);   // Ping max. 1 Sek. warten
   }
return $result;
}

/*
* /web/getcurrent Liefert Daten der nächsten zwei Sendungen des laufenden Senders
*/
function ENIGMA2_Getcurrent($ipadr)
{
   if (ENIGMA2_GetAvailable($ipadr))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getcurrent"));

		if ($xmlResult->e2volume->e2result == "True")
      	{
         $result = ($xmlResult->e2resulttext);
         echo $xmlResult->asXML();
			}
		  else
          {
			  $result = "error";
			  echo "Fehler aufgetreten!";
          }

   }
   else
      {
      $result = "not available";
      echo "nicht verfügbar";
      }
    return $result;
}


/*
* Kanal Liste EPG Now
*/
function Enigma2_getChannelList ($ipadr, $bouquet)
{

	$xml = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/epgnow?bRef=$bouquet"));
	$number = ($xml->e2event->count());

	if ($number < 1)
	{
		$error = "Diesem Bouquet sind keine Sender zugeordnet.";
		return array("error" => $error);
	}

	$service = array();
  $channellist = $xml->e2event;
    foreach ($channellist as $channelxml)
		{
		  $name = utf8_decode($channelxml->e2eventservicename);
		  $title = utf8_decode($channelxml->e2eventtitle);
			$desc = utf8_decode($channelxml->e2eventdescriptionextended);
		  $desc =  str_replace('Š','<br>',$desc);
			$sref = utf8_decode($channelxml->e2eventservicereference);
		  $pref = str_replace(':','_',$sref);
			$pref = substr($pref, 0, -1);

			$service[] = array(
				"name" => $name,
				"title" => $title,
				"desc" => $desc,
				"sref" => $sref,
				"pref" => $pref
			);
			
		}
		echo $xml->asXML();
	return $service;
}

?>