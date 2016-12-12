<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sonos Bad</title>
<script type="text/javascript" src="js/reflex.js"></script><script type="text/javascript" src="js/moment-with-locales.min.js"></script>
<link href="css/neowebelement.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0">
<?php

//Prüft ob POST oder GET

//POST
if (isset($_POST["objektid"]))
	{
		// ObjektID auslesen
		$objektid  = $_POST["objektid"];
		if(isset($_POST["size"]))
		{
		$size = $_POST["size"];
		}
		else
		{
		$size = 340;
		}
		getdataips($objektid, $size);
		getdataips($objektid);
						
	}
//GET
elseif (isset($_GET["objektid"]))
	{
		// ObjektID auslesen
		
		$objektid = $_GET["objektid"];
		
		if(isset($_GET["size"]))
		{
		$size = $_GET["size"];
		}
		else
		{
		$size = 340;
		}
		getdataips($objektid, $size);
	}

//kein GET oder POST
else 
	{
		echo "Es wurden keine Daten empfangen";
	}


function getdataips($objektid, $size)
	{
			
		// HTMLBox ausgeben
		$sonoscover = GetValue($objektid);
		if($sonoscover == "")
		{
			$img = imagecreatetruecolor($size, $size);
			imagesavealpha($img, true);
			$color = imagecolorallocatealpha($img, 0, 0, 0, 127);
			imagefill($img, 0, 0, $color);
			imagepng($img, 'transparentcover.png');
			echo '<a href="sonos://"><img src="transparentcover.png" width="'.$size.'" height="'.$size.'" border="0" alt="Cover Sonos"></a>';
		}
		else
		{
			echo '<a href="sonos://"><img class="reflex" src="'.$sonoscover.'" width="'.$size.'" height="'.$size.'" border="0" alt="Cover Sonos"></a>';
		}	
	}

	
?>

</body>

</html>