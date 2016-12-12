<?
$search = $_GET["search"];
$request = 'http://files.mavvy.net/xtreamer/shoutcast/stationsearch.php?search='.$search;
$stations = @simplexml_load_file($request);

$return = '';

if (count($stations->station) > 0) {
	for ($i = 0; $i < count($stations->station); $i++) {
		$station = $stations->station[$i]['name'];
		$id = $stations->station[$i]['id'];
		$br = $stations->station[$i]['br'];
		$ct = $stations->station[$i]['ct'];
		$lc = $stations->station[$i]['lc'];

		$return .= '<li><a href="?view=shoutcast&station='.$id.'">'.str_replace("- a SHOUTcast.com member station", "", $station).'<br /><small>'.$ct.'<br />'.$br.' kbps | '.$lc.' listeners</small></a></li>'."\n";
	}
}

print $return;
?> 