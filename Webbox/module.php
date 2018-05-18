<?

	class Webbox extends IPSModule
	{
		
		public function Create() {
			//Never delete this line!
			parent::Create();
			
			$this->RegisterPropertyString("webhookusername", "ipsymcon");
			$this->RegisterPropertyString("webhookpassword", "useripsh0me");	
		}
	
		public function ApplyChanges() {
			//Never delete this line!
			parent::ApplyChanges();
			$ipsversion = $this->GetIPSVersion();
			if($ipsversion == 0)
				{
					//prüfen ob Script existent
					$SkriptID = @IPS_GetObjectIDByIdent("WebboxIPSInterface", $this->InstanceID);
					if ($SkriptID === false)
						{
							$ID = $this->RegisterScript("WebboxIPSInterface", "Webbox IPS Interface", $this->CreateWebHookScript(), 1);
							IPS_SetHidden($ID, true);
							$this->RegisterHookOLD('/hook/webbox', $ID);
						}
					else
						{
							//echo "Die Skript-ID lautet: ". $SkriptID;
						}
				}
			else
				{
					$SkriptID = @IPS_GetObjectIDByIdent("WebboxIPSInterface", $this->InstanceID);
					if ($SkriptID > 0)
					{
						$this->UnregisterHook("/hook/webbox");
						$this->UnregisterScript("WebboxIPSInterface");
					}
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
     * Löscht einen WebHook, wenn vorhanden.
     *
     * @access private
     * @param string $WebHook URI des WebHook.
     */
    protected function UnregisterHook($WebHook)
    {
        $ids = IPS_GetInstanceListByModuleID("{015A6EB8-D6E5-4B93-B496-0D3F77AE9FE1}");
        if (sizeof($ids) > 0)
        {
            $hooks = json_decode(IPS_GetProperty($ids[0], "Hooks"), true);
            $found = false;
            foreach ($hooks as $index => $hook)
            {
                if ($hook['Hook'] == $WebHook)
                {
                    $found = $index;
                    break;
                }
            }
            if ($found !== false)
            {
                array_splice($hooks, $index, 1);
                IPS_SetProperty($ids[0], "Hooks", json_encode($hooks));
                IPS_ApplyChanges($ids[0]);
            }
        }
    }  
	
	/**
     * Löscht eine Script, sofern vorhanden.
     *
     * @access private
     * @param int $Ident Ident der Variable.
     */
    protected function UnregisterScript($Ident)
    {
        $sid = @IPS_GetObjectIDByIdent($Ident, $this->InstanceID);
        if ($sid === false)
            return;
        if (!IPS_ScriptExists($sid))
            return; //bail out
        IPS_DeleteScript($sid, true);
    } 
		
		
		protected function GetRequestVarValue($varvalue)
		{
			$varvaluetype = 3; // string
			$numeric = is_numeric($varvalue);
			$varvaluebool = strtolower($varvalue);// bolean
			if($varvaluebool == "false")
			{
				$varvalue = false;
				$varvaluetype = 0; // boolean
			}
			if($varvaluebool == "true")
			{
				$varvalue = true;
				$varvaluetype = 0; // boolean
			}
			if($numeric)
			{
				$varvaluefloat = $this->isfloat($varvalue);
				if($varvaluefloat)
				{
					$varvalue = floatval($varvalue);// float
					$varvaluetype = 2;
				}
				else
				{
					$varvalue = intval($varvalue);// int
					$varvaluetype = 1;
				}
			}
			$varvalue = array("VarType" => $varvaluetype, "Value" => $varvalue);
			return $varvalue;
		}
		
		protected function isfloat($value)
		{
			// PHP automagically tries to coerce $value to a number
			return is_float($value + 0);
		}
		
		protected function CompareVartype($type, $objid)
		{
				$varinfo = (IPS_GetVariable($objid));
				$vartype =  $varinfo["VariableType"];
				if ($vartype == 0) //bool
				{
					$ipsvartype = "boolean";
				}
				elseif ($vartype == 1) //integer
				{
					$ipsvartype = "integer";
				}
				elseif ($vartype == 2) //float
				{
					$ipsvartype = "double";
				}
				elseif ($vartype == 3) //string
				{
					$ipsvartype = "string";
				}
				
				if ($type ===  $ipsvartype)
				{
					return true;
				}
				else
				{
					return false;
				}
		}
		
		protected function IPSResponse($response, $style)
		{
			$cssstyle = $this->GetCSSStyle($style);
			$HTMLHead = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>HTMLBox</title>
'.$this->WebboxCSSTransparent().'
</head>
<body marginheight="0" marginwidth="0">';
		$HTMLButtom = '
</body>
</html>';
			$HTMLPage = $HTMLHead;
			$HTMLPage .= $response;
			$HTMLPage .= $HTMLButtom;
			return $HTMLPage;
		}
		
		protected function GetCSSStyle($style)
		{
			if($style == "comic")
			{
				$CSS = '<style type="text/css" media="screen">
			</style>';
			}
			else
			{
				$CSS = '<style type="text/css" media="screen">
			</style>';
			}
			return $CSS;
		}
		
		protected function WebboxCSSTransparent()
		{
			$CSS = '<style type="text/css" media="screen">
			@charset "utf-8";
			body {
				background-color: transparent;
			}
			</style>';
			return $CSS;
		}
		
		protected function Keypanel()
		{
			
		}
		
		protected function NaviCursor()
		{
			
		}
		
		protected function Toggle()
		{
			
		}
		
		protected function savepicture($imgdata, $output_file)
		{
			$ifp = fopen($output_file, "wb"); 

			//$data = explode(',', $base64_string);

			//fwrite($ifp, base64_decode($data[1])); 
			fwrite($ifp, $imgdata); 
			fclose($ifp); 

			return $output_file; 
		}
		
		protected function Cover($imgobjectid, $size, $detailobjectid)
		{
			$name = IPS_GetName($imgobjectid);
			$mediaimage = $this->MediaImage($imgobjectid);
			//$headhtml = $mediaimage["headhtml"];
			$imgdata = $mediaimage["imgdata"];
			$mimetype = $mediaimage["mimetype"];
			$output_file = IPS_GetKernelDir()."media".DIRECTORY_SEPARATOR.$name."_temp.".$mimetype;
			$ImageFile = $this->savepicture($imgdata, $output_file);
			$imageinfo = $this->getimageinfo($ImageFile);
			$mediaimgwidth = $size;
			$mediaimgheight = $size;
			$image = $this->createimage($ImageFile, $imageinfo["imagetype"]);
			$thumb = $this->createthumbnail($mediaimgwidth, $mediaimgheight, $imageinfo["imagewidth"],$imageinfo["imageheight"]);
			$thumbimg = $thumb["img"];
			$thumbwidth = $thumb["width"];
			$thumbheight = $thumb["height"];
			$coverimg = $this->copyimgtothumbnail($thumbimg, $image, $thumbwidth, $thumbheight, $imageinfo["imagewidth"],$imageinfo["imageheight"], $name);
				
			// HTMLBox ausgeben
			$sonoscoverdetail = GetValue($detailobjectid);
			if($sonoscoverdetail == "")
			{
				$img = imagecreatetruecolor($size, $size);
				imagesavealpha($img, true);
				$color = imagecolorallocatealpha($img, 0, 0, 0, 127);
				imagefill($img, 0, 0, $color);
				imagepng($img, 'transparentcover.png');
				$cover = '<a href="sonos://"><img src="transparentcover.png" width="'.$size.'" height="'.$size.'" border="0" alt="Cover Sonos"></a>';
			}
			else
			{
				$cover = '<a href="sonos://"><img class="reflex" src="'.$coverimg.'" width="'.$size.'" height="'.$size.'" border="0" alt="Cover Sonos"></a>';
			}	

			$content = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>'.$name.'</title>
<script type="text/javascript" src="js/reflex.js"></script><script type="text/javascript" src="js/moment-with-locales.min.js"></script>
<link href="css/neowebelement.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0">
'.$cover.'
</body>
</html>';
			return $content;
		}
		
		protected function HTMLBox($objectid, $uri)
		{
		// HTMLBox ausgeben
		$HTML = GetValue($objectid);
		if ( strpos($HTML, '</iframe>'))
			{
                $start = strpos($HTML, '<iframe src="');
                if($start<>0)
                {
                    $start = strpos($HTML, "<iframe src='");
                    $htmlrest = substr($HTML, $start+13);
                    $end = strpos($htmlrest, "'");
                }
                else
                {
                    $htmlrest = substr($HTML, $start+13);
                    $end = strpos($htmlrest, '"');
                }
                $src = substr($HTML, $start+13, $end);
                $poshttp = strpos($src, 'http://');
                $poshttps = strpos($src, 'https://');
                $posuser = strpos($src, 'user');
                if($poshttp)
                {
                    $src = substr($src, $poshttp);
                    $absuri = $src;
                    $this->SendDebug("Webbox URL", "http found", 0);
                }
				elseif($poshttps)
                {
                    $src = substr($src, $poshttps);
                    $absuri = $src;
                    $this->SendDebug("Webbox URL", "https found", 0);
                }
				elseif($posuser)
                {
                    $src = substr($src, $posuser);
                    $absuri = $uri."/".$src;
                    $this->SendDebug("Webbox URL", "user found", 0);
                }
                else
                {
                    $absuri = $uri."/".$src;
                    $this->SendDebug("Webbox URL", "URI ".$absuri, 0);
                }
                $this->SendDebug("Webbox URL", $absuri, 0);
			$HTML = file_get_contents($absuri);
			IPS_LogMessage("Webbox", "Auslesen : ".$absuri);
			return $HTML;
			}
		if ( strpos($HTML, '</html>'))
			{
			//echo utf8_encode($HTML);
			return $HTML;
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
		
		protected function ColorwheelOLD($id)
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

      $(document).ready(function()
	  {
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
		
		protected function Colorwheel($id, $size)
		{
			$content =	'<!DOCTYPE html>
	<html lang="de">
	
	<head>
	<title>Colorwheel</title>
	<script src="//code.jquery.com/jquery-2.1.0.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js" type="text/javascript"></script>
	'.$this->ColorwheelJS().$this->ColorwheelCSS().'
	</head>

	<body>
		<div id="size">
			  <div class="colorwheel"></div>
		</div>

		<script>
	$(document).ready(function()
	  {
        Raphael.colorwheel($("#size .colorwheel")[0],'.$size.', '.$this->ColorwheelSegments($size).').color("#00F");
      })
		</script>

	</body>
	</html>
	';
			return $content;
		}
		
		protected function ColorwheelJS()
		{
			$JS = '<script>
			/*
* Colorwheel
* Copyright (c) 2010 John Weir (http://famedriver.com)
* Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
*
* requires jQuery & Raphael
*   http://jquery.com http://raphaeljs.com
*
* see http://jweir.github.com/colorwheel for Usage
*
*/

Raphael.colorwheel = function(target, color_wheel_size, no_segments){
  var canvas,
      current_color,
      current_color_hsb,
      size,
      segments = no_segments || 60,
      bs_square = {},
      hue_ring = {},
      tri_size,
      cursor = {},
      drag_target,
      input_target,
      center,
      parent,
      change_callback,
      drag_callbacks = [function(){}, function(){}],
      offset,
      padding = 2,
      sdim; // holds the dimensions for the saturation square

  function point(x, y){ return {x:x, y:y};}
  function radians(a){ return a * (Math.PI/180);}

  function angle(x,y){
    var q = x > 0 ? 0 : 180;
    return q+Math.atan((0 - y)/(0 - x))*180/(Math.PI);
  }

  function create(target, color_wheel_size){
    size     = color_wheel_size;
    tri_size = size/20;
    center   = size/2;
    parent   = $(target);
    canvas   = Raphael(parent[0],size, size);
    canvas.safari();

    create_bs_square();
    create_hue_ring();
    hue_ring.cursor = cursor_create(tri_size);
    bs_square.cursor = cursor_create(tri_size*0.5);
    events_setup();
    parent.css({height:size+"px", width:size+"px"});
    disable_select(parent);
    return public_methods();
  }

  function disable_select(target){
    $(target).css({"unselectable": "on","-moz-user-select": "none","-webkit-user-select": "none"});
  }

  function public_methods(){
    return {
      input: input,
      onchange: onchange,
      ondrag : ondrag,
      color : public_set_color,
      color_hsb : public_set_color_hsb
    };
  }

  // Sets a textfield for user input of hex color values
  // TODO don\'t clear the change callback
  // TODO allow a null target to unbind the input
  function input(target){
    change_callback = null;
    input_target = target;
    $(target).keyup(function(){
      if(this.value.match(/^#([0-9A-F]){3}$|^#([0-9A-F]){6}$/img)){
        set_color(this.value);
        update_color(true);
		run_onchange_event();
      }
    });
    set_color(target.value);
    update_color(true);

    return public_methods();
  }

  function onchange(callback){
    change_callback = callback;
    update_color(false);
    return public_methods();
  }

  function ondrag(start_callback, end_callback){
    drag_callbacks = [start_callback || function(){}, end_callback || function(){}];
    return public_methods();
  }

  function drag(e){
    var x, y, page;

    e.preventDefault(); // prevents scrolling on touch

    page = e.originalEvent.touches ? e.originalEvent.touches[0] : e;

    x = page.pageX - (parent.offset().left + center);
    y = page.pageY - (parent.offset().top + center);

    if(drag_target == hue_ring){
      set_hue_cursor(x,y);
      update_color();
      run_onchange_event();
      return true;
    }
    if(drag_target == bs_square){
      set_bs_cursor(x,y);
      update_color();
      run_onchange_event();
      return true;
    }
  }

  function start_drag(event, target){
    event.preventDefault(); // prevents scrolling on touch

    $(document).on(\'mouseup touchend\',stop_drag);
    $(document).on(\'mousemove touchmove\',drag);
    drag_target = target;
    drag(event);
    drag_callbacks[0](current_color);
  }

  function stop_drag(event){
    event.preventDefault(); // prevents scrolling on touch

    $(document).off("mouseup touchend",stop_drag);
    $(document).off("mousemove touchmove",drag);
    drag_callbacks[1](current_color);
    run_onchange_event();
  }

  function events_setup(){
    $([hue_ring.event.node,hue_ring.cursor[0].node]).on("mousedown touchstart",
                                                        function(e){start_drag(e,hue_ring);});
    $([bs_square.b.node, bs_square.cursor[0].node]).on("mousedown touchstart",
                                                       function(e){start_drag(e,bs_square);});
  }

  function cursor_create(size){
    var set = canvas.set().push(
        canvas.circle(0, 0, size).attr({"stroke-width":4, stroke:"#333"}),
        canvas.circle(0, 0, size+2).attr({"stroke-width":1, stroke:"#FFF", opacity:0.5})
    );

    set[0].node.style.cursor = "crosshair";

    return set;
  }

  function set_bs_cursor(x,y){
    x = x+center;
    y = y+center;
    if(x < sdim.x){x = sdim.x}
    if(x > sdim.x+sdim.l){x = sdim.x+sdim.l}
    if(y < sdim.y){y = sdim.y}
    if(y > sdim.y+sdim.l){y = sdim.y + sdim.l}

    bs_square.cursor.attr({cx:x, cy:y}).transform("t0,0");
  }


  function set_hue(color){
    var hex = Raphael.getRGB(color).hex;
    bs_square.h.attr("fill", hex);
  }

  function hue(){
    return Raphael.rgb2hsb(bs_square.h.attr("fill")).h;
  }

  function public_set_color(value){
    var ret = set_color(value, false);
    update_color(false);
    return ret;
  }

  function public_set_color_hsb(hsb){
    var ret = set_color(hsb, true);
    update_color(false);
    return ret;
  }

  function set_color(value, is_hsb){
    if(value === undefined){
        if(is_hsb){
            return current_color_hsb;
        } else {
            return current_color;
        }
    }

    var hsb, hex;
    if(is_hsb){
        hsb = value;
        // Allow v (value) instead of b (brightness), as v is sometimes
        // used by Raphael.
        if(hsb.b === undefined){ hsb.b = hsb.v; }
        var rgb = canvas.raphael.hsb2rgb(hsb.h, hsb.s, hsb.b);
        hex = rgb.hex;
    } else {
        hex = value;
        hsb = canvas.raphael.rgb2hsb(hex);
    }
    var temp = canvas.rect(1,1,1,1).attr({fill:hex});

    set_bs_cursor(
      (0-sdim.l/2) + (sdim.l*hsb.s),
      sdim.l/2 - (sdim.l*hsb.b));
    set_hue_cursor((360*(hsb.h))-90);
    temp.remove();
    return public_methods();
  }

  // Could optimize this method
  function update_color(dont_replace_input_value){
    var x = bs_square.cursor.items[0].attr("cx"),
        y = bs_square.cursor.items[0].attr("cy"),
        hsb = {
          b: 1-(y-sdim.y)/sdim.l,
          s: (x-sdim.x)/sdim.l,
          h: hue()
        };

    current_color_hsb = hsb;
    current_color = Raphael.hsb2rgb(hsb.h, hsb.s,hsb.b);

    if(input_target){
      var c = current_color.hex;
      if(dont_replace_input_value !== true) { input_target.value = c;}
       if(hsb.b < 0.5){
        $(input_target).css("color", "#FFF");
      } else {
        $(input_target).css("color", "#000");
      }
      input_target.style.background = c;
    }

  }

  // accepts either x,y or d (degrees)
  function set_hue_cursor(mixed_args){
    var d;
    if(arguments.length == 2){
      d = angle(arguments[0],arguments[1]);
    } else {
      d = arguments[0];
    }

    var x = Math.cos(radians(d)) * (center-tri_size-padding);
    var y = Math.sin(radians(d)) * (center-tri_size-padding);
    hue_ring.cursor.attr({cx:x+center, cy:y+center}).transform("t0,0");
    set_hue("hsb("+(d+90)/360+",1,1)");
  }

  function bs_square_dim(){
    if(sdim){ return sdim;}
    var s = size - (tri_size * 4);
    sdim = {
      x:(s/6)+tri_size*2+padding,
      y:(s/6)+tri_size*2+padding,
      l:(s * 2/3)-padding*2
    };
    return sdim;
  }

  function create_bs_square(){
    bs_square_dim();
    box = [sdim.x, sdim.y, sdim.l, sdim.l];

    bs_square.h = canvas.rect.apply(canvas, box).attr({
      stroke:"#EEE", gradient: "0-#FFF-#000", opacity:1});
    bs_square.s = canvas.rect.apply(canvas, box).attr({
      stroke:null, gradient: "0-#FFF-#FFF", opacity:0});
    bs_square.b = canvas.rect.apply(canvas, box).attr({
      stroke:null, gradient: "90-#000-#FFF", opacity:0});
    bs_square.b.node.style.cursor = "crosshair";
  }

  function hue_segement_shape(){
    var path = "M -@W 0 L @W 0 L @W @H L -@W @H z";
    return path.replace(/@H/img, tri_size*2).replace(/@W/img,tri_size);
  }

  function copy_segment(r, d, k){
    var n = r.clone();
    var hue = d*(255/k);

    var s = size/2,
      t = tri_size,
      p = padding;

    n.transform("t"+s+","+(s-t)+"r"+(360/k)*d+"t0,-"+(s-t-p)+"");

    n.attr({"stroke-width":0, fill:"hsb("+d*(1/k)+", 1, 0.85)"});
    hue_ring.hues.push(n);
  }

  function create_hue_ring(){
    var s = hue_segement_shape(),
        tri = canvas.path(s).attr({stroke:"rgba(0,0,0,0)"}).transform("t"+(size/2)+","+padding),
        k = segments; // # of segments to use to generate the hues

    hue_ring.hues = canvas.set();

    for(n=0; n<k; n++){ copy_segment(tri, n, k); }

    // IE needs a slight opacity to assign events
    hue_ring.event = canvas.circle(
      center,
      center,
      center-tri_size-padding).attr({"stroke-width":tri_size*2, opacity:0.01});

    hue_ring.outline = canvas.circle(
      center,
      center,
      center-tri_size-padding).attr({"stroke":"#000", "stroke-width":(tri_size*2)+3, opacity:0.1});
    hue_ring.outline.toBack();
    hue_ring.event.node.style.cursor = "crosshair";
  }

  function run_onchange_event(){
    if (({}).toString.call(change_callback).match(/function/i)){
      change_callback(current_color);
    }
  }

  return create(target, color_wheel_size);
};
			</script>';
			return $JS;
		}
		
		protected function ColorwheelCSS()
		{
			$CSS = '<style type="text/css" media="screen">
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


  </style>';
			return $CSS;
		}
		
		protected function ColorwheelSegments($size)
		{
			if($size >= 250)
			{
				$segments = 180;
			}
			elseif($size < 250 && $size > 150)
			{
				$segments = 100;
			}
			else
			{
				$segments = 60;
			}
			return $segments;
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
		$mediaimage = array("headhtml" => $headhtml, "imgdata" => $imgdata, "mimetype" => $mimetype);
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
		
		protected function getimageinfo($imagefile)
		{				
			$imagesize = getimagesize($imagefile);
			$imagewidth = $imagesize[0];
			$imageheight = $imagesize[1];
			$imagetype = $imagesize[2];
			$imageinfo = array("imagewidth" => $imagewidth, "imageheight" => $imageheight, "imagetype" => $imagetype);
			return $imageinfo;
		}
	
		protected function createimage($imagefile, $imagetype)
		{
			switch ($imagetype)
			{
				// Bedeutung von $imagetype:
				// 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM
				case 1: // GIF
					$image = imagecreatefromgif($imagefile);
					break;
				case 2: // JPEG
					$image = imagecreatefromjpeg($imagefile);
					break;
				case 3: // PNG
					$image = imagecreatefrompng($imagefile);
					//imagealphablending($image, true); // setting alpha blending on
					//imagesavealpha($image, true); // save alphablending setting (important)
					break;
				default:
					die('Unsupported imageformat');
			}
			return $image;
		}
  
		protected function createthumbnail($mediaimgwidth, $mediaimgheight, $imagewidth, $imageheight)
		{
			// Maximalausmaße
			$maxthumbwidth = $mediaimgwidth;
			$maxthumbheight = $mediaimgheight;
			// Ausmaße kopieren, wir gehen zuerst davon aus, dass das Bild schon Thumbnailgröße hat
			$thumbwidth = $imagewidth;
			$thumbheight = $imageheight;
			// Breite skalieren falls nötig
			if ($thumbwidth > $maxthumbwidth)
			{                                    
				$factor = $maxthumbwidth / $thumbwidth;
				$thumbwidth *= $factor;
				$thumbheight *= $factor;
			}
			// Höhe skalieren, falls nötig
			if ($thumbheight > $maxthumbheight)
			{
					$factor = $maxthumbheight / $thumbheight;
					$thumbwidth *= $factor;
					$thumbheight *= $factor;
			}
			// Vergrößern Breite
			if ($thumbwidth < $maxthumbwidth)
			{
				$factor = $maxthumbheight / $thumbheight;
				$thumbwidth *= $factor;
				$thumbheight *= $factor;
			}
			//vergrößern Höhe
			if ($thumbheight < $maxthumbheight)
			{
					$factor = $maxthumbheight / $thumbheight;
					$thumbwidth *= $factor;
					$thumbheight *= $factor;
			}

			// Thumbnail erstellen
			$thumbimg = imagecreatetruecolor($thumbwidth, $thumbheight);
			imagesavealpha($thumbimg, true);
			$trans_colour = imagecolorallocatealpha($thumbimg, 0, 0, 0, 127);
			imagefill($thumbimg, 0, 0, $trans_colour);
			$thumb = array("img" => $thumbimg, "width" => $thumbwidth, "height" => $thumbheight);
			return $thumb;
		}
  
		protected function copyimgtothumbnail($thumb, $image, $thumbwidth, $thumbheight, $imagewidth, $imageheight, $picturename)
		{
			imagecopyresampled(
				$thumb,
				$image,
				0, 0, 0, 0, // Startposition des Ausschnittes
				$thumbwidth, $thumbheight,
				$imagewidth, $imageheight
				);
			// In Datei speichern
			$thumbfile = IPS_GetKernelDir()."media".DIRECTORY_SEPARATOR."resampled_".$picturename."_temp.png";  // Image-Datei
			imagepng($thumb, $thumbfile);
			imagedestroy($thumb);
			$tumbimagepath = "media".DIRECTORY_SEPARATOR."resampled_".$picturename."_temp.png";  // Image-Datei
			return $tumbimagepath;
		}
		
		private function CreateWebHookScript()
		{
        $Script = '<?
//Do not delete or modify.
Webbox_ProcessHookDataOLD('.$this->InstanceID.');		
?>';	
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
		
		
		
		public function ProcessHookDataOLD()
		{
			$this->ProcessHookData();
		}
		
		/**
		* This function will be called by the hook control. Visibility should be protected!
		*/
			
		protected function ProcessHookData()
		{
			/*
			$root = realpath(__DIR__ . "/www");
			
			//append index.html
			if(substr($_SERVER['REQUEST_URI'], -1) == "/") {
				$_SERVER['REQUEST_URI'] .= "index.html";
			}
			
			//reduce any relative paths. this also checks for file existance
			$path = realpath($root . "/" . substr($_SERVER['REQUEST_URI'], strlen("/hook/hookserve/")));
			if($path === false) {
				http_response_code(404);
				die("File not found!");
			}
			
			if(substr($path, 0, strlen($root)) != $root) {
				http_response_code(403);
				die("Security issue. Cannot leave root folder!");
			}
			header("Content-Type: ".$this->GetMimeType(pathinfo($path, PATHINFO_EXTENSION)));
			readfile($path);
			*/
			
			$webhookusername = $this->ReadPropertyString('webhookusername');
			$webhookpassword = $this->ReadPropertyString('webhookpassword');
			if(!isset($_SERVER['PHP_AUTH_USER']))
			$_SERVER['PHP_AUTH_USER'] = "";
			if(!isset($_SERVER['PHP_AUTH_PW']))
				$_SERVER['PHP_AUTH_PW'] = "";
			 
			if(($_SERVER['PHP_AUTH_USER'] != $webhookusername) || ($_SERVER['PHP_AUTH_PW'] != $webhookpassword)) {
				header('WWW-Authenticate: Basic Realm="Webbox WebHook"');
				header('HTTP/1.0 401 Unauthorized');
				echo "Authorization required";
				return;
			}
			//echo "Webhook Webbox IP-Symcon 4";
			if(isset($_SERVER['HTTPS']))
			{
				$isHttps = (!empty($_SERVER['HTTPS']));
				$this->SendDebug("Server[HTTPS]", "HTTPS >".$isHttps."<", 0);
			}

			//workaround for bug
			if(!isset($_IPS))
				global $_IPS;
			if($_IPS['SENDER'] == "Execute")
				{
				echo "This script cannot be used this way.";
				return;
				}
			
			// Webbox nutzt GET
			if (isset($_GET["type"]))
				{
				$type = $_GET["type"];
				if (isset($_GET["objectid"]))
					{
						$objectid = $_GET["objectid"];
					}
				else{
						return "no object id found";
					}	
				if ($type == "htmlbox")
					{
						$host = $_SERVER['HTTP_HOST'];
						$this->SendDebug("Server[HTTPS]", "HTTPS ".$_SERVER['HTTPS'], 0);
						$uri = "http://".$host;
						$HTMLPage = $this->HTMLBox($objectid, $uri);
						echo $HTMLPage;
						//return $HTMLPage;
					}
				elseif ($type == "mediaimage")
					{
						if (isset($_GET["size"]))
						{
							$size = $_GET["size"];
						}
						else
						{
							$size = null;
						}
						$mediaimage = $this->MediaImage($objectid);
						$headhtml = $mediaimage["headhtml"];
						$imgdata = $mediaimage["imgdata"];
						header($headhtml);
						echo $imgdata;
						//return $imgdata;
					}
				elseif ($type == "wunderground")
					{
						if (isset($_GET["weather"]))
						{
							$weathertype = $_GET["weather"];
						}
						$mediaimage = $this->WundergroundWeather($objectid, $weathertype);
						/*
						$headhtml = $mediaimage["headhtml"];
						$imgdata = $mediaimage["imgdata"];
						header($headhtml);
						echo $imgdata;
						*/
						//return $imgdata;
					}	
				elseif ($type == "cover")
					{
						$imgobjectid = $objectid; 
						if (isset($_GET["size"]))
						{
							$size = $_GET["size"];
						}
						if (isset($_GET["detailobjectid"]))
						{
							$objectid = $_GET["detailobjectid"];
						}
						$Cover = $this->Cover($imgobjectid, $size, $detailobjectid);
						echo $Cover;
						//return $Cover;
					}
				elseif ($type == "colorwheel")
					{
						/*
						if (isset($_GET["size"]))
						{
							$objectid = $_GET["size"];
						}
						if (isset($_GET["detailobjectid"]))
						{
							$objectid = $_GET["detailobjectid"];
						}
						$Cover = $this->Cover($imgobjectid, $size, $detailobjectid);
						return $Cover;
						*/
						$root = realpath(__DIR__ . "/www/Colorwheel");
			
						//append colorwheel.php
						if(substr($_SERVER['REQUEST_URI'], -16) == "?type=colorwheel")
						{
							$uri = substr($_SERVER['REQUEST_URI'], 0, -(strlen("?type=colorwheel")));
							$uri .= "/colorwheel.html";
						}
						
						//reduce any relative paths. this also checks for file existance
						$path = realpath($root . "/" . substr($uri, 39));
						$path = "/var/lib/symcon/modules/ipsymconwebbox/Webbox/www/Colorwheel/colorwheel.html";
						IPS_LogMessage("Webbox", "Pfad : ".$path);
						if($path === false)
						{
							http_response_code(404);
							die("File not found!");
						}
						/*
						if(substr($path, 0, strlen($root)) != $root) {
							http_response_code(403);
							die("Security issue. Cannot leave root folder!");
						}
						*/
						header("Content-Type: ".$this->GetMimeType(pathinfo($path, PATHINFO_EXTENSION)));
						readfile($path);
					}	
				}
		}
		
				
		private function GetMimeType($extension)
		{
			$lines = file(IPS_GetKernelDirEx()."mime.types");
			foreach($lines as $line)
			{
				$type = explode("\t", $line, 2);
				if(sizeof($type) == 2)
				{
					$types = explode(" ", trim($type[1]));
					foreach($types as $ext)
					{
						if($ext == $extension)
						{
							return $type[0];
						}
					}
				}
			}	
			return "text/html";
			//return "text/plain";
		}
		
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
