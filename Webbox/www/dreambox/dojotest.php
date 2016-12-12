<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	
    <title>Test: Dojo</title>
	<link rel="icon" href="../../favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/dreambox.css" />
	<!-- load Dojo -->
    <script src="//ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"
            data-dojo-config="async: true"></script>
<?
include IPS_GetKernelDir().'scripts/f_Enigma_2.ips.php';
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
$sender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
$sref = utf8_encode($rpc->GetValue(24168 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\aktuelle Servicereferenz]*/));
$pref = utf8_encode($rpc->GetValue(19948 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Picture Reference]*/));

?>		
</head>
<body>
	
<?
echo    '<h1 id="greeting">'.$sender.'</h1>';

// Holt EPG Info Was läuft jetzt Dreambox gibt zu vielen Sendern keine Informationen
$sender = utf8_encode($rpc->GetValue(22679 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Aktueller Sender]*/));
if ($sender == "unbekannt")
	{
	$HTMLData = "";
	$rpc->SetValue(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/, $HTMLData);
	}

else
	{
	$bouquet = "1:7:1:0:0:0:0:0:0:0:FROM%20BOUQUET%20%22userbouquet.favourites.tv%22%20ORDER%20BY%20bouquet";
	$epgnow = Enigma2_getChannelList($ipadr,$bouquet);
	//var_dump($epgnow);

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
						$HTMLData .= '<tr class="row_0"><td rowspan="2"><a href="http://'.$ipadr.'/web/zap?sRef='.$now['sref'].'"><img src="picon/'.$now['pref'].'.png" alt="logo"></a></td><td>'.$now['title'].'</td></tr>'.PHP_EOL; // Sender Titel
						$HTMLData .= '<tr class="row_0" id="description"><td>'.$now['desc'].'</td></tr>'.PHP_EOL; //  pref , Beschreibung
					   $HTMLData .= '<tr><td></td><td></td></tr>'.PHP_EOL; // Leerzeile
					}
				else
				 	{
				   	$HTMLData .= '<tr class="row_1"><td rowspan="2"><a href="http://'.$ipadr.'/web/zap?sRef='.$now['sref'].'"><img src="picon/'.$now['pref'].'.png" alt="logo"></a></td><td>'.$now['title'].'</td></tr>'.PHP_EOL; // Sender Titel
						$HTMLData .= '<tr class="row_1" id="description"><td>'.$now['desc'].'</td></tr>'.PHP_EOL; //  pref , Beschreibung
					   $HTMLData .= '<tr><td></td><td></td></tr>'.PHP_EOL; // Leerzeile
					}
//				}
		}
	$HTMLData .= ENIGMA_GetTableFooter();
	$rpc->SetValueString(22326 /*[Erdgeschoss\Wohnzimmer\Dreambox 8000\Kanalliste]*/, $HTMLData);
	echo utf8_encode($HTMLData);
	}


?>	
	<script>
        require([
    'dojo/dom',
    'dojo/fx',
    'dojo/domReady!'
], function (dom, fx) {
    // The piece we had before...
    var greeting = dom.byId('greeting');
    greeting.innerHTML += ' from Dojo!';

    // ...but now, with an animation!
    fx.slideTo({
        node: greeting,
        top: 100,
        left: 200
    }).play();
});
    </script>
    
</body>
</html>