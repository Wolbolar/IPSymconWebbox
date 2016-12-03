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
				if($type == "Colorwheel")
				{
					$id = $_GET['id'];
					$id = (int)$id;
					$colorwheel = $this->Colorwheel($id);
					echo $colorwheel;
				}
				if($type == "Slider")
				{
					$id = $_GET['id'];
					$id = (int)$id;
					$slider = $this->Slider($id);
					echo $slider;
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
		
		protected function HTMLBox($objektid)
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
		}
		
		protected function Colorwheel($id)
		{
			$content =	'<!DOCTYPE html>
	<html lang="de">
	
	<head>
	<title>Colorwheel</title>
	<!-- <script src="http://192.168.55.120:3777/user/Colorwheel/jquery-3.1.1.min.js"></script> -->
	<!-- <script src="http://192.168.55.120:3777/user/Colorwheel/raphael.min.js"></script> -->
	<script src="//code.jquery.com/jquery-2.1.0.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js" type="text/javascript"></script>
	<script src="http://192.168.55.120:3777/user/Colorwheel/colorwheel.js"></script>
	  <style type="text/css" media="screen">
    body {
      background:#FFF;
      font:14px/20px helvetica, arial;
      text-align:center;
      margin:40px;
      color:#666;
    }

    a {
      color:#F60;
    }

    .demo {
      text-align:left;
      width:600px;
      margin:0 auto;
      padding:20px;
      background:#FFFFEE;
      -moz-box-shadow: #a6a6a6 0px 0px 4px;
      box-shadow: #a6a6a6 0px 0px 4px;
      -webkit-box-shadow: #a6a6a6 0px 0px 4px;
    }
    input {
      font-family: monospace;
      font-size:16px;
    }
    .swatch {
      padding:10px;
    }
    .method {
      margin-bottom:20px;
    }
    .code p{margin:0; padding:0; display:none;}

    .source {
      font-size:10px;
      line-height:14px;
    }

    .example, .code {
      margin:10px 0;
      padding:10px 0;
      border-top:2px #CCC solid;
    }
    h2 {
      font-size:16px;
    }
    h1 {
      color:#000;
    }
    .example h2, .example p {
      margin:0 0 10px;
    }
     .example p {
       width:300px;
     }
    .method b {
      color:#2e5478;
    }

    .method div {
      width:400px;
    }

    code {
      display:none;
      background:#FFF;
      padding:10px;
    }

    .returns {
      color:#237210;
    }

    .show_source {
      margin:20px 0 0;
      color:#999;
      text-decoration:underline;
      cursor:pointer;
    }


  </style>
</head>

<body>
    <div class="demo">
      <div style="text-align:center">
        <div id="show_off" style="width:200px; margin: 0 auto"></div>
        <h1 class="title">Colorwheel</h1>
        <p>
          <b><a href="http://github.com/jweir/colorwheel/raw/master/colorwheel.js">Download</a>*</b> or
          <b>bower install colorwheel</b>
        </p>
      </div>
      <p>
        A javascript color picker. The wheel is drawn using the Raphael js library. jQuery is used to assist with events.
        The wheel size is set on creation. It supports a small set of callbacks and touch events.
      </p>
      <p>
        It was created for the UI at <a href="http://famedriver.com">Fame Driver</a> and distributed with a MIT license.
      </p>
      <p>
        Hope you enjoy it – <a href="mailto:john@famedriver.com">John Weir</a>
      </p>
      <p>
        Source available on <a href="http://github.com/jweir/colorwheel">Github</a>.
        Run <a href="test.html">simple test suite</a>.
      </p>
      <p>
        * Requires <a href="http://jquery.com">jQuery</a> and <a href="http://raphaeljs.com/">Raphael</a> version 2.1.0 or greater.
      </p>
      <div class="code">
        <h2>Usage and methods</h2>
        <div class="method">
        <b>var cw = Raphael.colorwheel(dom_element, height_width [, segments]);</b>
        <div>The wheel is drawn into a square, so only one dimension is required. <b>segments</b> is an option to increase, or decrease, the smoothness of the hue ring. 60 is the default.</div>
        </div>

        <div class="method">
        <b>cw.input(dom_element)</b> <span class="returns">&rArr; cw</span>
        <div>Binds a text input for setting and receiving the color as a hex value.  This will allow the user to input a hex value and update the wheel.</div>
        </div>

        <div class="method">
        <b>cw.onchange(callback)</b> <span class="returns">&rArr; cw</span>
        <div>Set a callback for any change received.  Callback takes one argument, a Raphael RGB color object.</div>
        </div>

        <div class="method">
        <b>cw.ondrag(start, stop)</b> <span class="returns">&rArr; cw</span>
        <div>Set a start and stop callback for dragging. The callbacks take one argument, a Raphael RGB color object.</div>
        </div>

        <div class="method">
        <b>cw.color()</b> <span class="returns">&rArr; Raphael color object</span>
        <div>Get the current color as RGB object</div>
        </div>

        <div class="method">
        <b>cw.color(hex_value)</b> <span class="returns">&rArr; cw</span>
        <div>Set the current color via a hex value</div>
        </div>
      </div>

      <div id="input_example" class="example">
        <h2>Input</h2>
        <p>Assigning an input to a colorwheel will allow the user to directly change the hex color value.</p>
        <p>When the input is set the colorwheel will set its color to the input\'s value</p>
        <div>
          <div style="float:left; width:100%; margin-bottom:20px">
            <div class="colorwheel" style="float:left; margin-right:20px; width:300px; text-align:left;"></div>
            <div style="float:left; width:50%">
              <input name="input_example" value="#FF9900" size="7"><br/>
              Enter a hex value above
            </div>
          </div>
        </div>
        <div class="show_source">Show Source</div>
        <code><pre class="source"></pre></code>
      </div>

      <div id="callback_example" class="example">
        <h2>Callbacks</h2>
        <p>Simple example using the callback to update an element\'s text and css.</p>
        <div >
          <div style="float:left; width:100%; margin-bottom:20px">
            <div class="colorwheel" style="float:left; margin-right:20px; width:300px; text-align:left;"></div>
            <div style="float:left; width:50%">
              <span class="onchange" style="padding:5px; color:#FFF"></span>
              <div class="ondrag" style="display:none;"><b>You are dragging the wheel</b></div>
            </div>
          </div>
        </div>
        <div class="show_source">Show Source</div>
        <code><pre class="source"></pre></code>
      </div>

      <div id="size_example" class="example">
        <h2>Sizes</h2>
        <p>The wheel can be scaled to suit your needs.  The large ring has larger number of segments, to make it smoother.</p>
        <div style="float:left; width:100%">
          <div class="colorwheel_small" style="text-align:left; float:left;margin-right:30px; margin-top:125px"></div>
          <div class="colorwheel_large" style="text-align:left; float:left;margin-right:30px; float:left;"></div>
          <div class="colorwheel_medium" style="text-align:left; margin-top:75px; float:left"></div>

        </div>
        <div class="show_source">Show Source</div>
        <code><pre class="source"></pre></code>
      </div>

      <div id="cycle_example" class="example">
        <h2>A more advanced callback</h2>
        <p>When the color is changed a callback is used to change the colors of each letter below.</p>
        <div style="text-align:left; float:left; height:180px; width:100%">
          <div class="colorwheel" style="text-align:left; float:left; width:200px"></div>
          <div class="cycle" style="float:left; width: 200px; padding:5px; background:#666; margin:40px; font-size:18px; font-weight:bold">These letters will get cycled through... and through...</div>
        </div>
        <div class="show_source">Show Source</div>
        <code><pre class="source"></pre></code>
      </div>


    <script>

      function show_source(target){
        target.slideDown();
      }

      function set_source(f, target){
        f();
        target.text(f.toString())
      }

function size_example(){
  Raphael.colorwheel($("#size_example .colorwheel_small")[0],50).color("#F00");
  Raphael.colorwheel($("#size_example .colorwheel_medium")[0],150).color("#0F0");
  Raphael.colorwheel($("#size_example .colorwheel_large")[0],300, 180).color("#00F");
}

function input_example(){
  var cw = Raphael.colorwheel($("#input_example .colorwheel")[0],150);
  cw.input($("#input_example input")[0]);
}

function callback_example(){
  var cw = Raphael.colorwheel($("#callback_example .colorwheel")[0],150),
      onchange_el = $("#callback_example .onchange"),
      ondrag_el = $("#callback_example .ondrag");
      cw.color("#F00");

  function start(){ondrag_el.show()}
  function stop(){ondrag_el.hide()}

  cw.ondrag(start, stop);
  cw.onchange(function(color)
    {
      var colors = [parseInt(color.r), parseInt(color.g), parseInt(color.b)]
      onchange_el.css("background", color.hex).text("RGB:"+colors.join(", "))
    })

}

function cycle_example(){
  var position = 0,
      letters = [],
      colorwheel;


  function setup_the_letters(){
    var cycle = $(".cycle"),
        l = cycle.text().split("");

    cycle.html("");

    for (var i=0; i < l.length; i++) {
      var letter = $("<span>"+l[i]+"</span>");
      cycle.append(letter);
      letters.push(letter);
    };
  }

  function update(color){
    position++;
    if(position > letters.length-1){ position = 0; }
    letters[position].css("color", color.hex);
  }

  colorwheel = Raphael.colorwheel($("#cycle_example .colorwheel")[0],150);
  setup_the_letters();
  colorwheel.onchange(update).color("#864343");
}

      $(document).ready(function(){
        Raphael.colorwheel($("#show_off")[0],200).color("#FF6600").onchange(function(c){$(".title").css("color",c.hex)});
        set_source(input_example, $("#input_example .source"))
        set_source(size_example, $("#size_example .source"))
        set_source(callback_example, $("#callback_example .source"))
        set_source(cycle_example, $("#cycle_example .source"))
        $(".show_source").click(function(){
          $(this).parents().filter(\'.example\').find("code").slideDown();
        });
      })
    </script>

	</body>
	</html>
	';
			return $content;
		}
		
		protected function ColorwheelJS()
		{
			
		}
		
		protected function Slider($id)
		{
			
		}
		
		protected function SliderFeedback()
		{
			
		}
		
		protected function ColorwheelFeedback()
		{
			
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
		$mediaimage = array("headhtml" => $headhtml, "imgdata" => $imgdata);
		return $mediaimage;
		}
		
		protected function getimgheader($mimetype)
		{
			if($mimetype == "jpeg")
			{
			$header = 'Content-Type: image/jpeg';
			}
			elseif($mimetype == "png")
			{
			$header = 'Content-Type: image/png';
			}
			elseif($mimetype == "gif")
			{
			$header = 'Content-Type: image/gif';
			}
			elseif($mimetype == "bmp")
			{
			$header = 'Content-Type: image/bmp';
			}
			elseif($mimetype == "tiff")
			{
			$header = 'Content-Type: image/tiff';
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
		
		private function ReduceGUIDToIdent($guid)
		{
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
