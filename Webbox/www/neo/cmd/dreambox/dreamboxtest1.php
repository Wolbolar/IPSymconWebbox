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
<link href="../../css/jquery.mobile-1.4.5.iframe.css" rel="stylesheet" type="text/css">
<link href="../../css/dreambox.css" rel="stylesheet" type="text/css">
    <!-- Request Senden und Daten von PHP Seite abholen -->
 <script type="text/javascript">
  <!--
	var request = false;

	// Request senden
	function setRequest(id, option) {
		// Request erzeugen
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest(); // Mozilla, Safari, Opera
		} else if (window.ActiveXObject) {
			try {
				request = new ActiveXObject('Msxml2.XMLHTTP'); // IE 5
			} catch (e) {
				try {
					request = new ActiveXObject('Microsoft.XMLHTTP'); // IE 6
				} catch (e) {}
			}
		}

		// überprüfen, ob Request erzeugt wurde
		if (!request) {
			alert("Kann keine XMLHTTP-Instanz erzeugen");
			return false;
		} else {
			//var url = "cmd/dreambox/ipsdreambox.php";
			var url = "status1.php";
			// Name auslesen
			var value = $( '#'+id ).val();
			//var value = document.getElementById('source_'+id).innerHTML;
			// Option auslesen
			var option = 1;
			//var infotext = document.getElementById('option_0'+option).innerHTML;
			// Request öffnen
			request.open('post', url, true);
			// Requestheader senden
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			// Request senden
			request.send("value="+value+"&option="+option);
			// Request auswerten
			request.onreadystatechange = function() {
				interpretRequest(id, option);
			};
		}
	}

	// Request auswerten
	function interpretRequest(id, option) {
		switch (request.readyState) {
			// wenn der readyState 4 und der request.status 200 ist, dann ist alles korrekt gelaufen
			case 4:
				if (request.status != 200) {
					alert("Der Request wurde abgeschlossen, ist aber nicht OK\nFehler:"+request.status);
				} else {
					// Hier muss der Request ausgewertet werden und dem passenden Element zugewiesen werden
					// den Inhalt des Requests in das passende <div> schreiben
					
					// Antwort des Servers -> als XML-Dokument
					var xmlDoc	= request.responseXML;
					// Name aus dem XML-Dokument herauslesen
					var newvalue	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('value');
					// Bildurl aus dem XML-Dokument herauslesen
					var picon	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('image');
					// Alternativtext aus dem XML-Dokument herauslesen
					var alternate	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('alternate');
					// Bild erstellen
					var image	= "<img src=\""+picon+"\" alt=\""+picon+"\" />";
					// Schreibweise ändern
					//document.getElementById('source_'+id).innerHTML = newname;
					// Änderungsinfo anzeigen
					//document.getElementById('info_'+id).innerHTML = infotext;
					//document.getElementById('info_'+id+'.1').innerHTML = image;
					document.getElementById('aktuellerDreamboxstatus').innerHTML = "Status der Dreambox ist "+newvalue;
					
					
					//alt
					// Name aus dem XML-Dokument herauslesen
					//var newname	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('name');
					// Bildurl aus dem XML-Dokument herauslesen
					//var imageurl	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('image');
					// Alternativtext aus dem XML-Dokument herauslesen
					//var alternate	= xmlDoc.getElementsByTagName('newname')[0].getAttribute('alternate');
					// Bild erstellen
					//var image	= "<img src=\""+imageurl+"\" alt=\""+alternate+"\" />";
					// Schreibweise ändern
					//document.getElementById('source_'+id).innerHTML = newname;
					// Änderungsinfo anzeigen
					//document.getElementById('info_'+id).innerHTML = infotext;
					//document.getElementById('info_'+id+'.1').innerHTML = image;
				}
				break;
			default:
				break;
		}
	}

	// einem HTML-Tag ein Attribut anhängen
	function addAttribute(object, nr) {
		object.setAttribute('id', 'option_'+nr, 0);
	}
  //-->
  </script>
 
<!-- IP Symcom Variablen für Javascript bereitstellen -->
<?php
echo "<script type=\"text/JavaScript\">";
echo "function aktuellerSender(){";

//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
$sender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
$status = $rpc->GetValue(53181 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Status]*/); // Status der Dreambox
echo "document.write(\"Aktueller Sender ".$sender."\")";	
echo "}";

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
?>


<!--<script type="text/JavaScript">
//$( "#flipdreamboxstatus" ).flipswitch({
//  create: function( event, ui ) {}
//});
//$( "#flipdreamboxstatus" ).on( "flipswitchcreate", function( event, ui ) {} );
//$( "#flipdreamboxstatus" ).off( "flipswitchcreate", function( event, ui ) {} );
</script> -->
<script>
/* Auf Mouseklick reagieren */
$('#absatzsend').click(function(){
setRequest('flipdreamboxstatus', 1)
//alert('Es wurde auf #absatz1 geklickt');
//$('#absatzo2').addClass('fehlerhinweise');
});
$('#ZDF').click(function(){
setRequest('ZDF', 1)
//alert('Es wurde auf #absatz1 geklickt');
//$('#absatzo2').addClass('fehlerhinweise');
});	
$('#ARD').click(function(){
setRequest('ARD', 1)
//alert('Es wurde auf #absatz1 geklickt');
//$('#absatzo2').addClass('fehlerhinweise');
});		
</script>  
</head>
<body>
  
<div data-role="page" id="pagekanalliste">
  
    <div role="main" class="ui-content">
    <script type="text/JavaScript">
                        	var name	= "Hurz";
	$( "#name" ).html( "so ein Mist" );
                        </script></div>
      	<!--<div id="wrapper">Loading</div>-->
        <p id="absatzsend">send</p>
        <div id="dreambox8000">
            <section>
                <div id="aktuellersender">
                <!-- Schreibt aktuellen Sender der Dreambox -->
                <script type="text/JavaScript">
                        aktuellerSender();
                        </script></div>
                <div id="currentpicon"></div> 
            </section>

                
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
			  <script type="text/JavaScript">
			getbooldreamstatus();
			</script></div>
            <p id="ZDF">ZDF</p>
            <p id="ARD">ARD</p>
            <div id="testimg"><img src="../../images/piconhd/1_0_1_1C_11_85_C00000_0_0_0.png"></div>
            <div id="name"></div>
            
            <div id="name">hallo</div>
            <div id="title"></div>
            <div id="start"></div>
            <div id="ende"></div>
            <div id="dauer"></div>
            <div id="vorbei"></div>
            <div id="verbl"></div>
            <div id="description"></div>
            <div id="fortschritt"></div>
            <div id="endeint"></div>
            <div id="sref"></div>
            <div id="pref"></div>
            <div id="snrdb"></div>
            <div id="snr"></div>
            <div id="ber"></div>
            <div id="acg"></div>
            
        </div>

        </div>
    </div>
</div>
</body>
</html>
        
    
        
        
        
 
