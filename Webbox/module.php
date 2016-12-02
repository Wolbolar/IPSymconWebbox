<?

	class Webbox extends IPSModule
	{
		
		public function Create() {
			//Never delete this line!
			parent::Create();
			
			$this->RegisterPropertyString("Username", "");
			$this->RegisterPropertyString("Password", "");
		}
	
		public function ApplyChanges() {
			//Never delete this line!
			parent::ApplyChanges();
			
			$ipsversion = $this->GetIPSVersion();
			if($ipsversion == 0 || $ipsversion == 1)
			{
				$sid = $this->RegisterScript("WebboxIPSInterface", "Webbox IPS Interface", $this->CreateWebHookScript(), 1);
				IPS_SetHidden($sid, true);
				$this->RegisterHookOLD("/hook/webbox", $sid);
			}
			else
			{
				$this->RegisterHook("/hook/webbox");
			}
		}
		
		private function RegisterHookOLD($Hook, $TargetID)
		{
			$ids = IPS_GetInstanceListByModuleID("{015A6EB8-D6E5-4B93-B496-0D3F77AE9FE1}");
			if(sizeof($ids) > 0) 
			{
				$hooks = json_decode(IPS_GetProperty($ids[0], "Hooks"), true);
				$found = false;
				foreach($hooks as $index => $hook)
					{
					if($hook['Hook'] == $Hook)
						{
						if($hook['TargetID'] == $TargetID)
							return;
						$hooks[$index]['TargetID'] = $TargetID;
						$found = true;
					}
				}
				if(!$found) {
					$hooks[] = Array("Hook" => $Hook, "TargetID" => $TargetID);
				}
				IPS_SetProperty($ids[0], "Hooks", json_encode($hooks));
				IPS_ApplyChanges($ids[0]);
			}
		}
		
		private function RegisterHook($WebHook)
		{
  			$ids = IPS_GetInstanceListByModuleID("{015A6EB8-D6E5-4B93-B496-0D3F77AE9FE1}");
  			if(sizeof($ids) > 0)
				{
  				$hooks = json_decode(IPS_GetProperty($ids[0], "Hooks"), true);
  				$found = false;
  				foreach($hooks as $index => $hook)
					{
					if($hook['Hook'] == $WebHook)
						{
						if($hook['TargetID'] == $this->InstanceID)
  							return;
						$hooks[$index]['TargetID'] = $this->InstanceID;
  						$found = true;
						}
					}
  				if(!$found)
					{
 					$hooks[] = Array("Hook" => $WebHook, "TargetID" => $this->InstanceID);
					}
  				IPS_SetProperty($ids[0], "Hooks", json_encode($hooks));
  				IPS_ApplyChanges($ids[0]);
				}
  		}
		
		
		/**
		* This function will be available automatically after the module is imported with the module control.
		* Using the custom prefix this function will be callable from PHP and JSON-RPC through:
		*
		* Webbox_ProcessHookData($id);
		*
		*/
		public function ProcessHookDataOLD()
		{
			if($_IPS['SENDER'] == "Execute") {
				echo "This script cannot be used this way.";
				return;
			}
			
			if((IPS_GetProperty($this->InstanceID, "Username") != "") || (IPS_GetProperty($this->InstanceID, "Password") != "")) {
				if(!isset($_SERVER['PHP_AUTH_USER']))
					$_SERVER['PHP_AUTH_USER'] = "";
				if(!isset($_SERVER['PHP_AUTH_PW']))
					$_SERVER['PHP_AUTH_PW'] = "";
					
				if(($_SERVER['PHP_AUTH_USER'] != IPS_GetProperty($this->InstanceID, "Username")) || ($_SERVER['PHP_AUTH_PW'] != IPS_GetProperty($this->InstanceID, "Password"))) {
					header('WWW-Authenticate: Basic Realm="Webbox WebHook"');
					header('HTTP/1.0 401 Unauthorized');
					echo "Authorization required";
					return;
				}
			}
			
			if(!isset($_POST['device']) || !isset($_POST['id']) || !isset($_POST['name'])) {
				IPS_LogMessage("Webbox", "Malformed data: ".print_r($_POST, true));
				return;
			}
			
			$this->SendDebug("GeoFency", "Array POST: ".print_r($_POST, true), 0);
			$deviceID = $this->CreateInstanceByIdent($this->InstanceID, $this->ReduceGUIDToIdent($_POST['device']), "Device");
			SetValue($this->CreateVariableByIdent($deviceID, "Latitude", "Latitude", 2), $this->ParseFloat($_POST['latitude']));
			SetValue($this->CreateVariableByIdent($deviceID, "Longitude", "Longitude", 2), $this->ParseFloat($_POST['longitude']));
			SetValue($this->CreateVariableByIdent($deviceID, "Timestamp", "Timestamp", 1, "~UnixTimestamp"), intval(strtotime($_POST['date'])));
			SetValue($this->CreateVariableByIdent($deviceID, $this->ReduceGUIDToIdent($_POST['id']), utf8_decode($_POST['name']), 0, "~Presence"), intval($_POST['entry']) > 0);
			
		}
		
		/**
 		* This function will be called by the hook control. Visibility should be protected!
  		*/
		
		protected function ProcessHookData()
		{
			if($_IPS['SENDER'] == "Execute") {
				echo "This script cannot be used this way.";
				return;
			}
			
			if((IPS_GetProperty($this->InstanceID, "Username") != "") || (IPS_GetProperty($this->InstanceID, "Password") != "")) {
				if(!isset($_SERVER['PHP_AUTH_USER']))
					$_SERVER['PHP_AUTH_USER'] = "";
				if(!isset($_SERVER['PHP_AUTH_PW']))
					$_SERVER['PHP_AUTH_PW'] = "";
					
				if(($_SERVER['PHP_AUTH_USER'] != IPS_GetProperty($this->InstanceID, "Username")) || ($_SERVER['PHP_AUTH_PW'] != IPS_GetProperty($this->InstanceID, "Password"))) {
					header('WWW-Authenticate: Basic Realm="Webbox WebHook"');
					header('HTTP/1.0 401 Unauthorized');
					echo "Authorization required";
					return;
				}
			}
			/*
			if(!isset($_POST['type']) || !isset($_POST['id']) )
				{
				$this->SendDebug("Webbox", "Malformed data: ".print_r($_POST, true), 0);
				return;
				}
			*/
			
			//Prüft ob POST oder GET
			
			if (isset($_POST["type"]))
			{
				$type = $_POST['type'];
				if($type == "HTMLBox")
				{
					$id = $_POST['id'];
					$id = (int)$id;
					$htmlbox = $this->HTMLBox($id);
					echo $htmlbox;
				}
				if($type == "MediaImage")
				{
					$id = $_POST['id'];
					$id = (int)$id;
					$mediaimage = $this->MediaImage($id);
					$headhtml = $mediaimage["headhtml"];
					$imgdata = $mediaimage["imgdata"];
					header($headhtml);
					echo $imgdata;
				}	
			}
				
			if (isset($_GET["type"]))
			{
				$type = $_GET['type'];
				if($type == "HTMLBox")
				{
					$id = $_GET['id'];
					$id = (int)$id;
					$htmlbox = $this->HTMLBox($id);
					echo $htmlbox;
				}
				if($type == "MediaImage")
				{
					$id = $_GET['id'];
					$id = (int)$id;
					$mediaimage = $this->MediaImage($id);
					$headhtml = $mediaimage["headhtml"];
					$imgdata = $mediaimage["imgdata"];
					header($headhtml);
					echo $imgdata;
				}
				if($type == "test")
				{
					echo "Webbox Webhook";
				}
			}
			
			
			/*
			$deviceID = $this->CreateInstanceByIdent($this->InstanceID, $this->ReduceGUIDToIdent($_POST['device']), "Device");
			SetValue($this->CreateVariableByIdent($deviceID, "Latitude", "Latitude", 2), $this->ParseFloat($_POST['latitude']));
			SetValue($this->CreateVariableByIdent($deviceID, "Longitude", "Longitude", 2), $this->ParseFloat($_POST['longitude']));
			SetValue($this->CreateVariableByIdent($deviceID, "Timestamp", "Timestamp", 1, "~UnixTimestamp"), intval(strtotime($_POST['date'])));
			SetValue($this->CreateVariableByIdent($deviceID, $this->ReduceGUIDToIdent($_POST['id']), utf8_decode($_POST['name']), 0, "~Presence"), intval($_POST['entry']) > 0);
			*/
			
			
		}
		
		protected function HTMLBox($id)
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
			return $HTMLPage;
		}
		
		protected function MediaImage($imageid)
		{
		if(!IPS_MediaExists($imageid))
			die("ID #".$imageid.") does not exists");

		$media=IPS_GetMedia($imageid);

		if($media['MediaType'] != 1)
			die("ID #".$imageid." is not an image");

		$imgbase64 = IPS_GetMediaContent($imageid); //liefert den Base64 kodierten Inhalt für das Medienobjekt
		$imgdata = base64_decode($imgbase64); 
		$mimetype = $this->getImageMimeType($imgdata);
		$headhtml =  $this->getimgheader($mimetype);
		$mediaimage = array("headhtml" => $headhtml, "imgdata" => $imgdata)
		return $mediaimage;
		}
		
		protected function getimgheader($mimetype)
		{
			if($mimetype == "jpeg")
			{
			$header = '"Content-Type: image/jpeg"';
			}
			elseif($mimetype == "png")
			{
			$header = '"Content-Type: image/png"';
			}
			elseif($mimetype == "gif")
			{
			$header = '"Content-Type: image/gif"';
			}
			elseif($mimetype == "bmp")
			{
			$header = '"Content-Type: image/bmp"';
			}
			elseif($mimetype == "tiff")
			{
			$header = '"Content-Type: image/tiff"';
			}
			return $header;
		}
		
		protected function getBytesFromHexString($hexdata)
		{
		  for($count = 0; $count < strlen($hexdata); $count+=2)
			$bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

		  return implode($bytes);
		}

		protected function getImageMimeType($imagedata)
		{
		  $imagemimetypes = array( 
			"jpeg" => "FFD8", 
			"png" => "89504E470D0A1A0A", 
			"gif" => "474946",
			"bmp" => "424D", 
			"tiff" => "4949",
			"tiff" => "4D4D"
		  );

		  foreach ($imagemimetypes as $mime => $hexbytes)
		  {
			$bytes = $this->getBytesFromHexString($hexbytes);
			if (substr($imagedata, 0, strlen($bytes)) == $bytes)
			  return $mime;
		  }

		  return NULL;
		}
		
		private function CreateWebHookScript()
    {
        $Script = '<?
//Do not delete or modify.
Webbox_ProcessHookDataOLD('.$this->InstanceID.');		
?>';
        /*
		var_dump($_GET);
            $PlayerSelect = IPS_GetObjectIDByIdent("PlayerSelect",IPS_GetParent($_IPS["SELF"]));
            $PlayerID = GetValueInteger($PlayerSelect);
            if ($PlayerID == -1)
            {
            // Alle
            }
            elseif($PlayerID >= 0)
            {
                $Player = LMS_GetPlayerInfo(IPS_GetParent($_IPS["SELF"]),$PlayerID);
                if ($Player["Instanceid"] > 0)
                {
                    LSQ_LoadPlaylistByPlaylistID($Player["Instanceid"],(integer)$_GET["Playlistid"]);
                }
            }
            SetValueInteger($PlayerSelect,-2);
		*/
		
		return $Script;
    }
		
		private function ReduceGUIDToIdent($guid) {
			return str_replace(Array("{", "-", "}"), "", $guid);
		}
		
		protected function GetIPSVersion ()
		{
			$ipsversion = IPS_GetKernelVersion ( );
			$ipsversion = explode( ".", $ipsversion);
			$ipsmajor = intval($ipsversion[0]);
			$ipsminor = intval($ipsversion[1]);
			if($ipsminor < 10) // 4.0
			{
				$ipsversion = 0;
			}
			elseif ($ipsminor >= 10 && $ipsminor < 20) // 4.1
			{
				$ipsversion = 1;
			}
			else   // 4.2
			{
				$ipsversion = 2;
			}
			return $ipsversion;
		}
		
		/*
		Hook -> ProcessHookData
		OAuth -> ProcessOAuthData
		*/
		
		private function CreateCategoryByIdent($id, $ident, $name) {
			 $cid = @IPS_GetObjectIDByIdent($ident, $id);
			 if($cid === false) {
				 $cid = IPS_CreateCategory();
				 IPS_SetParent($cid, $id);
				 IPS_SetName($cid, $name);
				 IPS_SetIdent($cid, $ident);
			 }
			 return $cid;
		}
		
		private function CreateVariableByIdent($id, $ident, $name, $type, $profile = "") {
			 $vid = @IPS_GetObjectIDByIdent($ident, $id);
			 if($vid === false) {
				 $vid = IPS_CreateVariable($type);
				 IPS_SetParent($vid, $id);
				 IPS_SetName($vid, $name);
				 IPS_SetIdent($vid, $ident);
				 if($profile != "")
					IPS_SetVariableCustomProfile($vid, $profile);
			 }
			 return $vid;
		}
		
		/* Create Dummy Instanz */
		private function CreateInstanceByIdent($id, $ident, $name, $moduleid = "{485D0419-BE97-4548-AA9C-C083EB82E61E}")
		{
			 $iid = @IPS_GetObjectIDByIdent($ident, $id);
			 if($iid === false) {
				 $iid = IPS_CreateInstance($moduleid);
				 IPS_SetParent($iid, $id);
				 IPS_SetName($iid, $name);
				 IPS_SetIdent($iid, $ident);
			 }
			 return $iid;
		}
		
		private function ParseFloat($floatString) { 
			$LocaleInfo = localeconv(); 
			$floatString = str_replace(".", $LocaleInfo["decimal_point"], $floatString);
			$floatString = str_replace(",", $LocaleInfo["decimal_point"], $floatString);
			return floatval($floatString); 
		}
		
	}

?>
