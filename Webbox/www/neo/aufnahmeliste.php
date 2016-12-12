<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Aufnahmeliste</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>
<link href="css/jquery.mobile-1.4.5.iframe.css" rel="stylesheet" type="text/css">
<link href="css/dreambox.css" rel="stylesheet" type="text/css">

<!-- IP Symcom Variablen für Javascript bereitstellen -->
<?
//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.120:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
// $description = utf8_encode($rpc->GetValueFormatted(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/)); //Formatiert
//$sender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));

// Holt EPG Info Was läuft jetzt Dreambox gibt zu vielen Sendern keine Informationen
//include(IPS_GetScriptFile(44202 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\f_Enigma_2]*/)); //f_Enigma_2
include ("../../../scripts/f_Enigma_2.ips.php");

// Zeigt eine Liste Aufnahmen an
$movielist = ENIGMA2_getMovieList($ipadr);
$anzahl = $movielist[0]['anzahl']; // Zahl der Aufnahmen
$capacity = ENIGMA2_GetBoxInfo($ipadr);


$HTMLData = ENIGMA_GetTableHeader();
$HTMLData .= '<tr><td>Anzahl Aufnahmen: '.$anzahl.'</td><td>Festplattenplatz: '.$capacity[0]['capacity'].'</td><td>Freier Speicherplatz: '.$capacity[0]['hddfree'].'</td></tr>'.PHP_EOL; // Festplattenplatz und Anzahl der Aufnahmen
$HTMLData .= ENIGMA_GetTableFooter();
$i = 0;
foreach($movielist as $movie)
	{
   	$i = $i+1;
		if ($i % 2 != 0)
				{

				//				$HTMLData .= '<tr class="row_0"><td rowspan="2"><img src="picon/'.$movie['pref'].'.png" alt="logo"></td><td>'.$movie['titel'].'</td><td>				<form method="get" action="moviedelete.php">
				//    			<input type="hidden" name="DeleteMovie" value="'.$movie['sref'].'">
				//    			<button type="submit">Delete</button>
				//				</form></td></tr>'.PHP_EOL; // Picon Name delete
				$HTMLData .= '<table class="row_0">'.PHP_EOL;
						$HTMLData .= '<tr><td width="120" valign="top" id="Sendername">'.$movie['name'].'</td>'.PHP_EOL; // Sendername
				$HTMLData .= '<td class="titel" id="Aufnahmetitel">'.$movie['titel'].'</td>'.PHP_EOL; //Titel der Aufzeichnung
				$HTMLData .= '<td width="150" id="Delete"><a href="http://'.$ipadr.'/web/moviedelete?sRef='.$movie['sref'].'">Delete</a></td></tr>'.PHP_EOL; // Löschen der Aufnahme
				$HTMLData .= '<tr><td id="Aufnahmedatum">'.$movie['tag'].".".$movie['monat'].".".$movie['jahr'].'</td>'.PHP_EOL; // Datum der Aufnahme
				$HTMLData .= '<td rowspan="3"  class="description"><span id="shortdesc">'.$movie['desc'].'</span><br><span id="longdesc">'.$movie['xdesc'].'</span></td>'.PHP_EOL; // Kurzbeschreibung und Beschreibung
				$HTMLData .= '<td id="Play">Play</td></tr>'.PHP_EOL; // Abspielen der Aufnahme
				$HTMLData .= '<tr><td id="Time">'.$movie['time'].' Uhr</td><td></td></tr>'.PHP_EOL; // Uhrzeit der Aufnahme
				$HTMLData .= '<tr><td id="Lenght">'.$movie['length'].' Minuten</td><td align="center" id="Size">'.$movie['filesize'].' MB</td></tr>   '.PHP_EOL; // Dauer und Größe der Aufnahme
				// Picon muss noch geholt werden pref nicht vorhanden
				//$HTMLData .= '<tr><td rowspan="2"><img src="images/picon/'.$movie['pref'].'.png" alt="logo"></td><td>'.$movie['titel'].'</td><td>			<a href="http://'.$ipadr.'/web/moviedelete?sRef='.$movie['sref'].'">Delete</a></td></tr>'.PHP_EOL; // Picon Name delete
				//$HTMLData .= '<tr class="row_0"><td>'.$movie['tbeg'].'</td><td>'.$movie['sreftimer'].'</td><td>'.$movie['tend'].'</td></tr>'.PHP_EOL; // sreftimer
				//$HTMLData .= '<tr><td></td><td>'.$movie['sref'].'</td><td></td></tr>'.PHP_EOL; // sref
				//$HTMLData .= '<tr><td></td><td>'.$movie['filename'].'</td><td>'.$movie['filesize'].' MB</td></tr>'.PHP_EOL; // Filename
				$HTMLData .= '</table>'.PHP_EOL;
				}
		else
			 	{
				//				$HTMLData .= '<tr class="row_1"><td rowspan="2"><img src="picon/'.$movie['pref'].'.png" alt="logo"></td><td>('.$movie['titel'].')</td><td><form method="get" action="moviedelete.php">
				//    			<input type="hidden" name="DeleteMovie" value="'.$movie['sref'].'">
				//    			<button type="submit">Delete</button></td></tr>'.PHP_EOL; // Picon Name delete
				$HTMLData .= '<table class="row_1">'.PHP_EOL;
				$HTMLData .= '<tr><td width="120" valign="top" id="Sendername">'.$movie['name'].'</td>'.PHP_EOL; // Sendername
				$HTMLData .= '<td class="titel" id="Aufnahmetitel">'.$movie['titel'].'</td>'.PHP_EOL; //Titel der Aufzeichnung
				$HTMLData .= '<td width="150" id="Delete"><a href="http://'.$ipadr.'/web/moviedelete?sRef='.$movie['sref'].'">Delete</a></td></tr>'.PHP_EOL; // Löschen der Aufnahme
				$HTMLData .= '<tr><td id="Aufnahmedatum">'.$movie['tag'].".".$movie['monat'].".".$movie['jahr'].'</td>'.PHP_EOL; // Datum der Aufnahme
				$HTMLData .= '<td rowspan="3"  class="description"><span id="shortdesc">'.$movie['desc'].'</span><br><span id="longdesc">'.$movie['xdesc'].'</span></td>'.PHP_EOL; // Kurzbeschreibung und Beschreibung
				$HTMLData .= '<td id="Play">Play</td></tr>'.PHP_EOL; // Abspielen der Aufnahme
				$HTMLData .= '<tr><td id="Time">'.$movie['time'].' Uhr</td><td></td></tr>'.PHP_EOL; // Uhrzeit der Aufnahme
				$HTMLData .= '<tr><td id="Lenght">'.$movie['length'].' Minuten</td><td align="center" id="Size">'.$movie['filesize'].' MB</td></tr>   '.PHP_EOL; // Dauer und Größe der Aufnahme
				$HTMLData .= '</table>'.PHP_EOL;
			 	}
	}


//Schreibt Variable
$rpc->SetValueString(14155 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aufnahmeliste]*/  , $HTMLData);
$Content =  utf8_encode($HTMLData);

//$Content = "Keine Ahnung warum es nicht geht";
?>
</head>

<body>
  
<div data-role="page" id="pageaufnahmeliste">
  
    <div role="main" class="ui-content">
      	<!--<div id="wrapper">Loading</div>-->
        <div id="aufnahmeliste"><?php echo $Content; ?></div>
        <!-- Schreibt aktuelle Aufnahmeliste von der Dreambox -->
		<!--<script type="text/javascript">
          var Aufnahmeliste="";
          document.getElementById('aufnahmeliste').innerHTML = Aufnahmeliste;
          </script>-->
    </div>
</div>
</body>
</html>