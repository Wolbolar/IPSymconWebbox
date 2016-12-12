<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>

<title>Mediola IP-Symcon Einbindung</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />



<link href="mediola.css" rel="stylesheet" type="text/css" /></head>

<body class="EPGSender">
<?php

$dm8000ip = "192.168.55.37"; // IP Adresse der Dreambox eintragen
$webport = "80"; //Port vom Webinterface der Dreambox eintragen, Standard 80
// ===========================================================================
$ipadr = $dm8000ip.":".$webport;
$dreamboxIP = $ipadr;

function ENIGMA2_GetAvailable($ipadr)
{

	$status = True;
   return $status;
}

function ENIGMA2_GetCurrentFilm($ipadr)
{
    if (ENIGMA2_GetAvailable($ipadr))
   {
        $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/subservices"));
        $reference = $xmlResult->e2service->e2servicereference;
        $name = $xmlResult->e2service->e2servicename;
        //$name = utf8_decode($xmlResult->e2service->e2servicename);
        // bei Mediawiedergabe 1:0:0:0:0:0:0:0:0:0:/media/hdd/movie/   Ausnahme einfügen
        $media = "/media/hdd/movie/"; //Aufnahmeverzeichnis Media der Dreambox
        $playback = strpos($reference, $media);
        if ($playback === false)
        {
        $xmlResult =  new SimpleXMLElement(file_get_contents("http://$ipadr/web/epgservice?sRef=$reference"));
        $title = $xmlResult->e2event->e2eventtitle;
        // $title = utf8_decode($xmlResult->e2event->e2eventtitle);
        $description = $xmlResult->e2event->e2eventdescriptionextended;
        // $description = utf8_decode($xmlResult->e2event->e2eventdescriptionextended);
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
        return array($name, $title, $start, $ende, $dauer, $vorbei, $verbl, $description);
		  	// return "Kanal      :$name\nTitel      :$title\nStart      :$start\nEnde       :$ende\nDauer      :$dauer\nVergangen  :$vorbei\nVerbleiben :$verbl\nDetails    :$description";
    		}
    		elseif ($playback == "20")
    		{
    		return '1';	
    		}
    		else
    		{
       	return '2';
       	}
   }
        
}



$result = ENIGMA2_GetCurrentFilm($ipadr);
if ($result == "1")
{
echo '<p>Box spielt Film ab!</p>';
}
elseif ($result  == "2")
{
echo '<p>Box nicht erreichbar</p>';	
}
else
{
echo '<p>Sendername: '.$result[0].'</p>';
echo '<p>Sendung: '.$result[1].'</p>';
echo '<p>Startzeit: '.$result[2].'</p>';
echo '<p>Endzeit: '.$result[3].'</p>';
echo '<p>Dauer: '.$result[4].'</p>';
echo '<p>Vergangene Zeit: '.$result[5].'</p>';
echo '<p>Verbleibende Zeit: '.$result[6].'</p>';
echo '<p>Beschreibung: '.$result[7].'</p>';
}
	
?>
</body>

</html>