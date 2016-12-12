<?php
include IPS_GetKernelDir().'scripts/f_Enigma_2.ips.php';
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
$aktuellerSender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
$status = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
$sref = utf8_encode($rpc->GetValue(24168 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\aktuelle Servicereferenz]*/));
$pref = utf8_encode($rpc->GetValue(19948 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Picture Reference]*/));


$dreamip = "192.168.55.37";
$dbname = "Dreambox 8000";
$status = 1;
$current = 59613;
$event = 30361;

$config = array(
	"dreamip" => $dreamip,
	"dbname" => $dbname,
	"status" => $status,
	"current" => $current,
	"event" => $event
);

// ##################################################################

	$result = array();
	
	switch ($_GET['do'])
	{
		case "zapService":
			$sref = $_GET['sref'];
//      $name = $_GET['name'];
			$result = array("result" => zapService($sref));
		break;
		
		case "getBouquetList":
			$result = array("primary" => getBouquetList($bref));
		break;
		
		case "getChannelList":
			$sref = $_GET['sref'];
			$result = array("service" => getChannelList($sref));
		break;
		
		case "getEPGList":
			$result = array("epg" => getEPGList($sref));
		break;

		case "getTimerList":
			$result = array("timer" => getTimerList());
		break;

		case "getMovieList":
			$result = array("movie" => getMovieList());
		break;

		case "delTimer":
			$sref = $_GET['sref'];
			$tbeg = $_GET['tbeg'];
			$tend = $_GET['tend'];
			$result = array("deltimer" => deleteTimer($sref, $tbeg, $tend));
		break;
		
	}
	
	echo "{}&& ".json_encode($result);


function getBouquetList($bref)
{

	global $config;
	
	$string = file_get_contents("http://".$config['dreamip']."/web/getservices?sRef=1%3A7%3A1%3A0%3A0%3A0%3A0%3A0%3A0%3A0%3AFROM%20BOUQUET%20%22bouquets.".$bref."%22%20ORDER%20BY%20bouquet");
	$xml = new SimpleXMLElement($string);
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
		$name = ("$bouquet->e2servicename \n");
		$sref = ("$bouquet->e2servicereference \n");
		$pos1 = strpos($sref,'"');
		$pos2 = strpos($sref,'"',$pos1+1);
		$sref = substr($sref,$pos1+1,$pos2-$pos1-1); 

		$primary[] = array(
			"name" => $name,
			"sref" => $sref
		);
  }

	
	return $primary;
}


function getChannelList ($sref)
{

	global $config;
	if ($sref <> "")
	{
		$string = file_get_contents("http://".$config['dreamip']."/web/epgnow?bRef=1%3A7%3A1%3A0%3A0%3A0%3A0%3A0%3A0%3A0%3AFROM%20BOUQUET%20%22".$sref."%22%20ORDER%20BY%20bouquet");
	}
	else
	{
		$string = "TEST ERROR";	
	}
	
	$xml = new SimpleXMLElement($string);
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
		$name = ("$channelxml->e2eventservicename");
		$titel = ("$channelxml->e2eventtitle");
		$desc = ("$channelxml->e2eventdescription");
		$sref = (string)str_replace(':','%3A',"$channelxml->e2eventservicereference");
		$pref = str_replace(':','_',"$channelxml->e2eventservicereference");

			$service[] = array(
				"name" => $name,
				"titel" => $titel,
				"desc" => $desc,
				"sref" => $sref,
				"pref" => $pref
			);
		}
	return $service;
}


function getEPGList ($sref)
{

	global $config;
	if ($sref <> "")
	{
		$string = file_get_contents("http://".$config['dreamip']."/web/epgservice?sRef=".$sref."");
	}
	else
	{
		$string = "TEST ERROR";	
	}
	
	$xml = new SimpleXMLElement($string);
	$number = ($xml->e2event->count());

	if ($number < 1)
	{
		$error = "Diesem Genre sind keine Sender zugeordnet.";
		return array("error" => $error);
	}

	$service = array();
  $channellist = $xml->e2event;
    foreach ($channellist as $channelxml)
		{
		$ename = ("$channelxml->e2eventservicename");
		$etitel = ("$channelxml->e2eventtitle");
		$edesc = ("$channelxml->e2eventdescription");
		$eid = ("$channelxml->e2eventid");
		$estart = getdate("$channelxml->e2eventstart");
    $estart = ("$estart[hours]:$estart[minutes]");
		$eduration = ("$channelxml->e2eventduration");
		$etime = ("$channelxml->e2eventcurrenttime");
		$exdesc = ("$channelxml->e2eventdescriptionextended");
		$sref = (string)str_replace(':','%3A',"$channelxml->e2eventservicereference");
		$pref = str_replace(':','_',"$channelxml->e2eventservicereference");

			$service[] = array(
				"ename" => $ename,
				"etitel" => $etitel,
				"edesc" => $edesc,
				"eid" => $eid,
				"estart" => $estart,
				"eduration" => $eduration,
				"etime" => $etime,
				"exdesc" => $exdesc,
				"sref" => $sref,
				"pref" => $pref
			);
		}
	return $service;
}


function getTimerList ()
{

  global $config;
  
  $string = file_get_contents("http://".$config['dreamip']."/web/timerlist");
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
		$name = ("$timerxml->e2servicename");
		$id = ("$timerxml->e2eit");
		$titel = ("$timerxml->e2name");
		$desc = ("$timerxml->e2description");
		$xdesc = ("$timerxml->e2descriptionextended");
		$tbeg = ("$timerxml->e2timebegin");
		$tend = ("$timerxml->e2timeend");
		$estart = getdate("$timerxml->e2timebegin");
    $estart = ("$estart[hours]:$estart[minutes]");
		$eend = getdate("$timerxml->e2timeend");
    $eend = ("$eend[hours]:$eend[minutes]");
		$duration = ("$timerxml->e2duration");
		$disabled = ("$timerxml->e2disabled");
		$justplay = ("$timerxml->e2justplay");

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

function getMovieList ()
{

  global $config;
  
  $string = file_get_contents("http://".$config['dreamip']."/web/movielist?dirname=/hdd/movie/&tag=");
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
		$name = ("$moviexml->e2servicename");
		$titel = ("$moviexml->e2title");
		$desc = ("$moviexml->e2description");
		$file = ("$moviexml->e2filename");
		$length = ("$moviexml->e2length");
		$time = getdate("$moviexml->e2time");
    $time = ("$time[hours]:$time[minutes]");
		$xdesc = ("$moviexml->e2descriptionextended");
		$sref = (string)str_replace(':','%3A',"$moviexml->e2servicereference");
		$pref = str_replace(':','_',"$moviexml->e2servicereference");

			$movie[] = array(
				"name" => $name,
				"titel" => $titel,
				"desc" => $desc,
				"file" => $file,
				"length" => $length,
				"time" => $time,
				"xdesc" => $xdesc,
				"sref" => $sref,
				"pref" => $pref
			);
		}
	return $movie;
}

function zapService ($sref)
{

	global $config;

	$string = file_get_contents("http://".$config['dreamip']."/web/zap?sRef=".$sref."");
	$result = new SimpleXMLElement($string);
  $result = $result->e2state;

    if ($result == "True")
    {
  	$string = file_get_contents("http://".$config['dreamip']."/web/subservices");
    $xmlResult = new SimpleXMLElement($string);
    $name = $xmlResult->e2service[0]->e2servicename;
    $name = utf8_decode($name);
  //    $event = $xmlResult->e2eventlist->e2event->e2eventname;
    $eventtitel = $xmlResult->e2service[0]->e2providername;
    $eventtitel = utf8_decode($eventtitel);
  
    WFC_SendNotification(43692 /*[WebFront Configurator]*/, $config['dbname'].' - Zap to', "$name \n", 'Speaker', 4);
    SetValueString ($config['current'], "$name \n");
    SetValueString ($config['event'], "$eventtitel");
    }

	return $result;
}

function deleteTimer($sref,$tbeg,$tend)
{

	global $config;

    if (GetAvailable($config['dreamip']))
    {
    	$string = file_get_contents("http://".$config['dreamip']."/web/timerdelete?sRef=".$sref."&begin=".$tbeg."&end=".$tend."");
    	$result = new SimpleXMLElement($string);
      $result = $result->e2statetext;

    WFC_SendNotification(43692 /*[WebFront Configurator]*/, $config['dbname'].' - Timer gelöscht', "$result \n", 'Speaker', 4);
   }
	return $result;

}
  
?>