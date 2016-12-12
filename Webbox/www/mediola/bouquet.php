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
$dm8000ip = GetValue(58413 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\IP]*/ );
$webport = GetValue(42651 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Port]*/);
$ipadr = $dm8000ip.":".$webport;
set_time_limit(120); //Timeout auf 30s setzen 

function ENIGMA2_GetAvailable($ipadr)
{

	$status = GetValueBoolean(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/);
   return $status;
}
//*************************************************************************************************************
// Ermittelt die EPG-Daten eines definierten Senders
function ENIGMA2_EPG($ipadr,$sender = "")
{
   $xmlResult[] = "";
   $sender = urlencode($sender);
   $xmlResult = new SimpleXMLElement(file_get_contents("http://$ipadr/web/epgservice?sRef=$sender"));
return $xmlResult;
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



$liste = ENIGMA2_GetServiceBouquetsOrServices($ipadr,'1:7:1:0:0:0:0:0:0:0:FROM BOUQUET "userbouquet.favourites.tv" ORDER BY bouquet');
$z = 1;

foreach ($liste as $bouquet)
{
   $Programm[$z][0]=$z; // Sendernummer
    $Programm[$z][1]=trim($bouquet->e2servicename); // Sendername
    $Programm[$z][2]=trim($bouquet->e2servicereference); // Senderreferenznummer
    echo $Programm[$z][0].". ".$Programm[$z][1].". ".$Programm[$z][2]." \n";
        $liste2 = ENIGMA2_EPG($ipadr, $Programm[$z][2]);
        $i = 0;
        foreach ($liste2 as $sendung)
      {
         // $Sendungsinfo[$z][$i][0] = utf8_decode($sendung->e2eventtitle); // Sendungsname
         $Sendungsinfo[$z][$i][0] = $sendung->e2eventtitle; // Sendungsname
         $startsec = ($sendung->e2eventstart);
         $Sendungsinfo[$z][$i][1] = date("H:i",(int)$startsec) .' Uhr'; // Startzeit
         $duration = ($sendung->e2eventduration);
         $Sendungsinfo[$z][$i][2] = date("H:i",(int)$startsec + (int)$duration) .' Uhr'; // Endzeit
            echo $Sendungsinfo[$z][$i][1]." - ".$Sendungsinfo[$z][$i][2].": ".$Sendungsinfo[$z][$i][0]." \n";
            If ($i == 1)
            {
                break;
            }
            $i = $i + 1;
        }
    $z = $z + 1;
}
return;
?>
</body>

</html>