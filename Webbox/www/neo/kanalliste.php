<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kanalliste</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>

<link href="css/jquery.mobile-1.4.5.iframe.css" rel="stylesheet" type="text/css">
<link href="css/dreambox.css" rel="stylesheet" type="text/css">
<link href="css/hover.css" rel="stylesheet" media="all">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
<script type=\"text/javascript\">
  window.xhrGet=function xhrGet(o) {
      var HTTP = new XMLHttpRequest();
    HTTP.open(\'GET\',o,true);
    HTTP.send(NULL);
  }
  window.xhrPost=function xhrPost(o, data) {
      var HTTP = new XMLHttpRequest();
    HTTP.open(\'POST\',o,true);
    HTTP.send(data);
  }
  window.xhrRPC=function xhrRPC(o, name, params) {
      var HTTP = new XMLHttpRequest();
    HTTP.open(\'POST\',o,true);
    var rpc = JSON.stringify({\"jsonrpc\":\"2.0\", \"method\":name, \"params\":params, \"id\":0});
   HTTP.setRequestHeader(\"Content-type\", \"application/json\");
   HTTP.setRequestHeader(\"Authorization\", \"Basic \" + btoa(\"hatto.zechel@web.de:Geck0!975\"));
    HTTP.send(rpc);
  }
  </script>
<!-- IP Symcom Variablen für Javascript bereitstellen -->
<?
//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.120:3777/api/");
// Skript starten
// $rpc->IPS_RunScript(10135 /*[Erdgeschoss\Wohnzimmer\LE40C750\Status\LE40C750 Off]*/); 
// $description = utf8_encode($rpc->GetValueFormatted(43864 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Beschreibung]*/)); //Formatiert
$sender = utf8_encode($rpc->GetValue(42440));

// Holt EPG Info Was läuft jetzt Dreambox gibt zu vielen Sendern keine Informationen
//include(IPS_GetScriptFile(44202 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Funktionen\f_Enigma_2]*/)); //f_Enigma_2
include ("../../../scripts/f_Enigma_2.ips.php");
if ($sender == "")
	{
	$HTMLData = "";
	$rpc->SetValueString(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/  , $HTMLData);
	}

else
	{
	$bouquet = "1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
	$ipadr = IPS_GetProperty(20229, "Enigma2IP");
	$epgnow = Enigma2_getChannelList($ipadr,$bouquet);
	//var_dump($epgnow);

	//$HTMLData = ENIGMA_GetTableHeader();
	$HTMLData = "";
	$i = 0;
	foreach($epgnow as $now)
		{
				$i = $i+1;
				if ($i % 2 != 0)
				 	{	
						$HTMLData .= "<table class=\"row_0\"><tr><td rowspan=\"2\" width=\"120\" valign=\"top\" align=\"left\"><figure class=\"picon\"><div onclick=window.xhrRPC('/api/','SetValue',[11848 /*[Geräte\Heimkino\Video\Dreambox\Zap\Dreambox 8000 Wohnzimmer Zap\Sender auf SREF umschalten]*/,'".$now['sref']."']);><img class=\"hvr-grow\" src=\"images/picon/".$now['pref'].".png\" alt=\"logo\"></div><figcaption>".$now['name']."</figcaption></figure></td>".PHP_EOL;
						$HTMLData .= "<td class=\"titel\">".$now['title']."</td></tr>".PHP_EOL;
						$HTMLData .= "<tr><td align=\"left\" valign=\"top\" class=\"description\">".$now['desc']."</td></tr></table>".PHP_EOL;
					}
				else
				 	{
						$HTMLData .= "<table class=\"row_1\"><tr><td rowspan=\"2\" width=\"120\" valign=\"top\" align=\"left\"><figure class=\"picon\"><div onclick=window.xhrRPC('/api/','SetValue',[11848 /*[Geräte\Heimkino\Video\Dreambox\Zap\Dreambox 8000 Wohnzimmer Zap\Sender auf SREF umschalten]*/,'".$now['sref']."']);><img class=\"hvr-grow\" src=\"images/picon/".$now['pref'].".png\" alt=\"logo\"></div><figcaption>".$now['name']."</figcaption></figure></td>".PHP_EOL;
						$HTMLData .= "<td class=\"titel\">".$now['title']."</td></tr>".PHP_EOL;
						$HTMLData .= "<tr><td align=\"left\" valign=\"top\" class=\"description\">".$now['desc']."</td></tr></table>".PHP_EOL;
					}
		}
	//$HTMLData .= ENIGMA_GetTableFooter();
	
	}
//schreibt Variable funktioniert nicht nur über user dir
//$rpc->SetValueString(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/  , $HTMLData); 
//echo utf8_encode($HTMLData);
//$Content =  utf8_encode($HTMLData);

$Content = "Keine Ahnung warum es nicht geht";
?>
</head>
<body>
  
<div data-role="page" id="pagekanalliste">
  
    <div role="main" class="ui-content">
      	<!--<div id="wrapper">Loading</div>-->
        <div id="kanalliste"><?php echo utf8_encode($HTMLData); ?></div>
        <!-- Schreibt aktuelle Kanalliste von der Dreambox -->
		<!--<script type="text/javascript">
          var Kanalliste=" ";
          document.getElementById('kanalliste').innerHTML = Kanalliste;
          </script> -->
    </div>
</div>
</body>
</html>