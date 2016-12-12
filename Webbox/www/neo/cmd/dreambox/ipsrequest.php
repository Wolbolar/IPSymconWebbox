<?php
header('Content-Type: text/xml; charset=utf-8'); // sorgt für die korrekte XML-Kodierung
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
// Alert Anzeige zeigt XML nicht an.
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
		//echo "Es wurde POST verwendet";	
		
		// Command auslesen
		$command  = $_POST["command"];
		getdataips($command, $ipadr, $rpc);
				
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
		if ($command == "epgservice")
			{
				$sref = $_GET["sref"];
				ENIGMA2_epgservice($ipadr, $sref, $command);
			}
		else {	
		getdataips($command, $ipadr, $rpc);
		}
	}
elseif (isset($_POST["DenonVolumeSlider"]))
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
			
				// Prüfen ob Box wirklich aus ist
				$status = ENIGMA2_Power ($ipadr);
				if ($status == "on")
				{
				$rpc->IPS_RunScript(48973 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Standby]*/);	
				}
				$status = $rpc->GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				//Code to create XML file
				
				echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
				echo "<e2eventlist>\n";
				echo "<e2event>\n";
				echo "<command>".$command."</command>\n";
				echo "<e2eventstatus>".$status."</e2eventstatus>\n";
				echo "</e2event>\n";
				echo "</e2eventlist>\n";
			}
		elseif ($command == "dreamboxon")// Befehl ausführen
			{
			
				$status = ENIGMA2_Power ($ipadr);
				//Code to create XML file
				if ($status == "off")
				{
					$rpc->IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
				}
				$status = $rpc->GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); /* Status Dreambox */
				echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
				echo "<e2eventlist>\n";
				echo "<e2event>\n";
				echo "<command>".$command."</command>\n";
				echo "<e2eventstatus>".$status."</e2eventstatus>\n";
				echo "</e2event>\n";
				echo "</e2eventlist>\n";
			}
		elseif ($command == "getcurrent")// Befehl ausführen
			{
					ENIGMA2_Getcurrent($ipadr, $command);
				// Initiale Abfrage der Daten für Seitenaufbau
				//GetIPSVars($rpc, $command, $ipadr);
			}
		elseif ($command == "status?")// Befehl ausführen
			{
					ENIGMA2_Getcurrent($ipadr, $command);
				// Initiale Abfrage der Daten für Seitenaufbau
				//GetIPSVars($rpc, $command, $ipadr);
			}
		else if ($command == "epgnow")
			{
				$bouquet = "1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
				Enigma2_getChannelList ($ipadr, $bouquet, $command);
			}
			
		else if ($command == "movielist.html")
			{
				ENIGMA2_getMovieList($ipadr, $command);
			}
		else if ($command == "about")
			{
				ENIGMA2_GetBoxInfo($ipadr, $command);
			}
		//Logitech Hub Actions	
		else if ($command == "hpoweroff" OR $command == "harmonyactivity" OR $command == "htv" OR $command == "hsonos" OR $command == "hmovietv" OR $command == "hmoviescreen" OR $command == "htvscreen" OR $command == "hfiretv" OR $command == "happletv")
			{
				HarmonyHub_Send($rpc, $command);
			}
		
		//Dreambox Cursor
		else if ($command == "dreamleft" OR $command == "dreamright" OR $command == "dreamup" OR $command == "dreamdown" OR $command == "dreamenter" )
			{
				ENIGMA2_RemoteControl($ipadr, $command);
			}
		
		//Dreambox Remote
		else if ($command == "dreamred" OR $command == "dreamblue" OR $command == "dreamyellow" OR $command == "dreamred")
			{
				ENIGMA2_RemoteControl($ipadr, $command);
			}
												
		/*
		else if ($command == "epgservice")
			{
				ENIGMA2_epgservice($ipadr, $sref, $command);
			}
		*/
		// command abfragen und passende Funktion abrufen
		
	

	}


function GetIPSVars($rpc, $command, $ipadr)
{
//Daten von IPS auslesen
		
		// Daten direkt aus der Dreambox abholen
		// Prüfen ob Box wirklich aus ist
			$status = ENIGMA2_Power ($ipadr);
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
		
		
		//Werte an Dreambox Funktion übergeben und zu XML ergänzen
		
		
				
		//Daten zurücksenden
		// Ausgabe an aufrufende javascriptseite als XML
		//Code to create XML file
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<e2eventlist>\n";
		echo "<e2event>\n";
		echo "<command>".$command."</command>\n";
		echo "<e2eventid>53554</e2eventid>\n";
		echo "<e2eventstart>".$start."</e2eventstart>\n";
		echo "<e2eventend>".$ende."</e2eventend>\n";
		echo "<e2eventvorbei>".$vorbei."</e2eventvorbei>\n";
		echo "<e2eventverbl>".$verbl."</e2eventverbl>\n";
		echo "<e2eventprogress>".$fortschritt."</e2eventprogress>\n";
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

// Dreambox Remote Control
function ENIGMA2_RemoteControl($ipadr, $command)
{
   
   switch($command){
	  case "dreamleft":
	  $command = "105";
	  break;
 
	  case "dreamright":
	  $command = "106";
	  break;

	  case "dreamup":
	  $command = "103";
	  break;
	  
	  case "dreamdown":
	  $command = "108";
	  break;

	  case "dreamenter":
	  $command = "352";
	  break;
	  
	  case "dreamremotepower":
	  $command = "116";
	  break;
	  
	  case "1":
	  $command = "2";
	  break;
	  
	  case "2":
	  $command = "3";
	  break;
	  
	  case "3":
	  $command = "4";
	  break;
	  
	  case "4":
	  $command = "5";
	  break;
	  
	  case "5":
	  $command = "6";
	  break;
	  
	  case "6":
	  $command = "7";
	  break;
	  
	  case "7":
	  $command = "8";
	  break;
	  
	  case "8":
	  $command = "9";
	  break;
	  
	  case "9":
	  $command = "10";
	  break;
	  
	  case "0":
	  $command = "11";
	  break;
	  
	  case "previous":
	  $command = "412";
	  break;
	  
	  case "next":
	  $command = "407";
	  break;
	  
	  case "red":
	  $command = "398";
	  break;
	  
	  case "green":
	  $command = "399";
	  break;
	  
	  case "yellow":
	  $command = "400";
	  break;
	  
	  case "blue":
	  $command = "401";
	  break;
	  
	  case "mute":
	  $command = "113";
	  break;
	  
	  case "volumeup":
	  $command = "115";
	  break;
	  
	  case "volumedown":
	  $command = "114";
	  break;
	  
	  case "blue":
	  $command = "401";
	  break;

/*
402 Key "bouquet up"

174 Key "lame"
403 Key "bouquet down"
358 Key "info"

139 Key "menu"
392 Key "audio"

393 Key "video"

377 Key "tv"
385 Key "radio"
388 Key "text"
138 Key "help"
*/ 
   }
   
	if (ENIGMA2_GetAvailable($ipadr))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/remotecontrol?command=".$command));
      if ($xmlResult->e2result == "True")
         {
		 echo $xmlResult->asXML();	 
		 $result = ($xmlResult->e2resulttext);
		 }
        else
           $result = "error";
   }
   else
      $result = "not available";
    return $result;
}



// Senden an Logitech Harmony Hub
function HarmonyHub_Send($rpc, $command)
{
	
	if ($command == "harmonyactivity")
		{
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "hpoweroff")
		{
			// Befehl senden
			$rpc->IPS_RunScript(39448 /*[Harmony\Aktionen\PowerOff]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "htv")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(45568 /*[Harmony\Aktionen\Fernsehen]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "hsonos")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(39381 /*[Harmony\Aktionen\Wohnzimmer]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "hmovietv")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(28771 /*[Harmony\Aktionen\Film anschauen]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "hmoviescreen")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(27478 /*[Harmony\Aktionen\Film FTV Leinwand]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "htvscreen")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(57707 /*[Harmony\Aktionen\TV Leinwand]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "hfiretv")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(15763 /*[Harmony\Aktionen\Amazon Prime]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}
	else if ($command == "happletv")
		{
			// Befehl senden 
			$rpc->IPS_RunScript(47340 /*[Harmony\Aktionen\AppleTV]*/); 
			// Pause einfügen
			$activity = $rpc->GetValueFormatted(33881 /*[Harmony\Activity]*/); // Gibt den Wert aus dem Variablenprofil zurück
		}								
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<harmonyhublist>\n";
	echo "<harmonyevent>\n";
	echo "<command>".$command."</command>\n";
	echo "<harmonyactivity>".$activity."</harmonyactivity>\n";
	echo "</harmonyevent>\n";
	echo "</harmonyhublist>\n";
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

function ENIGMA2_Getcurrent($ipadr, $command)
{
   if (ENIGMA2_GetAvailable($ipadr))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getcurrent"));

		if ($xmlResult->e2volume->e2result == "True")
      	{
         $result = ($xmlResult->e2resulttext);
		 
		 $addcommand = $xmlResult->e2service[0]->addChild('command', $command);
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

//*************************************************************************************************************
// Ermittelt die EPG-Daten eines definierten Senders /web/epgservice?sRef=&time=&endTime=
function ENIGMA2_epgservice($ipadr, $sref, $command)
{
   $xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/epgservice?sRef=".$sref));
   $addcommand = $xmlResult->e2event[0]->addChild('command', $command);
   echo $xmlResult->asXML();
return $xmlResult;
}


// Lese alle Timerevents aus
// Array mit den Daten = String
function ENIGMA2_GetTimerList($ipadr)
{

  global $config;

  $string = file_get_contents("http://".$ipadr."/web/timerlist");
	$xml = new SimpleXMLElement($string);
	$number = ($xml->e2timer->count());

	if ($number < 1)
	{
		$error = "Es wurden keine aktiven Timer gefunden!";
		return array("error" => $error);
	}

	$service = array();
  $timerlist = $xml->e2timer;
    foreach ($timerlist as $timerxml)
		{
		$sref = (string)str_replace(':','%3A',"$timerxml->e2servicereference");
		$pref = str_replace(':','_',"$timerxml->e2servicereference");
		$name = utf8_decode("$timerxml->e2servicename");
		$id = utf8_decode("$timerxml->e2eit");
		$titel = utf8_decode("$timerxml->e2name");
		$desc = utf8_decode("$timerxml->e2description");
		$xdesc = utf8_decode("$timerxml->e2descriptionextended");
		$tbeg = utf8_decode("$timerxml->e2timebegin");
		$tend = utf8_decode("$timerxml->e2timeend");
		$estart = getdate("$timerxml->e2timebegin");
      $estart = utf8_decode("$estart[hours]:$estart[minutes]");
		$eend = getdate("$timerxml->e2timeend");
      $eend = utf8_decode("$eend[hours]:$eend[minutes]");
		$duration = utf8_decode("$timerxml->e2duration");
		$disabled = utf8_decode("$timerxml->e2disabled");
		$justplay = utf8_decode("$timerxml->e2justplay");

			$timer[] = array(
				"sref" => $sref,
				"pref" => $pref,
				"name" => $name,
				"id" => $id,
				"titel" => $titel,
				"desc" => $desc,
				"xdesc" => $xdesc,
				"tbeg" => $tbeg,
				"tend" => $tend,
				"estart" => $estart,
				"eend" => $eend,
				"duration" => $duration,
				"disabled" => $disabled,
				"justplay" => $justplay
			);
		}
	return $timer;
}


// löscht bereits abgearbeitete Timer aus der Liste
function ENIGMA2_CleanupTimer($ipadr)
{
    if (ENIGMA2_GetAvailable( $ipadr ))
    {
        $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/timercleanup?cleanup="));
   }

}

/*
* löscht einen Timer
*/

function ENIGMA2_deleteTimer($ipadr, $sref, $tbeg, $tend)
{
    if (GetAvailable($ipadr))
    {
    	$string = file_get_contents("http://".$ipadr."/web/timerdelete?sRef=".$sref."&begin=".$tbeg."&end=".$tend);
    	$result = new SimpleXMLElement($string);
      $result = $result->e2statetext;

    //WFC_SendNotification(43692 /*[Objekt #43692 existiert nicht]*/, 'Dreambox - Timer gelöscht', "$result \n", 'Speaker', 4);
   }
	return $result;

}

/*
* Erstellt einen Timer mit Event ID
* http://IP_of_your_box/web/timeraddbyeventid?sRef=1:0:1:7926:A:70:1680000:0:0:0:&eventid=53779&dirname=/hdd/movie/
*/
function ENIGMA2_addTimer($ipadr, $sref, $id)
	{
	$xmlResult =  new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/timeraddbyeventid?sRef=".$sref."&eventid=".$id."&dirname=/hdd/movie/"));
	return $xmlResult;
	}


// liest Infos zur Dreambox aus
// Rückgabewert = Array ($e2enigmaversion, $e2imageversion, $e2webif, $model, $hdd, $capacity, $hddfree, $description)
function ENIGMA2_GetBoxInfo($ipadr, $command)
{
  	if (ENIGMA2_GetAvailable($ipadr))
    {
        $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/about"));
         $e2enigmaversion = utf8_decode($xmlResult->e2about->e2enigmaversion);
			$e2imageversion = utf8_decode($xmlResult->e2about->e2imageversion);
         $e2webif = utf8_decode($xmlResult->e2about->e2webifversion);
         $model = utf8_decode($xmlResult->e2about->e2model);
         $hdd = utf8_decode($xmlResult->e2about->e2hddinfo->model);
         $capacity = utf8_decode($xmlResult->e2about->e2hddinfo->capacity);
        $hddfree = utf8_decode($xmlResult->e2about->e2hddinfo->free);
		
   		echo $xmlResult->asXML();
    }
    
    		$boxinfo[] = array(
				"enigmaversion" => $e2enigmaversion,
				"imageversion" => $e2imageversion,
				"webif" => $e2webif,
				"model" => $model,
				"hdd" => $hdd,
				"capacity" => $capacity,
				"hddfree" => $hddfree
				);
	
		return $boxinfo;
    
}




/*****************************************************************************************************
* Sendet einen RemoteControl code an CGI. Infos unter
* "http://dream.reichholf.net/wiki/Webinterface_Befehle#Wiedergabe_und_Aufnahme"
play
pause
forward
rewind
stop
record
*/
function ENIGMA2_RemoteControlCGI($ipadr,$command)
{
   	if (ENIGMA2_GetAvailable($ipadr))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/cgi-bin/videocontrol?command=".$command));
      if ($xmlResult->e2result == "True")
         $result = ($xmlResult->e2resulttext);
        else
           $result = "error";
   }
   else
      $result = "not available";
    return $result;
}



/**
Umschalten
**/
function ENIGMA2_Zap($ipadr,$sref)
{
$zap = file_get_contents("http://$ipadr/web/zap?sRef=$sref");
$result = new SimpleXMLElement($zap);
  $e2state = $result->e2state;

    if ($e2state == "True")
    {
  	//$string = file_get_contents("http://".$ipadr."/web/subservices");
    //$xmlResult = new SimpleXMLElement($string);
    //$name = $xmlResult->e2service[0]->e2servicename;
    //$name = utf8_decode($name);
  //    $event = $xmlResult->e2eventlist->e2event->e2eventname;
    //$eventtitel = $xmlResult->e2service[0]->e2providername;
    //$eventtitel = utf8_decode($eventtitel);

    //WFC_SendNotification(43692 /*[Objekt #43692 existiert nicht]*/, 'Dreambox - Zap to', "$name \n", 'Speaker', 4);
    //SetValueString ($config['current'], "$name \n"); // Aktueller Sendername
    //SetValueString ($config['event'], "$eventtitel");
    $e2statetext = utf8_decode($result->e2statetext);
    IPS_RunScript(37875 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\Abfragen\get_EPG]*/);
    IPS_LogMessage( "Umschalten:" , $e2statetext );
    }
	else
	{
	$e2statetext = "cannot zap while device is in standby";
	}
	return $e2statetext;
}



// Prüft die Signalstärke des Senders
function ENIGMA2_SignalStatus($ipadr)
{
    if (ENIGMA2_GetAvailable( $ipadr ))
        {
        $xml = simplexml_load_file("http://$ipadr/web/signal?.xml");
        $snrdb = (int)$xml->e2snrdb;
        $snr = (int)$xml->e2snr;
        $ber = (int)$xml->e2ber;
        $acg = (int)$xml->e2acg;
        }
    else
        {
        $snrdb = 0;
        $snr = 0;
        $ber = 0;
        $acg = 0;
        }

return array($snrdb, $snr, $ber, $acg);
}



/*
* Movie List, zeigt Liste alle Aufnahmen movielist.html
*/
function ENIGMA2_getMovieList($ipadr, $command)
{
	$xml = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/movielist?dirname=/hdd/movie/&tag="));
	$number = ($xml->e2movie->count());

	if ($number < 1)
	{
		$error = "Es wurden keine Aufnahmen gefunden!";
		return array("error" => $error);
	}

	$addcommand = $xml->e2movie[0]->addChild('command', $command);
	$service = array();
  	$movielist = $xml->e2movie;
    foreach ($movielist as $moviexml)
		{
		$name = utf8_decode("$moviexml->e2servicename"); //Sendername
		$titel = utf8_decode("$moviexml->e2title"); // Titel der Aufnahme
		$desc = utf8_decode("$moviexml->e2description");
      $desc =  str_replace('Š','<br>',$desc);
		$xdesc = utf8_decode("$moviexml->e2descriptionextended");
      $xdesc =  str_replace('Š','<br>',$xdesc);
		//$name = ("$moviexml->e2servicename");
		//$titel = ("$moviexml->e2title");
      //$xdesc = ("$moviexml->e2descriptionextended");
		//$desc = ("$moviexml->e2description");
		$filename = ("$moviexml->e2filename");
		$filesize = ("$moviexml->e2filesize");
		$filesize = round((int)$filesize/1048576);
		$length = ("$moviexml->e2length");
		$time = getdate("$moviexml->e2time");
		$tbeg = utf8_decode("$moviexml->e2time");
		$pos = strpos($length, ":");
			if ($pos == 2)
				{
				$min = substr($length, 0, 2);
				$sek = substr($length, 3, 2);
				$unixlength = ((int)$min*60)+(int)$sek;
				}
			elseif ($pos == 1)
				{
				$min = substr($length, 0, 1);
				$sek = substr($length, 2, 2);
				$unixlength = ((int)$min*60)+(int)$sek;
				}
			elseif ($pos == 3)
				{
				$min = substr($length, 0, 3);
				$sek = substr($length, 4, 2);
				$unixlength = ((int)$min*60)+(int)$sek;
				}
  		
		$tend = (int)$tbeg+(int)$unixlength;
		$tag = $time['mday'];
		$monat = $time['mon'];
		$jahr = $time['year'];
		$date = $time['mday'].".".$time['mon'].".".$time['year'];
    	$time = ("$time[hours]:$time[minutes]");
    	$sref = ("$moviexml->e2servicereference");
      $sref = str_replace(':','%3A', $sref);
      $sref = str_replace(' ','%20', $sref);
		$sreftimer = substr($sref, 0, 20);
    	$sreftimer = str_replace(':','%3A', $sreftimer);
		$pref = str_replace(':','_',"$moviexml->e2servicereference");

			$movie[] = array(
				"name" => $name,
				"titel" => $titel,
				"desc" => $desc,
				"filename" => $filename,
				"filesize" => $filesize,
				"length" => $length,
				"time" => $time,
				"tbeg" => $tbeg,
				"tend" => $tend,
				"tag" => $tag,
				"monat" => $monat,
				"jahr" => $jahr,
				"date" => $date,
				"xdesc" => $xdesc,
				"sref" => $sref,
				"sreftimer" => $sreftimer,
				"pref" => $pref,
				"anzahl" => $number
			);
		}
	echo $xml->asXML();
	return $movie;
}

// EPG durchsuchen mit einem Suchstring
function ENIGMA2_EPGSearch($ipadr, $search)
{
   $xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/epgsearch?search=".$search));
}

// Zeigt die verfügbaren Audiotracks an
function ENIGMA_GETAudio($ipadr)
{
$xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/getaudiotracks"));
$number = ($xmlResult->e2audiotrack->count());

	if ($number < 1)
	{
		$error = "Es wurden keine Audiotracks gefunden!";
		return array("error" => $error);
	}
$audiotracklist = $xmlResult->e2audiotrack;
    foreach ($audiotracklist as $audiotrack)
		{
		$description = utf8_decode("$audiotrack->e2audiotrackdescription");
		$trackid = utf8_decode("$audiotrack->e2audiotrackid");
		$pid = utf8_decode("$audiotrack->e2audiotrackpid");
		$active = ("$audiotrack->e2audiotrackactive");
		

			$audio[] = array(
				"Beschreibung" => $description,
				"TrackID" => $trackid,
				"PID" => $pid,
				"Status" => $active
			);
		}
 	return $audio;
}


// Wählt einen verfügbaren Audiotrack aus
function ENIGMA_SELECTAudio($ipadr, $id)
{
$xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/selectaudiotrack?id=".$id));

}

/*
* Löscht eine Aufnahme auf der Festplatte
*/
function ENIGMA2_MovieDelete($ipadr, $sref)
{
   //$Result = file_get_contents('http://'.$ipadr.'/web/moviedelete?sRef='.$sref);
   //$xmlResult = new SimpleXMLElement(fopen("http://".$ipadr."/web/moviedelete?sRef=".$sref, "r" ));
   
   //$xmlResult = new SimpleXMLElement(SYS_GetURLContent("http://'.$ipadr.'/web/moviedelete?sRef='.$sref"));
	//$xmlResult = new SimpleXMLElement(file_get_contents('http://'.$ipadr.'/web/moviedelete?sRef='.$sref));
	$xmlResult = file_get_contents("http://$ipadr/web/moviedelete?sRef=$sref");
	if($xmlResult == false)
	{
	echo "Es wird false ausgegeben";
	}
   return $xmlResult;
}


/*
* Kanal Liste EPG Now
*/
function Enigma2_getChannelList ($ipadr, $bouquet, $command)
{

	$xml = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/epgnow?bRef=$bouquet"));
	$number = ($xml->e2event->count());

	if ($number < 1)
	{
		$error = "Diesem Bouquet sind keine Sender zugeordnet.";
		return array("error" => $error);
	}

	$service = array();
	$addcommand = $xml->e2event[0]->addChild('command', $command);
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


// Prüft ob Box an oder aus ist
function ENIGMA2_Power ($ipadr)
{
	$xml = simplexml_load_file('http://'.$ipadr.'/web/powerstate?.xml');
	$wert = $xml->e2instandby;
// Wenn Box an und nicht in Standby false 
	if ($wert == "false")
	{
		//echo "Die Box ist eingeschaltet";
		SetValueBoolean(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/, true); /* Status an */
		$status = "on";
		
	}
	else
	{
		//echo "Die Box ist im Standby";
		SetValueBoolean(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/, false); /* Status aus */
		$status = "off";
	}
	return $status;
}


?>