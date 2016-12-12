<?
include(IPS_GetScriptFile(31715)); //KonstantenArray Skript
//require IPS_GetKernelDir()."scripts\\KonstantenArrayE2.ips.php"; // KonstantenArray Skript

$dm8000ip = $k_DREAMBOXIP; // IP Adresse der Dreambox
$ipadr = $k_DREAMBOX; // IP Adresse mit Webport 192.168.X.X:XXXX

/*
* Holt IPAdresse aus Variable 'IP' eines DummyModules obj
*/
function GetIpFromObj($obj)
{

    $ip_obj = @IPS_GetObjectIDByName("IP", $obj); // Hole das Object aus Variable IP
    $ip_adr = @GetValue($ip_obj);

return $ip_adr;
}

/**
*  Prüft über Ping ob Gerät erreichbar
*  Return
*  true  -  wenn erreichbar
*  false -  nicht erreichbar
**/

function ENIGMA2_GetAvailable($ipadr)
{
   $result = false;
   global $dm8000ip;
   if ($dm8000ip > "" )
    {
       $result = (Boolean) Sys_Ping($dm8000ip, 1000);   // Ping max. 1 Sek. warten
   }
return $result;
}

// Prüft ob Box an oder aus ist
function ENIGMA2_Power ($ipadr)
{
$xml = simplexml_load_file('http://'.$ipadr.'/web/powerstate?.xml');
$wert = $xml->e2instandby;

if(strpos($wert,"false")!==false)
{
echo "Die Box ist eingeschaltet";
SetValueBoolean(53181, true); /* Status an */
}
else
{
echo "Die Box ist im Standby";
SetValueBoolean(53181, false); /* Status aus */
}
}


/**
* Setzt Dreambox in Standby/nicht StandBy
*  -1    -  bei Fehler
*  1  -  wenn in StandBy
*  0 -  wenn nicht in Standby
**/
function ENIGMA2_ToggleStandby($ipadr)
{
    $powerstate = 0;
    $result = -1;

   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/powerstate?newstate=$powerstate"));
        print_r ($xmlResult);
        if ($xmlResult->e2instandby == 'true')
        {
           $result = 1;
           SetValueBoolean(53181, false);
        }
        else
        {
            $result = 0;
            SetValueBoolean(53181, true);
        }
   }

return $result;
}
/**
* true - wenn ok
*/
function ENIGMA2_DeepStandby($ipadr)
{
    $powerstate = 1;
    $result = false;

   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/powerstate?newstate=$powerstate"));
       print_r($xmlResult);
        $result = (Boolean)$xmlResult->e2instandby;
        SetValueBoolean(53181, false);
   }

return $result;
}
/**
* true - wenn ok
*/
function ENIGMA2_Reboot($ipadr)
{
    $powerstate = 2;
    $result = false;

   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/powerstate?newstate=$powerstate"));
       $result = (Boolean)$xmlResult->e2instandby;
       SetValueBoolean(53181, true);
   }

return $result;
}
/**
* true - wenn ok
*/
function ENIGMA2_RestartEnigma($ipadr)
{
    $powerstate = 3;
    $result = false;

   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/powerstate?newstate=$powerstate"));
       $result = (Boolean)$xmlResult->e2instandby;
       SetValueBoolean(53181, true);
   }

return $result;
}
/**
* liefert den Namen des aktuellen Sendernamens
*/
function ENIGMA2_GetCurrentServiceName($ipadr)
{
  if (ENIGMA2_GetAvailable($ipadr))
   {
        $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/subservices"));
        $result = utf8_decode($xmlResult->e2service->e2servicename);
        return $result;
   }
   else
   {
	return 'Box nicht erreichbar!';
	}
}
/**
* liefert die Servicereferenz, Picture Referenz und den Sendernamen des aktuellen Senders
*/
function ENIGMA2_GetCurrentServiceReference($ipadr)
{


   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/subservices"));
		 $sref = utf8_decode($xmlResult->e2service[0]->e2servicereference);
       $name = utf8_decode($xmlResult->e2service->e2servicename);
		 $pref = str_replace(':','_',$sref);
		 $pref = substr($pref, 0, -1);
   }

return array($sref, $pref, $name);
}


/**
* liefert ein Array mit den Namen der Bouquets wenn $bouquet = ""
* liefert ein Array mit den Namen der Sender eines Bouquet  wenn $bouquet ungleich ""
* keys e2servicereference
* keys e2servicename
*/
function ENIGMA2_GetServiceBouquetsOrServices($ipadr,$bouquet = "")
{
   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       if ($bouquet == "" )
       {
           $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getservices"));
       }
       else {
          $bouquet = urlencode($bouquet);
           $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getservices?sRef=$bouquet"));
       }
   }
   else
    {
      $xmlResult[] = "";
    }
return $xmlResult;
}

//*************************************************************************************************************
// Ermittelt die EPG-Daten eines definierten Senders
function ENIGMA2_EPG($ipadr, $sref)
{
   $xmlResult[] = "";
   $sender = urlencode($sref);
   $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/epgservice?sRef=$sref"));
return $xmlResult;
}

/*
* Bouquet Liste
*/
function Enigma2_getBouquetList($ipadr, $bouquet)
{


	$xml = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getservices?sRef=$bouquet"));
	$number = ($xml->e2service->count());
	if ($number < 1)
	{
		$error = "Bitte führen Sie die Bouquet Auswahl aus.";
		return array("error" => $error);
	}

	$primary = array();

  $bouquetlist = $xml->e2service;
  foreach ($bouquetlist as $bouquet)
  {
      $name = utf8_decode($bouquet->e2servicename);
		$sref = utf8_decode($bouquet->e2servicereference);
      $pref = str_replace(':','_',$sref);
		$pref = substr($pref, 0, -1);

		$primary[] = array(
			"name" => $name,
			"sref" => $sref,
			"pref" => $pref
		);
  }


	return $primary;
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
	return $service;
}



/*
* Schreibt eine Infomessage auf den Bildschirm
* return
* true wenn erfolgreich
* false wenn nicht erfolgreich
**/
function ENIGMA2_WriteInfoMessage($ipadr,$message = "",$time=5)
{
    $type = 1;
    $result = false;
   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $message = urlencode($message);
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/message?text=$message&type=$type&timeout=$time"));
      if ($xmlResult->e2state == "True")
      {
         $result = true;
        }
    }
   else
    {
       $result = false;
    }
return $result;
}
/*
* Schreibt eine Errormessage auf den Bildschirm
* return
* true wenn erfolgreich
* false wenn nicht erfolgreich
**/
function ENIGMA2_WriteErrorMessage($ipadr,$message = "",$time=5)
{
    $type = 3;
    $result = false;
   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $message = urlencode($message);
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/message?text=$message&type=$type&timeout=$time"));
      if ($xmlResult->e2state == "True")
      {
         $result = true;
        }
    }
   else
    {
       $result = false;
    }
return $result;
}
/*
* Schreibt eine Message auf den Bildschirm
* return
* true wenn erfolgreich
* false wenn nicht erfolgreich
**/
function ENIGMA2_WriteMessage($ipadr,$message = "",$time=5)
{
    $type = 2;
    $result = false;
   if (ENIGMA2_GetAvailable( $ipadr ))
    {
       $message = urlencode($message);
       $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/message?text=$message&type=$type&timeout=$time"));
      if ($xmlResult->e2state == "True")
      {
         $result = true;
        }
    }
   else
    {
       $result = false;
    }
return $result;
}

/******************************************************************************************************************************
* Schreibt eine Message auf den Bildschirm die man mit ja oder nein beantworten kann
* 0 = Initialisierung
* 1 = Dreambox Ausgeschaltet
* 2 = Nachricht nicht gesendet
* 3 = Wenn mit Ja geantwortet wurde
* 4 = Wenn mit Nein geantwortet wurde
* 5 = Wenn Zeit abgelaufen ohne antworten
*/
function ENIGMA2_GetAnswerFromMessage($ipadr,$message,$time)
{
    $result = 0;
    $timeout = 25;
    if ($time > $timeout)
       $time = $timeout;
    if (ENIGMA2_GetAvailable($ipadr))
    {
       $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/messageanswer?getanswer=now"));
       if ($time == 0)
        {
           $time = $timeout;
          $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/message?text=$message&type=0"));
       }
       else
          $xmlResult = new SimpleXMLElement(file_get_contents('http://'.$ipadr.'/web/message?text='.$message.'&type=0&timeout='.$time));
        if ($xmlResult->e2state == "True")
       {
          $start = time();
           do
            {
                $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/messageanswer?getanswer=now"));
                $diff = time() - $start;
                if ($xmlResult->e2state == "True")
                {
                 if ($xmlResult->e2statetext == "Answer is YES!")
                 {
                    if (($diff + 1) >= $time)
                       $result = 5;
                    else
                        $result = 3;
                  }
                  elseif ($xmlResult->e2statetext == "Answer is NO!")
                     $result = 4;
                }
                sleep(0.5);
            }
            while (($result == 0) and ($diff <= $time));
            if ($result == 0)
               $result = 5;
       }
       else
             $result = 2;
    }
    else
        $result = 1;
    return $result;
}

/**
liest Aktuelle Sendung und Laufzeit aus
**/
function ENIGMA2_GetCurrentFilm($ipadr)
{
	 if (ENIGMA2_GetAvailable($ipadr))
   {
        $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/subservices"));
        $sref = utf8_decode($xmlResult->e2service[0]->e2servicereference);
		  $pref = str_replace(':','_',$sref);
		  $pref = substr($pref, 0, -1);
		  $name = utf8_decode($xmlResult->e2service->e2servicename);
        $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/epgservice?sRef=$sref"));
        $title = utf8_decode($xmlResult->e2event->e2eventtitle);
        $description = utf8_decode($xmlResult->e2event->e2eventdescriptionextended);
        $description =  str_replace('Š','<br>',$description);
        $startsec = $xmlResult->e2event->e2eventstart;
        $duration = $xmlResult->e2event->e2eventduration;
        $currenttime = $xmlResult->e2event->e2eventcurrenttime;
		  if ((int)$startsec >= time() - 36000)
            $start = date("H:i",(int)$startsec) .' Uhr';
        else
           $start = "N/A";
        if (((int)$duration > 0) and ((int)$startsec >= time() - 36000))
            $ende = date("H:i",(int)$startsec + (int)$duration) .' Uhr';
        else
           $ende = "N/A";
        if (((int)$duration > 0) and ((int)$startsec >= time() - 36000))
            $endeint = date("H:i",(int)$startsec + (int)$duration) .' Uhr';
        else
           $endeint = "N/A";
         if (round((int)$duration / 60) > 0)
               {
                $fortschritt = (int)(round(((int)$currenttime - (int)$startsec) / 60 ) / round((int)$duration / 60) * 100) ;
                }
            else
               {
               $fortschritt = 0;
               }
        if ((int)$duration > 0)
            $dauer = round((int)$duration / 60).' Minuten';
        else
           $dauer = "N/A";
        if (((int)$currenttime > time() - 1800) and ((int)$currenttime < time() + 1800) and ((int)$startsec >= time() - 36000))
            $vorbei = round(((int)$currenttime - (int)$startsec) / 60 ).' Minuten';
        else
           $vorbei = "N/A";
        if (((int)$currenttime > time() - 1800) and ((int)$currenttime < time() + 1800) and ((int)$startsec >= time() - 36000) and ((int)$duration > 0))
            $verbl = round(((int)$startsec + (int)$duration - (int)$currenttime) / 60 ).' Minuten';
        else
           $verbl = "N/A";
         $description =  str_replace('Š','<br>',$description);
		  return array($name, $title, $start, $ende, $dauer, $vorbei, $verbl, $description , $fortschritt, $endeint, $sref, $pref);
		  // return "Kanal      :$name\nTitel      :$title\nStart      :$start\nEnde       :$ende\nDauer      :$dauer\nVergangen  :$vorbei\nVerbleiben :$verbl\nDetails    :$description";
    }
    else
       return 'Box nicht erreichbar!';
}


/**
Holt EPG und an ein WFC popup schicken
**/

function GetDreamEpg($ipadr, $channel) {
    $epgentry = "";
    $chanlist = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getservices?sRef=1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet"));
    $bouquetlist = $chanlist->e2service;
    $zapname = IPS_GetObject($channel);
    $zapname2 = $zapname['ObjectName'];
    foreach ($bouquetlist as $entry) {
    $sendername = utf8_decode($entry->e2servicename);
  $sref = ("$entry->e2servicereference \n");
  $pos1 = strpos($sref,'"');
  $pos2 = strpos($sref,'"',$pos1+1);
  $sref = substr($sref,$pos1,$pos2-$pos1-1);
  if($sendername == $zapname2) {
     $ergebnis = $sref;
         $epgservice = new SimpleXMLElement(file_get_contents("http://$ipadr/web/epgservice?sRef=".$ergebnis.""));
   $epglist = $epgservice->e2event;
   foreach ($epglist as $entry2) {
      $heute = time();
      $heute = date("dmy", $heute);
      $eventstartraw = trim($entry2->e2eventstart);
      $eventdate = date("dmy", $eventstartraw);
      //if ($eventdate  == $heute) {
         $newtitel = utf8_decode($entry2->e2eventtitle);
         $newsref = $entry2->e2eventservicereference;
         $newtime = date("H:i",$eventstartraw);
         $newdesc = utf8_decode($entry2->e2eventdescriptionextended);
         $neweventid = trim($entry2->e2eventid);
         $newlenght = $entry2->e2eventduration /60;
         $epgentry .= "<div class=\"standardContainer\">" ."Zeit: " .$newtime ."</div>";
         $epgentry .= "<div class=\"standardContainer\">" ."Länge: " .$newlenght ." Minuten"."</div>";
       $epgentry .= "<div class=\"standardContainer\">" ."Titel: " .$newtitel ."</div>";
       $epgentry .= "<div class=\"standardContainer\">" ."Inhalt: " .$newdesc ."</div>";
       $epgentry .= '<td style="line-height: 25px;">'.'</td><td align="right"><div onclick="dojo.xhrGet({ url: \'http://192.168.0.5/web/timeraddbyeventid?sRef='.$newsref .'&eventid=' .$neweventid .'\'});" style="border:1px solid #3B3B4D; margin:0px; padding:3px; text-align:center; width: 100px;">Aufnehmen</div></td>';
       $epgentry .= "<br>";
      //}
   }
    }
    }
    return $epgentry;
}

/**
Timer
**/

// prüft ob ein Timer aktiv ist und liefert true wenn aktiv, sonst false
function ENIGMA2_IsTimerActive($ipadr)
{
   if (ENIGMA2_GetAvailable($ipadr))
    {
        $site = file_get_contents("http://$ipadr/web/timerlist");

        $xmlResult = new SimpleXMLElement($site);
        // e2state = 0 -> geplanter Timer
        // e2state = 2 -> Timer läuft
        // e2state = 3 -> Timer beendet

        // Lese alle Timerevents aus
        foreach ($xmlResult as $child)
        {
                if($child->e2state == "2")          // Aufnahme läuft
                   return true;
                else
                   return false;
        }
    }
    else
       return false;
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
    	$string = file_get_contents("http://".$ipadr."/web/timerdelete?sRef=".$sref."&begin=".$tbeg."&end=".$tend."");
    	$result = new SimpleXMLElement($string);
      $result = $result->e2statetext;

    //WFC_SendNotification(43692, 'Dreambox - Timer gelöscht', "$result \n", 'Speaker', 4);
   }
	return $result;

}

/**
----------------------------------
URL String für Aufnahme:
----------------------------------

http://dm800/web/timerchange?sRef=1%3A0%3A19%3A283D%3A3FB%3A1%3AC00000%3A0%3A0%3A0%3A&begin=1438731100&end=1438731400&name=Tagesschau&eventID=0&description=&dirname=%2Fhdd%2Fmovie%2F&tags=&afterevent=3&eit=0&disabled=0&justplay=0&repeated=0&deleteOldOnSave=0



uebergebene Variablen:

sRef=1%3A0%3A19%3A283D%3A3FB%3A1%3AC00000%3A0%3A0%3A0%3A -> Sender -> 1:0:19:283D:3FB:1:C00000:0:0:0: -> Das Erste HD
&begin=1438731100 -> Beginn wäre -> 5.8.2015 1:31
&end=1438731400 -> Ende wäre -> 5.8.2015 1:36 (1438731400 - 1438731100 =300 Sekunden = 5 Minuten)
&name=Tagesschau
&eventID=0
&description=
&dirname=%2Fhdd%2Fmovie%2F -> Location -> /hdd/movie/
&tags=
&afterevent=3 -> 0=nothing;3=Auto
&eit=0
&disabled=0
&justplay=0 -> Action RECORDING=0 oder ZAP=1
&repeated=0 -> 1=Mo (0x0000001);31=Mo-Fr (0x0011111);64=So (0x1000000);127=Mo-So (0x1111111)


---------------------------------------
URL String um Timer wieder zu löschen:
---------------------------------------

h ttp://dm800/web/timerdelete?sRef=1%3A0%3A19%3A283D%3A3FB%3A1%3AC00000%3A0%3A0%3A0%3A&begin=1438731100&end=1438731400

**/
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
function ENIGMA2_GetBoxInfo($ipadr)
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
* Sendet einen RemoteControl code. Infos unter
* "http://dream.reichholf.net/wiki/Enigma2:WebInterface#RemoteControl"
116 Key "Power"
2   Key "1"
3   Key "2"
4   Key "3"
5   Key "4"
6   Key "5"
7   Key "6"
8   Key "7"
9   Key "8"
10  Key "1"
11  Key "0"
412 Key "previous"
407 Key "next
115 Key "volume up"
113 Key "mute"
402 Key "bouquet up"
114 Key "volume down"
174 Key "lame"
403 Key "bouquet down"
358 Key "info"
103 Key "up"
139 Key "menu"
105 Key "left"
352 Key "OK"
106 Key "right"
392 Key "audio"
108 Key "down"
393 Key "video"
398 Key "red"
399 Key "green"
400 Key "yellow"
401 Key "blue"
377 Key "tv"
385 Key "radio"
388 Key "text"
138 Key "help"
*/
function ENIGMA2_RemoteControl($ipadr,$command)
{
   global $dm8000ip;
	if (ENIGMA2_GetAvailable($dm8000ip))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/remotecontrol?command=$command"));
      if ($xmlResult->e2result == "True")
         $result = ($xmlResult->e2resulttext);
        else
           $result = "error";
   }
   else
      $result = "not available";
    return $result;
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
   global $dm8000ip;
	if (ENIGMA2_GetAvailable($dm8000ip))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/cgi-bin/videocontrol?command=$command"));
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

    //WFC_SendNotification(43692, 'Dreambox - Zap to', "$name \n", 'Speaker', 4);
    //SetValueString ($config['current'], "$name \n"); // Aktueller Sendername
    //SetValueString ($config['event'], "$eventtitel");
    $e2statetext = utf8_decode($result->e2statetext);
    IPS_RunScript(37875);
    IPS_LogMessage( "Umschalten:" , $e2statetext );
    }
	else
	{
	$e2statetext = "cannot zap while device is in standby";
	}
	return $e2statetext;
}



/**
Aktuelles Programm, Aktueller Status
**/
function ENIGMA2_Getcurrent($ipadr)
{
   if (ENIGMA2_GetAvailable($ipadr))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getcurrent"));
      if ($xmlResult->e2result == "True")
         $result = ($xmlResult->e2resulttext);
        else
           $result = "error";
   }
   else
      $result = "not available";
    return $result;
}



//Aktuelle Programminfo vom laufenden Sender
function ENIGMA2_GetcurrentChannel($ipadr)
{
   if (ENIGMA2_GetAvailable($ipadr))
   {
      $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/getcurrent"));
      if ($xmlResult->e2volume->e2result == "True")
         {
	      $result = array();
  			$channellist = $xmlResult->e2eventlist->e2event;
         foreach ($channellist as $channelxml)
				{
				$name = utf8_decode($channelxml->e2eventservicename);
				$id = utf8_decode($channelxml->e2eventid);
				$provider = utf8_decode($channelxml->e2eventprovidername);
				$sendername = utf8_decode($channelxml->e2eventservicename);
            $title = utf8_decode($channelxml->e2eventtitle);
		      $desc = utf8_decode($channelxml->e2eventdescription);
		      $desc =  str_replace('Š','<br>',$desc);
				$descext = utf8_decode($channelxml->e2eventdescriptionextended);
		      $descext =  str_replace('Š','<br>',$descext);
				$sref = utf8_decode($channelxml->e2eventservicereference);
		      $pref = str_replace(':','_',$sref);
				$pref = substr($pref, 0, -1);
				$startsec = utf8_decode($channelxml->e2eventstart);
				$duration = utf8_decode($channelxml->e2eventduration);
				$remaining = utf8_decode($channelxml->e2eventremaining);
				$currenttime = utf8_decode($channelxml->e2eventcurrenttime);
				$start = date("H:i",(int)$startsec) .' Uhr';
				if (((int)$duration > 0) and ((int)$startsec >= time() - 36000))
		            $ende = date("H:i",(int)$startsec + (int)$duration) .' Uhr';
		      else
		           $ende = "N/A";
				$vorbei = round(((int)$currenttime - (int)$startsec) / 60 ).' Minuten';
				if ($vorbei <0)
					{
					$vorbei=0;
					}
				$verbleibend = round(((int)$startsec + (int)$duration - (int)$currenttime) / 60 ).' Minuten';
				$fortschritt = (int)(round(((int)$currenttime - (int)$startsec) / 60 ) / round((int)$duration / 60) * 100) ;
		      if ($fortschritt < 0)
		               {
		                $fortschritt = 0;
		                }
		        if ((int)$duration > 0)
		            $dauer = round((int)$duration / 60).' Minuten';
		        else
		           $dauer = "N/A";

					$result[] = array(
						"name" => $name,
						"id" => $id,
						"provider" => $provider,
						"sendername" => $sendername,
						"title" => $title,
						"descext" => $descext,
						"desc" => $desc,
						"start" => $start,
						"ende" => $ende,
						"dauer" => $dauer,
						"vorbei" => $vorbei,
						"verbleibend" => $verbleibend,
						"fortschritt" => $fortschritt,
						"sref" => $sref,
						"pref" => $pref
						);
				}
   		return $result;
			}
		  else
			{
			  $result = "error";
			  return $result;
			}
	}
   else
		{
		$result = "not available";
    	return $result;
		}
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
* Movie List, zeigt Liste alle Aufnahmen
*/
function ENIGMA2_getMovieList($ipadr)
{

   $string = file_get_contents("http://".$ipadr."/web/movielist?dirname=/hdd/movie/&tag=");
	$xml = new SimpleXMLElement($string);
	$number = ($xml->e2movie->count());

	if ($number < 1)
	{
		$error = "Es wurden keine Aufnahmen gefunden!";
		return array("error" => $error);
	}

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
      $sref = utf8_decode(str_replace(':','%3A', $sref));
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
	return $movie;
}

//Funktion noch testen und prüfen ob schon vorhanden
/*

http://dreambox/web/epgnow?bRef={bouqetRev}
http://dreambox/web/epgnow?bRef=1:0:1:335:9dd0:7e:820000:0:0:0:
stream
http://dreambox/web/stream.m3u?ref={servicereference}
*/
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

// HTML Ausgabe in Tabelle Head
function ENIGMA_GetTableHeader ()
{
	// Kopf der Tabelle erzeugen
	$html  = '<table border="0" cellpadding="0" cellspacing="0" class="tableLine">'.PHP_EOL;
	$html .= '<tbody style="">'.PHP_EOL;
	return $html;
}

//HTML Ausgabe in Tabelle Footer
function ENIGMA_GetTableFooter()
{
	$html = '</tbody>'.PHP_EOL;
	$html .= '</table>'.PHP_EOL;
	return $html;
}

// Wertet die Anzahl der Listeneinträge die $listings entsprechen für die nächsten Sendungsinfos aus
// Zeigt Startzeit - Endzeit und Titel der Sendung an
// erhält die $programmliste = ENIGMA2_EPG($ipadr, $reference);
function ENIGMA_GetListfromProgram($programmliste, $listings)
{
   $HTMLData = "";
	for ($i = 0; $i <= $listings-1; $i++)
			{
			$sendungsinfo = utf8_decode($programmliste->e2event[$i]->e2eventtitle); // Sendungsname
			$startsec = $programmliste->e2event[$i]->e2eventstart;
			$startzeit = date("H:i",(int)$startsec) .' Uhr'; // Startzeit
			$duration = $programmliste->e2event[$i]->e2eventduration;
			$endzeit = date("H:i",(int)$startsec + (int)$duration) .' Uhr'; // Endzeit
			$HTMLData .= '<tr><td>'.$startzeit.' - '.$endzeit.': </td><td>'.$sendungsinfo.'</td></tr>'.PHP_EOL; // Uhrzeit Titel
         }
return $HTMLData;
}


// Wertet die Anzahl der Listeneinträge die $listings entsprechen für die nächsten Sendungsinfos aus
// Zeigt Startzeit - Endzeit und Titel der Sendung an
// mit Beschreibung der Sendung
// erhält die $programmliste = ENIGMA2_EPG($ipadr, $reference);
function ENIGMA_GetListfromProgramFull($programmliste, $listings)
{
   $HTMLData = "";
	for ($i = 0; $i <= $listings-1; $i++)
			{
			$sendungsinfo = utf8_decode($programmliste->e2event[$i]->e2eventtitle); // Sendungsname
			$startsec = $programmliste->e2event[$i]->e2eventstart;
			$startzeit = date("H:i",(int)$startsec); // Startzeit
			$duration = $programmliste->e2event[$i]->e2eventduration;
			$endzeit = date("H:i",(int)$startsec + (int)$duration); // Endzeit
			$id = $programmliste->e2event[$i]->e2eventid;
			$desc = utf8_decode($programmliste->e2event[$i]->e2eventdescription);
         $desc =  str_replace('Š','<br>',$desc);
			$descext = utf8_decode($programmliste->e2event[$i]->e2eventdescriptionextended);
         $descext =  str_replace('Š','<br>',$descext);
         $HTMLData .= '<tr><td>'.$sendungsinfo.'</td><td></td></tr>'.PHP_EOL; // Titel
         $HTMLData .= '<tr><td>'.$desc.'</td><td></td></tr>'.PHP_EOL; // Kurzbeschreibung
			$HTMLData .= '<tr><td>'.$startzeit.' - '.$endzeit.' Uhr</td><td></td></tr>'.PHP_EOL; // Uhrzeit
			$HTMLData .= '<tr><td colspawn="2">'.$descext.'</td></tr>'.PHP_EOL; // Lange Beschreibung
			$HTMLData .= '<tr><td></td><td></td></tr>'.PHP_EOL; // Leerzeile
         }
return $HTMLData;
}

// Erzeugt einen Array mit Sendername, sref und perf vom Bouquet
// die Liste kommt von $liste = ENIGMA2_GetServiceBouquetsOrServices($ipadr,$bouquet); // Liste aller Sender des Bouquets mit sref und Namen
// muss noch ergänzt werden erzeugen Ausgabe mit Selektionsmöglichkeit der Sender
function ENIGMA_Channel($liste)
	{
	$z = 0;
	$list = array();
	foreach ($liste as $channel)
		{
		$list[$z][0] = $channel->e2servicename; // Sendername
    	$list[$z][1] = $channel->e2servicereference; // Senderreferenznummer
      $list[$z][2] = substr(str_replace(':','_',$list[$z][1]), 0, -1); // pref

    	//$HTMLData .= '<tr><td colspan="2"><a href="http://'.$ipadr.'/web/zap?sRef='.$list[$z][1].'">'.$list[$z][0].'</td></tr>'.PHP_EOL; // Name des Senders
      $z = $z+1;
		}
	return $list;
	}


// Fragt Multi EPG Daten ab
// time und endtime müssen übergeben werden (Beispiel $time=1438190560 $endTime=180
// http://192.168.55.37/web/epgmulti?bRef=1%3A7%3A1%3A0%3A0%3A0%3A0%3A0%3A0%3A0%3AFROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet&time=1438190560&endTime=180
function ENIGMA_MultiEPG($ipadr, $time, $endtime)
{
$bRef = "1%3A7%3A1%3A0%3A0%3A0%3A0%3A0%3A0%3A0%3AFROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
$xmlResult = new SimpleXMLElement(file_get_contents("http://".$ipadr."/web/epgmulti?bRef=".$bRef."&time=".$time."&endTime=".$endtime));
$number = ($xmlResult->e2event->count());
$multiepglist = $xmlResult->e2event;
    foreach ($multiepglist as $event)
		{
      $sendername = utf8_decode("$event->e2eventservicename");
		$description = utf8_decode("$event->e2eventdesription");
		$description =  str_replace('Š','<br>',$description);
		$duration = ("$event->e2eventduration");
		$startunix = utf8_decode("$event->e2eventstart");
		$start = date("H:i",(int)$startunix).' Uhr'; // Endzeit
		$endunix = (int)$startunix + (int)$duration;
      $end = date("H:i", $endunix) .' Uhr'; // Endzeit
		$sref = utf8_decode("$event->e2eventservicereference");
      $pref = str_replace(':','_',$sref);
		$pref = substr($pref, 0, -1);
      $id = utf8_decode("$event->e2eventid");
      $currenttime = utf8_decode("$event->e2eventcurrenttime");
      $title = utf8_decode("$event->e2eventtitle");
      $descext = utf8_decode("$event->e2eventdescriptionextended");
		$descext =  str_replace('Š','<br>',$descext);

			$multiepg[] = array(
				"sendername" => $sendername,
				"description" => $description,
				"start" => $start,
				"end" => $end,
				"startunix" => $startunix,
				"endunix" => $endunix,
				"sref" => $sref,
				"pref" => $pref,
				"id" => $id,
				"currenttime" => $currenttime,
				"title" => $title,
				"descext" => $descext,
				"duration" => $duration
				);
		}

		return $multiepg;
}

/*
* Löscht eine Aufnahme auf der Festplatte
*/
function ENIGMA2_MovieDelete($ipadr, $sref)
{
   //$Result = file_get_contents('http://'.$ipadr.'/web/moviedelete?sRef='.$sref);
   //$xmlResult = new SimpleXMLElement(fopen("http://".$ipadr."/web/moviedelete?sRef=".$sref, "r" ));
   
   $xmlResult = new SimpleXMLElement(SYS_GetURLContent("http://'.$ipadr.'/web/moviedelete?sRef='.$sref"));
	//$xmlResult = new SimpleXMLElement(file_get_contents('http://'.$ipadr.'/web/moviedelete?sRef='.$sref));
   return $xmlResult;
}



// EPG
/**
/web/epgbouquet?bRef=&time=
/web/epgmulti?bRef=&time=&endTime=
/web/epgnext?bRef=
/web/epgnow?bRef=
/web/epgnownext?bRef=
/web/epgsearch.rss?search=
/web/epgsearch?search=
/web/epgservice?sRef=&time=&endTime=
/web/epgservicenext?sRef=
/web/epgservicenow?sRef=
/web/epgsimilar?sRef=&eventid=

/web/movielist.html?dirname=&tag=
/web/movielist.m3u?dirname=&tag=
/web/movielist.rss?dirname=&tag=
/web/movielist?dirname=&tag=
/web/recordnow?recordnow=

//Live Update
http://ip/web/updates.html?AGC=



**/
?>
