<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Kanalliste</title>
<link href="css/dreambox.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.--><script>var __adobewebfontsappname__="dreamweaver"</script><script src="http://use.edgefonts.net/bilbo:n4:default;source-sans-pro:n4,n6,n2:default.js" type="text/javascript"></script>
</head>

<body>
<div id="wrapper">
  
<?
//Holt Variablen
//$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.120:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
// $description = utf8_encode($rpc->GetValueFormatted(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/)); //Formatiert
//$sender = utf8_encode($rpc->GetValue(42440));
$sender = utf8_encode(GetValue(42440));
// Holt EPG Info Was läuft jetzt Dreambox gibt zu vielen Sendern keine Informationen
//include(IPS_GetScript(44202 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\f_Enigma_2]*/)); //f_Enigma_2
include ("../../../scripts/f_Enigma_2.ips.php");
/*
function ENIGMA_GetTableHeader ()
{
	//Kopf der Tabelle erzeugen
	$html = '<table border="0" cellpadding="0" cellspacing0"0" class="tableLine">'.PHP_EOL;
	$html .= '<tbody style="">'.PHP_EOL;
	return $html;
}

function ENIGMA_GetTableFooter ()
{
	$html = '</tbody>'.PHP_EOL;
	$html .= '</table>'.PHP_EOL;
	retrun $html;
}
*/

if ($sender == "")
	{
	$HTMLData = "";
	//$rpc->SetValueString(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/  , $HTMLData);
	}

else
	{
	$bouquet = "1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
	$ipadr = IPS_GetProperty(20229, "Enigma2IP");	
	$epgnow = Enigma2_getChannelList($ipadr,$bouquet);
	
	$HTMLData = ENIGMA_GetTableHeader();
	$i = 0;
	foreach($epgnow as $now)
		{
		//Nur Ausgabe wenn Informationen vorhanden
//		if ($now['title'] == "None")
//		      {
//		      }
//		else
//				{

				$i = $i+1;
				if ($i % 2 != 0)
				 	{			
						$HTMLData .= '<table class="row_0"><tr><td rowspan="2" width="120" valign="top" align="left"><figure class="picon"><a href="http://'.$ipadr.'/web/zap?sRef='.$now['sref'].'"><img src="picon/'.$now['pref'].'.png" alt="logo"></a><figcaption>'.$now['name'].'</figcaption></figure></td>'.PHP_EOL;
						$HTMLData .= '<td class="titel">'.$now['title'].'</td></tr>'.PHP_EOL;
						$HTMLData .= '<tr><td align="left" valign="top" class="description">'.$now['desc'].'</td></tr></table>'.PHP_EOL;
					}
				else
				 	{
				   	$HTMLData .= '<table class="row_1"><tr><td rowspan="2" width="120" valign="top" align="left"><figure class="picon"><a href="http://'.$ipadr.'/web/zap?sRef='.$now['sref'].'"><img src="picon/'.$now['pref'].'.png" alt="logo"></a><figcaption>'.$now['name'].'</figcaption></figure></td>'.PHP_EOL;
						$HTMLData .= '<td class="titel">'.$now['title'].'</td></tr>'.PHP_EOL;
						$HTMLData .= '<tr><td align="left" valign="top" class="description">'.$now['desc'].'</td></tr></table>'.PHP_EOL;
					}
//				}
		}
	$HTMLData .= ENIGMA_GetTableFooter();
	//SetValueString(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/  , $HTMLData);
	}

echo utf8_encode($HTMLData);

?>
</div>
</body>
</html>