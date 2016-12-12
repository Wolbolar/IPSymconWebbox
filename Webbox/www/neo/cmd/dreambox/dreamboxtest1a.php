<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dreambox 8000 Wohnzimmer</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.mobile-1.4.5.min.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>
<link href="../../css/dreambox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/dreamboxA.js"></script>
 
<!-- IP Symcom Variablen für Javascript bereitstellen -->
<?php


//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
$sender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
$status = $rpc->GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); // Status der Dreambox


function getjsDreamboxStatus($status)
	{
	if ($status == false)
		{
		$jsstatus = "off";
		}
	else
		{
		$jsstatus = "on";
		}
	return $jsstatus;
	}
$jsstatus = getjsDreamboxStatus($status);

/* Flipswitch Status setzten */
echo "$(\"#flipdreamboxstatus\").val('".$jsstatus."').flipswitch('refresh');";

echo "function getbooldreamstatus(){";
echo "document.write(\"".$jsstatus."\")";
echo "}";
echo "</script>";

/* PHP Funktionen */
		
//include($rpc->IPS_GetScriptFile(44202 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\f_Enigma_2]*/)); //f_Enigma_2
include ("../../../../../scripts/f_Enigma_2.ips.php");
// Holt EPG Info Was läuft jetzt Dreambox

// Liest das EPG aus und beschreibt alle notwendigen Variablen

list($name, $title, $start, $ende, $dauer, $vorbei, $verbl, $description , $fortschritt, $endeint, $sref, $pref) = ENIGMA2_GetCurrentFilm($ipadr);
list($snrdb, $snr, $ber, $acg) = ENIGMA2_SignalStatus($ipadr);
$URL = "<a href='http://".$ipadr."/web/stream.m3u?ref=$sref'>$name</a>";
//$aktuelleSenderinformation = "$name\n Titel      : $title\nStart      : $start - Ende       : $ende\nDauer      : $dauer - Vergangen  : $vorbei - Verbleiben : $verbl\nDetails    : $description";

If ($name == "N/A")
	{
	$pref = "N/A";
	$rpc->SetValue(19948 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Picture Reference]*/, $pref); /* Schreibt aktuelle Picture Referenz */
 	$rpc->SetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/, "unbekannt"); /* Schreibt aktuellen Sendernamen */
	$rpc->SetValueString(59613 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender Stream]*/ , "Keine Information");
	$rpc->SetValue(57911 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Sendungstitel]*/, " "); /* Schreibt Sendertitel */
	$rpc->SetValue(29169 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Start]*/, " "); /* Schreibt Startzeit */
	$rpc->SetValue(24681 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Ende]*/, " "); /* Schreibt Endzeit */
	$rpc->SetValue(16988 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Dauer]*/, " "); /* Schreibt Dauer */
	$rpc->SetValue(26828 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Vergangen]*/, " "); /* Schreibt vergangene Zeit */
	$rpc->SetValue(26663 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Verbleiben]*/, " "); /* Schreibt verbleibende Zeit */
	$rpc->SetValue(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/, " "); /* Schreibt Beschreibung */
	$rpc->SetValue(20384 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Sendungsfortschritt]*/, 0); /* Schreibt Sendungsfortschritt */
	$rpc->SetValue(24168 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\aktuelle Servicereferenz]*/, " "); /* Schreibt aktuelle Servicereferenz */
	$rpc->SetValue(31373 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\SNR]*/, 0); /* Schreibt SNR= Signal to Noise (Signal/Rauschabstand)  */
	$rpc->SetValue(50887 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\BER]*/, 0); /* Schreibt BER = Bit Errr Rate (Soll immer 0 sein) */
	$rpc->SetValue(43413 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Empfangspegel (AGC)]*/, 0); /* Schreibt AGC = Automatic Gain Controll */
	$rpc->SetValue(44386 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\snrdb]*/, 0); /* Schreibt SNR= Signal to Noise (Signal/Rauschabstand) dB */
   //$rpc->SetValue(19962 /*[Objekt #19962 existiert nicht]*/, " "); /* Schreibt Aktuelle Senderinformationen */
   $HTMLData = "";
	$rpc->SetValueString(49137 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\HTML EPG Ausgabe]*/  , $HTMLData);
   }
 else
   {
    $rpc->SetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/, $name); /* Schreibt aktuellen Sendernamen */
	$rpc->SetValueString(59613 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender Stream]*/ , $URL);
	$rpc->SetValue(57911 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Sendungstitel]*/, $title); /* Schreibt Sendertitel */
	$rpc->SetValue(29169 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Start]*/, $start); /* Schreibt Startzeit */
	$rpc->SetValue(24681 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Ende]*/, $ende); /* Schreibt Endzeit */
	$rpc->SetValue(16988 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Dauer]*/, $dauer); /* Schreibt Dauer */
	$rpc->SetValue(26828 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Vergangen]*/, $vorbei); /* Schreibt vergangene Zeit */
	$rpc->SetValue(26663 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Verbleiben]*/, $verbl); /* Schreibt verbleibende Zeit */
    $rpc->SetValue(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/, $description); /* Schreibt Beschreibung */
	$rpc->SetValue(20384 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Sendungsfortschritt]*/, $fortschritt); /* Schreibt Sendungsfortschritt */
	$rpc->SetValue(24168 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\aktuelle Servicereferenz]*/, $sref); /* Schreibt aktuelle Servicereferenz */
	$rpc->SetValue(19948 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Picture Reference]*/, $pref); /* Schreibt aktuelle Picture Referenz */
	$rpc->SetValue(31373 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\SNR]*/, $snr); /* Schreibt SNR= Signal to Noise (Signal/Rauschabstand)  */
	$rpc->SetValue(50887 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\BER]*/, $ber); /* Schreibt BER = Bit Errr Rate (Soll immer 0 sein) */
	$rpc->SetValue(43413 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Empfangspegel (AGC)]*/, $acg); /* Schreibt AGC = Automatic Gain Controll */
	$rpc->SetValue(44386 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\snrdb]*/, $snrdb); /* Schreibt SNR= Signal to Noise (Signal/Rauschabstand) dB */
   //$rpc->SetValue(19962 /*[Objekt #19962 existiert nicht]*/, $aktuelleSenderinformation); /* Schreibt Aktuelle Senderinformationen */

	// Ausgabe in Variable mit Beschreibung
	$HTMLData = ENIGMA_GetTableHeader();
//	$HTMLData .= '<tr><td><img src="/user/dreambox/picon/'.$pref.'.png" alt="logo">'.$name.'</td><td></td></tr>'.PHP_EOL; // Sendername Ausgabe innerhalb vom Webfront
   $HTMLData .= '<tr><td rowspan="3"><img src="picon/'.$pref.'.png" alt="logo"></td><td></td><td></td></tr>'.PHP_EOL; // Nur Picon
	// $HTMLData .= '<tr><td><img src="picon/'.$pref.'.png" alt="logo">'.$name.'</td><td></td></tr>'.PHP_EOL; // Sendername Ausgabe in externer Seite
	$HTMLData .= '<tr><td>'.$title.'</td><td> ('.$dauer.')</td></tr>'.PHP_EOL; // Titel und Länge
	$HTMLData .= '<tr><td>Start: '.$start.'</td><td>Endzeit: '.$ende.'</td></tr>'.PHP_EOL; // Start und Ende
	$HTMLData .= '<tr><td></td><td>Vergangen: '.$vorbei.'</td><td>Verbleiben: '.$verbl.'</td></tr>'.PHP_EOL; // Start und Ende
	$HTMLData .= '<tr><td colspan="2">'.$description.'</td></tr>'.PHP_EOL; // Beschreibung
   $HTMLData .= ENIGMA_GetTableFooter();

	$rpc->SetValueString(49137 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\HTML EPG Ausgabe]*/  , $HTMLData);
	
	
	// Ausgabe in Variable ohne Sendungsbeschreibung
	$HTMLData = ENIGMA_GetTableHeader();
//	$HTMLData .= '<tr><td><img src="/user/dreambox/picon/'.$pref.'.png" alt="logo">'.$name.'</td><td></td></tr>'.PHP_EOL; // Sendername Ausgabe innerhalb vom Webfront
   $HTMLData .= '<tr><td rowspan=3"><img src="picon/'.$pref.'.png" alt="logo"></td><td></td><td></td></tr>'.PHP_EOL; // Nur Picon
	//$HTMLData .= '<tr><td><img src="picon/'.$pref.'.png" alt="logo">'.$name.'</td><td></td></tr>'.PHP_EOL; // Sendername Ausgabe in externer Seite
	$HTMLData .= '<tr><td>'.$title.'</td><td> ('.$dauer.')</td></tr>'.PHP_EOL; // Titel und Länge
	$HTMLData .= '<tr><td>Start: '.$start.'</td><td>Endzeit: '.$ende.'</td></tr>'.PHP_EOL; // Start und Ende
	$HTMLData .= '<tr><td></td><td>Vergangen: '.$vorbei.'</td><td>Verbleiben: '.$verbl.'</td></tr>'.PHP_EOL; // Start und Ende
	$HTMLData .= ENIGMA_GetTableFooter();

	$rpc->SetValueString(23809 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktuelle Sendungsinfo ohne Beschreibung]*/  , $HTMLData);
	
  }
  

?>

<style type="text/css">
#socialbookmarksanzeigen {
	background-color: #00CC00;
	padding: 0.4em;
}
#sozialbookmarks {
	background-color: orange;
	padding: 0.4em;
}
</style>
<link href="../../css/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css">
</head>
<body>
  
<div data-role="page" id="pagekanalliste">
  
    <div role="main" class="ui-content">
   
       
        <div id="dreambox8000">
           

                
              <div id="dreamboxstatus">
              <form>
                <label for="flipdreamboxstatus" class="ui-hidden-accessible">Dreambox Status:</label>
                    <select name="flipdreamboxstatus" id="flipdreamboxstatus" data-role="flipswitch">
                        <option id="dreamboxflipstatus_aus" value="off">Aus</option>
                        <option id="dreamboxflipstatus_an" value="on">An</option>
                    </select>
                </form>
              <!-- Sendet Request beim Ändern -->
			<script type="text/javascript">
               $("#dreamboxstatus").change(function() {
               var dreambox_statusflip = $("#flipdreamboxstatus").val();
               // Sendet Request bei Ändern des Status
			   setRequest('flipdreamboxstatus', 1);
               //setRequest(dreambox_statusflip);
               });
            </script> 
            </div>
            <div id="aktuellerDreamboxstatus">
            <!-- Schreibt aktuellen Status von Dreambox -->
                          Status der Dreambox ist
			  </div>
            
            <div id="reload">aktualisieren</div>
			<div id="alternate"></div>
         	<section>
              <!-- Container für Variablen -->
            <div id="currentchannel">Sender</div>
            <div id="title">Titel</div>
            <div id="start">Start</div>
            <div id="ende">Ende</div>
            <div id="dauer">Dauer</div>
            <div id="vorbei">Vorbei</div>
            <div id="verbl">Verbleibend</div>
            <div id="description">Beschreibung</div>
            <div id="fortschritt">Fortschritt</div>
            <div id="endeint">Endeint</div>
            <div id="sref">sref</div>
            <div id="pref">pref</div>
            <div id="snrdb">snrdb</div>
            <div id="snr">snr</div>
            <div id="ber">ber</div>
            <div id="acg">acg</div>  
                
            </section>
         	<figure id="piconbig"><img class="piconbig" src="../../images/piconhd/1_0_1_77D8_40A_1_C00000_0_0_0.png"><figcaption class="piconbigtext" id="piconbigtext">Picon Sender</figcaption></figure>
            <section class="dreamboxzapbuttons">
    		<div class="zapbutton" id="ARD">ARD</div><div class="zapbutton" id="ZDF">ZDF</div>
    		</section>
            
        </div>

        </div>
    </div>
</div>
</body>
</html>
        
    
        
        
        
 
