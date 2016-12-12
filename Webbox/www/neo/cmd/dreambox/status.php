<?php
header('Content-Type: text/xml; charset=utf-8'); // sorgt für die korrekte XML-Kodierung
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE

/*
// übermittelte Option auswerten
$option	= $_POST['option'];
switch ($option) {
	case 2:
		$name		= strtolower($_POST['name']);
		$alternate	= "Kleinbuchstaben";
		$image		= "images/smaller.png";
		break;
	case 3:
		$name		= strtoupper($_POST['name']);
		$alternate	= "Grossbuchstaben";
		$image		= "images/bigger.png";
		break;
	default:
		$name		= strtoupper(substr($_POST['name'], 0, 1)).strtolower(substr($_POST['name'], 1));
		$alternate	= "Normalansicht";
		$image		= "images/normal.png";
		break;
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<formatname>\n";
echo " <newname name=\"".$name."\" alternate=\"".$alternate."\" image=\"".$image."\" />\n";
echo "</formatname>\n";
*/

//include($rpc->IPS_GetScriptFile(44202 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\f_Enigma_2]*/)); //f_Enigma_2
include ("../../../../scripts/f_Enigma_2.ips.php");

//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
$sender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
$status = $rpc->GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); // Status der Dreambox



//Datenaustausch IP Symcon
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
	$value = $_POST['value'];
	$option	= $_POST['option'];
	
//Test
//$value = "reload";
//$option = 1;

// Auswerten was die Anfrage ist
if ($value == reload)
 	{
	
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
	
	$alternate = $pref;
	$value = $name;
	}
else
	{
		// Skript starten wenn Schalter bestätigt
		if ($value == "off")// Befehl ausführen
		{
		$rpc->IPS_RunScript(48973 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Standby]*/);
		$alternate	= "Aus";
		}
		elseif ($value == "on")// Befehl ausführen
		{
		$rpc->IPS_RunScript(44490 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status\Wakeup form Standby]*/);
		$alternate	= "An";
		}
	}
	$image		= "picon.png";
	
		
	// Ausgabe an aufrufende javascriptseite als XML
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<formatname>\n";
	echo " <newname value=\"".$value."\" alternate=\"".$alternate."\" image=\"".$image."\" />\n";
	echo "</formatname>\n";
	
	//schreibt Variable
	//$rpc->SetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/  , $status);
		
  
/*
echo "<script type=\"text/JavaScript\">";
echo "$(document).ready(function(){";
echo "function dreamboxepg(){";
//echo "var name	= \"".$name."\";";
echo "var name	= \"HURZ\";";
echo "var title	= \"".$title."\";";
echo "var start	= \"".$start."\";";
echo "var ende	= \"".$ende."\";";
echo "var dauer	= \"".$dauer."\";";
echo "var vorbei	= \"".$vorbei."\";";
echo "var verbl	= \"".$verbl."\";";
echo "var description	= \"".$description."\";";
echo "var fortschritt	= \"".$fortschritt."\";";
echo "var endeint	= \"".$endeint."\";";
echo "var sref	= \"".$sref."\";";
echo "var pref	= \"".$pref."\";";
echo "var snrdb	= \"".$snrdb."\";";
echo "var snr	= \"".$snr."\";";
echo "var ber	= \"".$ber."\";";
echo "var acg	= \"".$acg."\";";
echo "$( \"#name\" ).html(name);";
echo "$( \"#title\" ).html(title);";
echo "$( \"#start\" ).html(start);";
echo "$( \"#ende\" ).html(dauer);";
echo "$( \"#vorbei\" ).html(vorbei);";
echo "$( \"#verbl\" ).html(verbl);";
echo "$( \"#description\" ).html(description);";
echo "$( \"#fortschritt\" ).html(fortschritt);";
echo "$( \"#endeint\" ).html(endeint);";
echo "$( \"#sref\" ).html(sref);";
echo "$( \"#pref\" ).html(pref);";
echo "$( \"#snrbd\" ).html(snrdb);";
echo "$( \"#snr\" ).html(snr);";
echo "$( \"#ber\" ).html(ber);";
echo "$( \"#acg\" ).html(acg);";
echo "});";
echo "});";
echo "</script>";
*/
	


?>