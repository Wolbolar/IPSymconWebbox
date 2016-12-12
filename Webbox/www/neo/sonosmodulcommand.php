<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>IPS_RequestAction</title>
</head>

<body>

<?php
//Prüft ob POST oder GET

//POST
if (isset($_POST["objektid"]))
	{
		// ObjektID auslesen
		$objektid  = $_POST["objektid"];
		$command = $_POST["command"];
		getdataips($objektid, $command);
						
	}
//GET
elseif (isset($_GET["objektid"]))
	{
		// ObjektID auslesen
		
		$objektid = $_GET["objektid"];
		$command = $_GET["command"];
		getdataips($objektid, $command);
	}

//kein GET oder POST
else 
	{
		echo "Es wurden keine Daten empfangen";
	}

function getdataips($objektid)
	{
		// Befehl absenden
		$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
		if($command == "Play")
		{
			$rpc->SNS_Play($objektid);
		}
		elseif($command == "Next")
		{
			$rpc->SNS_Next($objektid);
		}
		elseif($command == "Pause")
		{
			$rpc->SNS_Pause($objektid);
		}
		elseif($command == "Previous")
		{
			$rpc->SNS_Previous($objektid);
		}
		elseif($command == "Stop")
		{
			$rpc->SNS_Stop($objektid);
		}
		
	}

		



			
?>

</body>
</html>
