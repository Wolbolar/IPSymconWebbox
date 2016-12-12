<?php

		
/***********************************************************************************************/

//Prüft ob POST oder GET

//POST
if (isset($_POST["objektid"]))
	{
		// ObjektID auslesen
		$objektid  = $_POST["objektid"];
		getdataips($objektid);
						
	}
//GET
elseif (isset($_GET["objektid"]))
	{
		// ObjektID auslesen
		
		$objektid = $_GET["objektid"];
		getdataips($objektid);
	}

//kein GET oder POST
else 
	{
		echo "Es wurden keine Daten empfangen";
	}


function getdataips($objektid)
	{
			
		// HTMLBox ausgeben
		$HTML = GetValue($objektid);
		if ( strpos($HTML, '</html>'))
		{
		//echo utf8_encode($HTML);
		echo $HTML;
		}
		else
		{
		$HTMLHead = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>HTMLBox</title>
<link href="css/neowebelement.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0">';
		$HTMLButtom = '
</body>
</html>';
		$HTMLPage = $HTMLHead;
		$HTMLPage .= $HTML;
		$HTMLPage .= $HTMLButtom;
		//echo utf8_encode($HTMLPage);
		echo $HTMLPage;
		}
	}



?>