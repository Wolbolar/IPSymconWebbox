<?

/**
 * xMRC - Mobile Remote Control & More for Xtreamer
 */

class xMRC {

	var $version;

	var $settings_skin;
	var $settings;

	var $host;
	var $device;
	var $device_id;
	var $model;

	var $wwwroot;

	var $mount_extists;

	function __construct() {

		//error_reporting(NONE);

		// read settings of main application and active skin
		$this->settings = parse_ini_file('settings.ini', true);
		$this->settings_skin = parse_ini_file('skins/'.$this->settings['general']['skin'].'/settings.ini', true);

		// version
		$this->version = $this->settings['general']['version'];

		// Xtreamermodel
		$model = @file('/tmp/model');
		$this->model = trim($model[0]);

		// device id
		$this->host = @shell_exec('hostname');
		$this->device = $_SERVER['HTTP_USER_AGENT'];
		$this->device_id = md5($this->model." ".$this->host." ".$_SERVER['HTTP_USER_AGENT']);

		// set www root path depending on model
		if ( ($this->model <> '') && ($this->model <> 'PRODIGY') ) {
			$this->wwwroot = 'sbin';
		}
		else {
			$this->wwwroot = 'tmp';
		}


		// if xMRC settings have been changed
		if (isset($_POST['sent'])) {
			$this->checkSettings();
		}

		// check if device skin lock exists, if yes, ignore skin selection from settings.ini
		$path_token = pathinfo($_SERVER['SCRIPT_FILENAME']);
		$skinlock = $path_token['dirname'].'/cache/'.$this->device_id;

		if (file_exists($skinlock)) {
			$this->settings['general']['skin'] = @file_get_contents($skinlock);
		}

		// load html header and set version
		$header = @file_get_contents('skins/'.$this->settings['general']['skin'].'/header.html');
		$header = str_replace("{VERSION}", $this->version, $header);

		// set stylesheet, load stylesheet from skin to overrule default stylesheet if needed
		$stylesheet_array = explode(",", $this->settings_skin['general']['stylesheet']);
		$stylesheet = '';
		foreach ($stylesheet_array as $key => $value) {
			$stylesheet .= '<link rel="stylesheet" type="text/css" href="skins/'.$this->settings['general']['skin'].'/'.trim($value).'" />';
			$stylesheet .= "";
		}
		$header = str_replace("{CSS}", "<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet.css\" />".$stylesheet, $header);

		// set javascript
		$javascript_array = explode(",", $this->settings_skin['general']['javascript']);
		$javascript = '';
		foreach ($javascript_array as $key => $value) {
			$javascript .= '<script type="text/javascript" src="skins/'.$this->settings['general']['skin'].'/'.trim($value).'"></script>';
			$javascript .= "";
		}
		$header = str_replace("{JS}", "<script type=\"text/javascript\" src=\"javascript.js\"></script>".$javascript, $header);

		// output header
		print $header.'<div id="outer">';

		// create cache dirs (for screenshot & playlists)
		if (!file_exists('/'.$this->wwwroot.'/www/xmrc')) @mkdir('/'.$this->wwwroot.'/www/xmrc');
		if (!file_exists('/'.$this->wwwroot.'/www/xmrc/cache')) @mkdir('/'.$this->wwwroot.'/www/xmrc/cache');

		// if needed, refresh the network shares list, this should only be run once when network shares are empty
		switch ($_GET['action']) {
			case 'mountnetshares':
				$this->mountNetshares();
				break;
		}

		// show info, settings, play file or list directory
		if (isset($_GET['view'])) {
			switch ($_GET['view']) {
				case 'favorites':
					$this->showFavorites();
					break;
				case 'shoutcast':
					$this->showShoutcast();
					break;
				case 'remotecontrol':
					$this->showRemote($_GET['page'], $this->settings['general']['autorefresh']);
					break;
				case 'screenshot':
					$this->showScreenshot();
					break;
				case 'settings':
					$this->showSettings();
					break;
				case 'about':
					$this->showAbout();
					break;
				default:
					$this->playFile($_GET['path'], $_GET['view']);
					break;
			}
		}
		else {
			if (isset($_GET['path'])) {
				$this->showList($_GET['path']);
			}
			else {
				$this->showHome();
			}
		}

		// load html footer
		$footer = @file_get_contents('skins/'.$this->settings['general']['skin'].'/footer.html');
		print '</div><div id="bottom"></div>'.$footer;

	} // end __construct()

	/**
 * write config
 *
 */
	function writeConfig(array $settings, $file) {

		$output = '';

		foreach ($settings as $category => $keys) {
			$output .= "[".$category."]\r\n";
			foreach ($keys as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $k => $v) {
						$output .= $key[$k]." = ".$v."\r\n";
					}
				}
				else
				$output .= $key." = ".$value."\r\n";
			}
			$output .= "\r\n";
		}
		@file_put_contents($file, trim($output));
		unset($output);
	}

	/**
 * strips backslashes from paths coz a single stripcslashes doesn't always work, why?
 *
 */
	function stripPath(&$path) {
		while (strstr($path, "\\")) {
			$path = stripcslashes($path);
		}
		return $path;
	}

	/**
 * show HOME, this is the entrypoint of xMRC
 *
 */
	function showHome() {

		// header
		print '<div id="header">
		<div id="logo">
			<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
		</div>
		<div id="logo_title">
			<a href="?view=about"><img src="skins/'.$this->settings['general']['skin'].'/images/logo_title.png"></a>
		</div>
		<div id="host">'.$this->host.'</div>
			<div style="clear: both;"></div>
		</div>
		
		<div id="home">
			<ul>';

		// Favorites
		if ( ($this->model <> '') && ($this->model <> 'PRODIGY') )
		print '<li><a href="?view=favorites" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_favorites.png" align="left" class="icon"> Favorites<br /><small>Access your favorites directly.</small></a></li>';

		// USB / HDD
		print '<li><a href="?path=/tmp/usbmounts" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_usbhdd.png" align="left" class="icon"> USB / HDD<br /><small>Browse files on local storage.</small></a></li>';

		// Network Shares
		if ( ($this->model <> '') && ($this->model <> 'PRODIGY') )
		print '<li><a href="?path=/tmp/myshare" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_networkshares.png" align="left" class="icon"> Network Shares<br /><small>Browse files on your local network.</small></a></li>';

		// SHOUTcast
		print '<li><a href="?view=shoutcast" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_shoutcast.png" align="left" class="icon"> SHOUTcast&trade;<br /><small>Play thousands of radio stations.</small></a></li>';

		// Remote Control
		print '<li><a href="?view=remotecontrol" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_remotecontrol.png" align="left" class="icon"> Remote Control<br /><small>Control your Xtreamer.</small></a></li>';

		// Screenshots
		print '<li><a href="?view=screenshot" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_screenshots.png" align="left" class="icon"> Screenshots<br /><small>Take live GUI screenshots.</small></a></li>';

		// Settings
		print '<li><a href="?view=settings" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_settings.png" align="left" class="icon"> Settings<br /><small>Configure xMRC options.</small></a></li>';

		print '</ul>
		</div>';
	}

	/**
 * show top navigation bar
 *
 */
	function showFolderNavi($path) {

		$path_token = pathinfo($path);

		print '<div id="header">';
		if (($path <> '/tmp/usbmounts') && ($path <> '/tmp/myshare') && ($path <> '')) {

			print '<div id="logo">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
			</div>
			<div id="logo_title">
				<a href="?path='.$path_token['dirname'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/button_back.png"></a>
			</div>
			<div id="host">'.$this->host.'</div>
				<div style="clear: both;"></div>
			</div>';
		}
		elseif ($path == '/tmp/usbmounts') {

			print '<div id="logo">
<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
</div>
<div id="logo_title">
<a href="'.$_SERVER['SCRIPT_NAME'].'?view=about"><img src="skins/'.$this->settings['general']['skin'].'/images/logo_title.png"></a>
</div>
<div id="host">'.$this->host.'</div>
<div style="clear: both;"></div>
</div>';
		}
		elseif ($path == '/tmp/myshare') {

			print '<div id="logo">
<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
</div>
<div id="logo_title">
<a href="'.$_SERVER['SCRIPT_NAME'].'?path='.$path.'&action=mountnetshares"><img src="skins/'.$this->settings['general']['skin'].'/images/button_refresh.png"></a>
</div>
<div id="host">'.$this->host.'</div>
<div style="clear: both;"></div>
</div>';
		}
		else {
			print '<div id="logo">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
			</div>
			<div id="logo_title">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/button_back.png"></a>
			</div>
			<div id="host">'.$this->host.'</div>
			<div style="clear: both;"></div>';
		}
		print '</div>';
	}

	/**
 * scan the /tmp/myshare/.cmd directory for mount scripts and execute them if they don't exist yet
 * 
 */
	function mountNetshares() {
		exec('/usr/bin/netshortcut');
		$handle = opendir('/tmp/myshare/.cmd');
		while ($file = readdir($handle)) {
			if ((!is_dir($file)) && ($file != '.') && ($file != '..')) {
				@exec('/tmp/myshare/.cmd/'.addcslashes($file, '() '));
			}
		}
	}

	// Modified by emklap
	/**
 * scan the /usr/local/etc/NetShareSave directory for mount scripts and execute them if they don't exist yet
 * 
*/
	/*
	function mountNetshares() {
	$this->mount_extists = "0";
	$handle = opendir('/tmp/myshare');
	while ($file = readdir($handle)) {
	if (($file != 'share.list')&& ($file != '.cmd') && ($file != '.') && ($file != '..'))  {
	$this->mount_extists = "1";
	break;  //skip if mounts already exist
	}
	}
	if ($this->mount_extists == "0") {
	exec('/usr/bin/netshortcut');
	$handle = opendir('/usr/local/etc/NetShareSave');
	while ($file = readdir($handle)) {
	if ((!is_dir($file)) && ($file != '.') && ($file != '..')) {
	$entries=file('/usr/local/etc/NetShareSave/'.$file);
	foreach ($entries AS $key => $value) {
	$type = substr($value, 0, 1);
	if ( $type != '#') {
	shell_exec($value);
	}
	}
	}
	}
	}
	}
	*/
	// End modification by emklap


	/**
 * shows a  list of folders/files in the current path, all folders are shown first, then files
 *
 */
	function showList($path) {
		$this->stripPath($path);

		$this->showFolderNavi($path);

		$audio = explode(",", $this->settings['extensions']['audio']);
		$image = explode(",", $this->settings['extensions']['image']);
		$video = explode(",", $this->settings['extensions']['video']);

		// mount My_Shortcuts into Network Shares section
		if ($path == '/tmp/myshare') {
			if ($this->settings['general']['myshortcuts'] == 1) {
				$this->mountMyShortcuts();
			}
		}

		print '<div id="showlist"><ul>';

		$handle = @opendir($path);

		while ($file = @readdir($handle)) {

			// folders
			if ((is_dir($path.'/'.$file)) && ($file != '.') && ($file != '..')) {

				// check if folder is in exception list
				$show = 1;
				$exceptions = explode(",", $this->settings['general']['exceptions']);
				foreach ($exceptions AS $key => $value) {
					if ($file == trim($value)) $show = 0; // match exact
					//if (strstr($file, trim($value))) $show = 0; // match partially
				}
				if ($show) {
					if (substr($file, 0, 1) == '.') {
						if ($this->settings['general']['showhidden']) {
							$folders[] = $file;
						}
					}
					else {
						$folders[] = $file;

						// show extra information for movie? cover + some meta tags
						if ($this->settings['general']['metainfo']) {

							if (file_exists($path.'/'.$file.'/folder.jpg')) {
								$cover[] = 'cache/images/'.md5($path.'/'.$file).'.jpg';

								// generate small sized thumbnails for faster directory listing

								if (!file_exists('cache/images/'.md5($path.'/'.$file).'.jpg')) {
									$src_img = imagecreatefromjpeg($path.'/'.$file.'/folder.jpg');
									$dst_img = imagecreatetruecolor(40, 60);

									imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, 40, 60, imagesx($src_img), imagesy($src_img));
									imagejpeg($dst_img, 'cache/images/'.md5($path.'/'.$file).'.jpg', 75);
								}

							} else {
								$cover[] = 'clear.png';
							}

							if ( (file_exists($path.'/'.$file.'/movie.nfo')) OR (file_exists($path.'/'.$file.'/tvshow.nfo')) ) {
								$metainfo[] = 1;
							} else {
								$metainfo[] = 0;
							}
						}
						else {
							$metainfo[] = 0;
						}
					}
				}
			}

			// files
			elseif (($file != '.') && ($file != '..')) {

				$extension = strtolower(substr(strrchr($file, '.'), 1));

				if ( (in_array($extension, $audio)) OR (in_array($extension, $image)) OR (in_array($extension, $video)) ) {

					// check if file is in exception list
					$show = 1;
					$exceptions = explode(",", $this->settings['general']['exceptions']);
					foreach ($exceptions AS $key => $value) {
						if ($file == trim($value)) $show = 0;
						//if (strstr($file, trim($value))) $show = 0;
					}
					if ($show) {
						if (substr($file, 0, 1) == '.') {
							if ($this->showhidden) {
								$files[] = $file;
							}
						}
						else {
							$files[] = $file;
						}
					}
				}

				// determine which "play folder" buttons to show
				if (in_array($extension, $audio)) {
					$showplayaudio = 1;
				}
				elseif (in_array($extension, $image)) {
					$showplayphoto = 1;
				}
				elseif (in_array($extension, $video)) {
					$showplayvideo = 1;
				}

			}
		}

		if (!empty($folders)) {
			sort($folders);
			foreach ($folders AS $key => $value) {

				if ($path == '/tmp/usbmounts') {
					$volumes = shell_exec("ls -l /tmp/ramfs/volumes/|grep ".$path.'/'.$value);
					sscanf($volumes,"%s %s %s %s %s %s %s %s %s", $a, $b, $c, $d, $e, $f, $g, $h, $drive);

					$label = file('/tmp/ramfs/labels/'.$drive);

					$displayName = preg_replace("/[^A-Za-z0-9\-\_\ ]/", "", $label[0]).' ('.$drive.')';
				}
				else {
					$displayName = $value;
				}

				$displayName = ($this->settings['general']['bracketfolders']?"[".$displayName."]":$displayName);

				if ($metainfo[$key]) {

					if (file_exists($path.'/'.$value.'/movie.nfo')) {
						$metainfo_xml = @simplexml_load_file($path.'/'.$value.'/movie.nfo');
						$metamode = 'movie';
					}
					elseif (file_exists($path.'/'.$value.'/tvshow.nfo')) {
						$metainfo_xml = @simplexml_load_file($path.'/'.$value.'/tvshow.nfo');
						$metamode = 'tvshow';
					}
					$runtime = $metainfo_xml->runtime;
					$genre = $metainfo_xml->genre;
					$rating = $metainfo_xml->rating;
					$year = $metainfo_xml->year;
					$country = $metainfo_xml->country;
					$studio = $metainfo_xml->studio;
					$width_stars = round($rating*10/2);

					switch ($metamode) {
						case 'movie':
							print '<li><a href="?path='.urlencode($path.'/'.$value).'" class="folder"><img src="'.$cover[$key].'" width="40" height="60" align="left" class="cover"> '.$displayName.'<br /><small>'.$genre.'<br /><div id="rating" style="width:'.$width_stars.'px;"><img src="clear.png"></div> ('.$rating.') | '.$runtime.' min | '.$year.' ('.$country.')</small></a></li>';
							break;
						case 'tvshow':
							print '<li><a href="?path='.urlencode($path.'/'.$value).'" class="folder"><img src="'.$cover[$key].'" width="40" height="60" align="left" class="cover"> '.$displayName.'<br /><small>'.$genre.'<br /><div id="rating" style="width:'.$width_stars.'px;"><img src="clear.png"></div> ('.$rating.') | '.$studio.'</small></a></li>';
							break;
					}
				} else {
					// still show cover even .nfo is not available but only when metainfo=1
					if ( ($this->settings['general']['metainfo']) && (file_exists('cache/images/'.md5($path.'/'.$value).'.jpg')) ) {
						print '<li><a href="?path='.urlencode($path.'/'.$value).'" class="folder"><img src="'.$cover[$key].'" align="left" class="cover"> '.$displayName.'</li>';
					} else {
						print '<li><a href="?path='.urlencode($path.'/'.$value).'" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_folder.png" align="left"> '.$displayName.'</a></li>';
					}

				}
			}
		}

		if (!empty($files)) {
			sort($files);
			foreach ($files AS $key => $value) {
				$extension = strtolower(substr(strrchr($value, '.'), 1));

				if (in_array($extension, $audio)) {
					$view = 'Audio';
				}
				elseif (in_array($extension, $image)) {
					$view = 'Photo';
				}
				elseif (in_array($extension, $video)) {
					$view = 'Video';
				}
				print '<li><a href="?path='.urlencode($path.'/'.$value).'&view='.$view.'"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_'.strtolower($view).'.png" align="left">'.$value.'</a></li>';
			}
		}

		@closedir($handle);

		print '</ul></div>';

		print '<div id="toolbar">';

		// play folder buttons
		if ($showplayvideo) {
			print '<a href="'.$_SERVER['SCRIPT_NAME'].'?path='.urlencode($path).'/&view=Video"><img src="skins/'.$this->settings['general']['skin'].'/images/button_video.png" title="Play video files in this folder" alt="Play video files in this folder"></a>';
		}
		if ($showplayaudio) {
			print '<a href="'.$_SERVER['SCRIPT_NAME'].'?path='.urlencode($path).'/&view=Audio"><img src="skins/'.$this->settings['general']['skin'].'/images/button_audio.png" title="Play audio files in this folder" alt="Play audio files in this folder"></a>';
		}
		if ($showplayphoto) {
			print '<a href="'.$_SERVER['SCRIPT_NAME'].'?path='.urlencode($path).'/&view=Photo"><img src="skins/'.$this->settings['general']['skin'].'/images/button_photo.png" title="Play image files in this folder" alt="Play image files in this folder"></a>';
		}

		print "</div>";
	}

	/**
 * takes a screenshots and saves it to the xMRC screenshots folder
 *
 */
	function showScreenshot() {

		// only take screenshot if camera button is pressed

		if (isset($_GET['shoot'])) {
			// for Prodigy
			if ( ($this->model == '') OR ($this->model == 'PRODIGY') ) {
				if (!file_exists('/'.$this->wwwroot.'/nfs')) @mkdir('/'.$this->wwwroot.'/nfs');
			}

			@exec("echo -n ',' > /tmp/ir");
			$filename = @date("Ymd_His", time()).'_xmrc.jpg';

			if ( ($this->model == '') OR ($this->model == 'PRODIGY') ) {
				@exec("sleep 1 && cp `ls -lt /tmp/nfs/ScrCap*.bmp | awk 'NR==1{print $9}'` /".$this->wwwroot."/www/screenshot.bmp");
			}

			$screenshot = '/'.$this->wwwroot.'/www/screenshot.bmp';

			@exec('bin/bmp2jpg -q 85 '.$screenshot.' screenshots/'.$filename);
		}

		print '<div id="header">
			<div id="logo">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png" title="Home" alt="Home"></a>
			</div>
			<div id="logo_title">
				<a href="'.$_SERVER['SCRIPT_NAME'].'?view=screenshot&shoot"><img src="skins/'.$this->settings['general']['skin'].'/images/button_camera.png" title="Take another screenshot" alt="Take another screenshot"></a>
			</div>
			<div id="host">'.$this->host.'</div>
			<div style="clear: both;"></div>
				<div id="screenshot">
					<ul>';

		$path_token = pathinfo($_SERVER['SCRIPT_FILENAME']);
		$handle = @opendir($path_token['dirname'].'/screenshots');

		while ($file = @readdir($handle)) {
			// files
			if (($file != '.') && ($file != '..') && (substr(strrchr($file, '.'), 1) == 'jpg')) {
				$files[] = $file;
			}
		}

		// newer files first
		if (count($files)) {
			krsort($files);

			foreach ($files AS $key => $value) {

				print '<li>';

				if ($this->settings['general']['screenshots']) {
					print '<a href="'.$_SERVER['SCRIPT_NAME'].'?path='.str_replace("/".$this->wwwroot."/www/media/", "/tmp/usbmounts/", str_replace(basename($_SERVER['SCRIPT_FILENAME']), "", $_SERVER['SCRIPT_FILENAME'])).'screenshots/'.$value.'&view=Photo"><img src="screenshots/'.$value.'" width="100%"><br /><img src="skins/'.$this->settings['general']['skin'].'/images/icon_photo.png" align="left">'.$value;
				}
				else {
					print '<a href="'.$_SERVER['SCRIPT_NAME'].'?path='.str_replace("/".$this->wwwroot."/www/media/", "/tmp/usbmounts/", str_replace(basename($_SERVER['SCRIPT_FILENAME']), "", $_SERVER['SCRIPT_FILENAME'])).'screenshots/'.$value.'&view=Photo"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_photo.png" align="left">'.$value;
				}

				print ' <small>('.round(filesize('screenshots/'.$value)/(1024)).' kB)</small></a></li>';
			}
		}
		print '</ul></div></div>';
	}

	function showRemote($page) {

		print '<div id="header"><div id="logo">
							<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
							</div>
							<div id="logo_title">';

		// if remote control is coming from homepage, just show logo_title, else show back button to referer
		if (substr($_SERVER['HTTP_REFERER'], -strlen($_SERVER['SCRIPT_NAME'])) == $_SERVER['SCRIPT_NAME']) {
			print '<img src="skins/'.$this->settings['general']['skin'].'/images/logo_title.png">';
		}
		else {
			print '<a href="'.$_SERVER['HTTP_REFERER'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/button_back.png"></a>';
		}



		print '<div id="host">'.$this->host.'</div>
							</div>
							<div style="clear: both;"></div>
							</div>

							<div id="remotecontrol">

							<!-- <img src="skins/'.$this->settings['general']['skin'].'/images/'.(empty($page)?'remote':$page).'.png" /> -->';

		$path_token = pathinfo($_SERVER['SCRIPT_FILENAME']);

		$remote = @file_get_contents($path_token['dirname'].'/skins/'.$this->settings['general']['skin'].'/'.(empty($page)?'remote':$page).'.html');

		// enable autorefresh?
		if ($this->settings['general']['autorefresh']) {
			$remote = str_replace("{REFRESH}", "setTimeout('live.location.reload();', 1000);", $remote);
			$remote = str_replace("{REFRESH2}", "setTimeout('live2.location.reload();', 1000);", $remote);
		}
		else {
			$remote = str_replace("{REFRESH}", "", $remote);
			$remote = str_replace("{REFRESH2}", "", $remote);
		}
		print $remote;

		print '</div>';
		//print '<script type="text/javascript"> setTimeout(\'live.location.reload();\', 1000); setTimeout(\'live2.location.reload();\', 1000); </script>';
	}

	function playFile($path, $view) {
		if (substr($path, 0, 14) == '/tmp/usbmounts') {
			$volumes = shell_exec("ls -l /tmp/ramfs/volumes/|grep ".substr($path, 0 , 19));
			sscanf($volumes,"%s %s %s %s %s %s %s %s %s", $a, $b, $c, $d, $e, $f, $g, $h, $drive);
			$path = str_replace(substr($path, 0 , 19), $drive, $path);
		}

		$tmp = "/tmp/webrun";
		$handle = fopen($tmp, 'w');
		fwrite($handle, $view.' '.$this->stripPath($path));
		fclose($handle);

		$this->showRemote(NULL);

		@exec("echo -n '%' > /tmp/ir");
	}

	function showShoutcastHeader() {
		print '<form method="post" action="'.$_SERVER['SCRIPT_NAME'].'?view=shoutcast&mode=search">';

		if (!strstr($_SERVER['REQUEST_URI'], "genre=")) {
			$back = 'index.php';
			$showsearch = 1;
		}
		else {
			$back = '?view=shoutcast';
			$showsearch = 1;
		}

		if ($showsearch) {
			// search while typing
			print '<li><input type="text" name="search" value="Search..." onFocus="if (this.value == \'Search...\') this.value=\'\';" onBlur="if (this.value == \'\') this.value=\'Search...\';" onkeyup="showResult(this.value);"></li>';
			print '<div id="ls"></div>';
		}

		print '</form><div id="nonls">';
	}

	function showShoutcastList($mode, $search) {

		switch ($mode) {
			case 'search':
				if (isset($_GET['search'])) {
					$search = $_POST['search'];
				}
				$stations = @simplexml_load_file('http://files.mavvy.net/xtreamer/shoutcast/stationsearch.php?search='.$search);
				break;
			case 'genres':
				if (isset($_GET['genre'])) {
					$search = $_GET['genre'];
				}
				if ($_GET['genre'] == 'Top500') {
					$stations = @simplexml_load_file('http://files.mavvy.net/xtreamer/shoutcast/top500.php');
				}
				else {
					$stations = @simplexml_load_file('http://files.mavvy.net/xtreamer/shoutcast/genresearch.php?search='.$search);
				}
				break;
		}

		$this->showShoutcastHeader();

		if (count($stations->station) == 0) {
			$this->showShoutcastError();
		}
		else {

			for ($i = 0; $i < count($stations->station); $i++) {
				$station = $stations->station[$i]['name'];
				$id = $stations->station[$i]['id'];
				$br = $stations->station[$i]['br'];
				$ct = $stations->station[$i]['ct'];
				$lc = $stations->station[$i]['lc'];

				if ($br >= strval($this->settings['shoutcast']['minimum_bitrate'])) {
					print '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?view=shoutcast&station='.$id.'">'.str_replace("- a SHOUTcast.com member station", "", $station).'<br /><small>'.$ct.'<br />'.$br.' kbps | '.$lc.' listeners</small></a></li>';
				}
			}
		}
	}

	function showShoutcastStation() {

		switch ($this->model) {
			case '': // Prodigy
			$extension = '.pls';
			break;
			case 'PRODIGY': // Prodigy
			$extension = '.pls';
			break;
			default:
				$extension = '.plsx';
				break;
		}

		$path_token = pathinfo($_SERVER['SCRIPT_FILENAME']);
		$plsx = $path_token['dirname'].'/cache/'.$_GET['station'].$extension;
		$plsx = str_replace("/".$this->wwwroot."/www/media/", "/tmp/usbmounts/", $plsx);

		@file_put_contents($plsx, @file_get_contents('http://www.shoutcast.com/sbin/tunein-station.pls?id='.$_GET['station']));
		$this->playFile($plsx, 'Audio');
	}

	function showShoutcastError() {
		print '<li><a href="javascript:void(0);" onclick="javascript:window.location.reload();">Oops... SHOUTcast&trade; had hiccups.<br />Click here to send the request again.</li>';
	}

	function showShoutcastHome() {
		$this->showShoutcastHeader();

		// check if user wants complete genre list or just the primary genres
		switch ($this->settings['shoutcast']['genrelistmode'])
		{
			case 'all':
				$request = 'http://files.mavvy.net/xtreamer/shoutcast/genrelist.php'; // all genres
				break;
			case 'primary':
				$request = 'http://files.mavvy.net/xtreamer/shoutcast/primary.php'; // only the main genres
				break;
		}

		$xml = @file_get_contents($request);

		// here we need to use some kind of a cache, as SHOUTcast often returns an error
		$cache_genres = 'cache/xml/genres.xml';

		// if there is an error in the live genres.xml, take the one from cache (if it exists)
		if ( (strstr($xml, '<statusCode>450</statusCode>')) OR (strstr($xml, '<statusCode>500</statusCode>')) ) {
			if (@file_exists($cache_genres)) {
				$xml = @file_get_contents($cache_genres);
			}
			else {
				$this->showShoutcastError();
			}
		}
		else {
			// write the latest live genres.xml to cache
			@file_put_contents('cache/xml/genres.xml', $xml);
		}

		$genres = @simplexml_load_string($xml);

		print '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?view=shoutcast&genre=Top500" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_folder.png" align="left"> Top 500</a></li>';

		for ($i = 0; $i < count($genres->genre); $i++) {
			$genre = $genres->genre[$i]['name'];

			print '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?view=shoutcast&genre='.$genre.'" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_folder.png" align="left"> '.$genre.'</a></li>';
		}

	}

	function showShoutcast() {

		if (isset($_GET['station'])) {
			$this->showShoutcastStation();
		}
		else {

			print '<div id="header">
				<div id="logo">
					<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
				</div>
				<div id="logo_title">
					<a href="?view=shoutcast"><img src="skins/'.$this->settings['general']['skin'].'/images/logo_shoutcast.png"></a>
				</div>
				<div id="host">'.$this->host.'</div>
				<div style="clear: both;"></div>
			</div>';

			print '<div id="shoutcast"><ul>';
			if (isset($_GET['genre'])) {

				$this->showShoutcastList('genres', $_GET['genre']);
			}
			elseif (isset($_POST['search'])) {
				$this->showShoutcastList('search', $_POST['search']);
			}
			else {
				$this->showShoutcastHome();
			}
			print "</div>
		</ul>
	</div>";
		}
	}

	/**
 * some legal information
 *
 */
	function showAbout() {
		print '<div id="header">
			<div id="logo">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
			</div>
			<div id="logo_title">
				<img src="skins/'.$this->settings['general']['skin'].'/images/logo_title.png">
			</div>
			<div id="host">'.$this->host.'</div>
			<div style="clear: both;"></div>
		</div>

		<div id="about">
			<p><b>What is xMRC</b></p>
			<p>The Xtreamer Mobile RC will give you another user experience when controlling the Xtreamer Media Player remotely. While the official Xtreamer iPhone RC is simulating the real remote control with virtual buttons, this xMRC goes beyond the common style of controlling your media player and provides you a fully browsable structure of your media files on local or network storage attached to the Xtreamer instead. Of course there are virtual buttons too but they are only shown when they are needed which is when you start playing a media file, videos, music or photos.</p><p>Speaking of music, xMRC also features SHOUTcast&trade; Radio. You can browse and search a directory of live radio stations.</p>

			<p><b>What is SHOUTcast&trade; Radio</b></p>
			<p>The SHOUTcast&trade; Radio Directory is one of the largest directories of professionally and community programmed online radio stations in the world. Today SHOUTcast&trade; Radio features over 32,000 stations from around the globe. If you\'re into popular or indie music, or want to check out local or world programming, you\'re sure to  find something you like on SHOUTcast&trade; Radio.</p><p>SHOUTcast&trade; Radio also provides audio broadcasting software tools for those who want to create a radio station. It permits anyone on the internet to broadcast audio from their computer to listeners across the Internet or any other IP-based network (Office LANs, college campuses, etc...).</p>

			<p><b>Legal Notice</b></p>
			<p>xMRC is free to use. You are allowed to modify the source code to meet your personal needs. Releases of modified versions (source code must be open) are only allowed in the official Xtreamer forum.</p><p>Last but not least: thanks for using xMRC and special thanks to everyone who is helping to improve it!</p>
			<p>Enjoy<br />Mavvy</p>

			<p><b>Official Thread</b></p>
			<p><a href="http://forum.xtreamer.net/topic/23697-mobile-remote-control-for-xtreamer" target="_blank"">http://forum.xtreamer.net/topic/23697-mobile-remote-control-for-xtreamer</a></p>
		</div>';
	}

	function showFavorites() {

		print '<div id="header">
			<div id="logo">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
			</div>
			<div id="logo_title">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/button_back.png"></a>
			</div>
			<div id="host">'.$this->host.'</div>
			<div style="clear: both;"></div>
		</div>

		<div id="favorites">
			<ul>';


		// read favorites file
		if (file_exists('/usr/local/etc/.myshortcut')) {
			$entries = file('/usr/local/etc/.myshortcut');
		}
		else {
			print "<ul><li><a>You have no favorites set.</a></li></ul>";
			return;
		}

		foreach ($entries AS $key => $value) {

			$type = substr($value, 0, 2);
			$realname = substr($value, 2);
			$realname = str_replace("/tmp/ramfs/volumes/", "", $realname);
			$realname = str_replace("/tmp/eTrayz", "eTRAYz", $realname);
			$realname = trim(stripslashes((str_replace("/tmp/myshare/", "", $realname))));

			if (substr($realname, -1) == '/') {
				$realname = substr($realname, 0, -1);
			}

			if ( ($type == '01') OR ($type == '02') OR ($type == '09') ) {

				$volumes = shell_exec("ls -l /tmp/ramfs/volumes/|grep ".substr($realname, 0, 2));
				sscanf($volumes,"%s %s %s %s %s %s %s %s %s %s %s", $a, $b, $c, $d, $e, $f, $g, $h, $drive, $i, $virtualName);

				// get supported media formats into array
				$audio = explode(",", $this->settings['extensions']['audio']);
				$image = explode(",", $this->settings['extensions']['image']);
				$video = explode(",", $this->settings['extensions']['video']);

				$extension = substr($realname, stripos($realname, ".")+1, strlen($realname));

				if (in_array($extension, $audio)) {
					$favorites_net[] = '<li><a href="'.$this->scriptname.'?path='.urlencode($realname).'&view=Audio"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_audio.png" align="left"> '.$realname.'</a></li>';
				}
				elseif (in_array($extension, $video)) {
					$favorites_net[] = '<li><a href="'.$this->scriptname.'?path='.urlencode($realname).'&view=Video"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_video.png" align="left"> '.$realname.'</a></li>';
				}
				elseif (in_array($extension, $image)) {
					$favorites_net[] = '<li><a href="'.$this->scriptname.'?path='.urlencode($realname).'&view=Photo"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_photo.png" align="left"> '.$realname.'</a></li>';
				}
				else {
					$favorites_sata[] = '<li><a href="'.$this->scriptname.'?path='.urlencode(str_replace($drive, $virtualName, $realname)).'" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_folder.png" align="left"> '.$realname.'</a></li>';
				}
			}
			elseif ( ($type == '11') OR ($type == '12') ) {
				$pathAdd = trim (substr($value, 2));

				if (substr($pathAdd, -1) == '/') {
					$pathAdd = substr($pathAdd, 0, -1);
				}

				$favorites_net[] = '<li><a href="'.$this->scriptname.'?path='.urlencode($pathAdd).'" class="folder"><img src="skins/'.$this->settings['general']['skin'].'/images/icon_folder.png" align="left"> '.$realname.'</a></li>';
			}
		}

		if (!empty($favorites_sata)) {
			sort($favorites_sata);
			foreach ($favorites_sata AS $key => $value) {
				print $value;
			}
		}

		if (!empty($favorites_net)) {
			sort($favorites_net);
			foreach ($favorites_net AS $key => $value) {
				print $value;
			}
		}

		print '</ul>
</div>';
	}

	function showSettings() {

		// fix filepermissions for bmp2jpg if necessary
		if (substr(sprintf('%o', fileperms('bin/bmp2jpg')), -4) <> '0755') {
			@chmod('bin/bmp2jpg', 0755);
		}

		$dir_skins = str_replace("/".$this->wwwroot."/www/media/", "/tmp/usbmounts/", str_replace(basename($_SERVER['SCRIPT_FILENAME']), "", $_SERVER['SCRIPT_FILENAME'])).'skins';
		$handle = opendir($dir_skins);
		$skin = '';
		while ($file = readdir($handle)) {
			if ((!is_dir($file)) && ($file != '.') && ($file != '..')) {
				$settings_skin = parse_ini_file('skins/'.$file.'/settings.ini', true);
				$skin .= '<option value="'.$file.'"'.(($this->settings['general']['skin'] == $file)?' selected':'').'>'.$settings_skin['general']['name'].'</option>';
			}
		}

		print '<form name="settings" action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
		<input type="hidden" name="sent" value="1" />
		<div id="header">
			<div id="logo">
				<a href="'.$_SERVER['SCRIPT_NAME'].'"><img src="skins/'.$this->settings['general']['skin'].'/images/logo.png"></a>
			</div>
			<div id="logo_title">
				<input type="image" border="0" src="skins/'.$this->settings['general']['skin'].'/images/button_check.png">
			</div>
			<div id="host">'.$this->host.'</div>
			<div style="clear: both;"></div>
		</div>

		<div id="settings">

			<div id="section">
				<p><strong>Layout Settings</strong></p>
				<p>Skin:<br />
				<select name="skin">'.$skin.'</select><br />
				<small>Current skin by '.$this->settings_skin['general']['author'].'.</small></p>';

		$path_token = pathinfo($_SERVER['SCRIPT_FILENAME']);
		$skinlock = $path_token['dirname'].'/cache/'.$this->device_id;

		if (!file_exists($skinlock)) {
			print '<p>Enable skin lock on this device?<br />
				<select name="binddevice"><option value="1">Yes</option><option value="0" selected>No</option></select><br />
				<small>This locks the selected skin to this device.</small></p>';
		}
		else {
			print '<p>Current skin is locked. Remove lock?<br />
				<select name="releasedevice"><option value="1">Yes</option><option value="0" selected>No</option></select><br />
				<small>This removes the device specific skin lock.</small></p>';
		}

		print '<p>Show covers & meta tags in file browser:<br />
				<select name="metainfo"><option value="1"'.(($this->settings['general']['metainfo'] == 1)?' selected':'').'>Yes</option><option value="0"'.(($this->settings['general']['metainfo'] == 0)?' selected':'').'>No</option></select><br />
				<small>Shows covers, genres, etc. for movies etc.</small></p>
				
				<p>Refresh screenshot on button press:<br />
				<select name="autorefresh"><option value="1"'.(($this->settings['general']['autorefresh'] == 1)?' selected':'').'>Yes</option><option value="0"'.(($this->settings['general']['autorefresh'] == 0)?' selected':'').'>No</option></select><br />
				<small>Only for skins with integrated live screenshot.</small></p>

				<p>Show screenshots inline instead of list:<br />
				<select name="screenshots"><option value="1"'.(($this->settings['general']['screenshots'] == 1)?' selected':'').'>Yes</option><option value="0"'.(($this->settings['general']['screenshots'] == 0)?' selected':'').'>No</option></select><br />
				<small>Slow if you have lots screenshots.</small></p>
			
			</div>

			<div id="section">
				<p><strong>File Settings</strong></p>
				<p>Video extensions:<br />
				<textarea name="video">'.$this->settings['extensions']['video'].'</textarea></p>
				<p>Audio extensions:<br />
				<textarea name="audio">'.$this->settings['extensions']['audio'].'</textarea></p>
				<p>Image extensions:<br />
				<textarea name="image">'.$this->settings['extensions']['image'].'</textarea></p>

				<p>File browser exceptions:<br />
				<textarea name="exceptions">'.$this->settings['general']['exceptions'].'</textarea></p>

				<p>Show hidden folders / files:<br />
				<select name="showhidden"><option value="1"'.(($this->settings['general']['showhidden'] == 1)?' selected':'').'>Yes</option><option value="0"'.(($this->settings['general']['showhidden'] == 0)?' selected':'').'>No</option></select></p>

				<p>Put folder names in [brackets]:<br />
				<select name="bracketfolders"><option value="1"'.(($this->settings['general']['bracketfolders'] == 1)?' selected':'').'>Yes</option><option value="0"'.(($this->settings['general']['bracketfolders'] == 0)?' selected':'').'>No</option></select></p>
			</div>

			<div id="section">
				<p><strong>Network Settings</strong></p>
				<p>Mount My_Shortcuts in Network Shares:<br />
				<select name="myshortcuts"><option value="1"'.(($this->settings['general']['myshortcuts'] == 1)?' selected':'').'>Yes</option><option value="0"'.(($this->settings['general']['myshortcuts'] == 0)?' selected':'').'>No</option></select><br />
				<small>Experimental!</small></p>
			</div>

			<div id="section">
				<p><strong>SHOUTcast&trade; Settings</strong></p>
				<p>List genres:<br />
				<select name="genrelistmode"><option value="all"'.((strval($this->settings['shoutcast']['genrelistmode']) == 'all')?' selected':'').'>All</option><option value="primary"'.((strval($this->settings['shoutcast']['genrelistmode']) == 'primary')?' selected':'').'>Primary</option></select></p>
				<p>Minimum SHOUTcast&trade; stream bitrate:<br />
				<select name="minimum_bitrate"><option value="0"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 0)?' selected':'').'>0</option><option value="16"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 16)?' selected':'').'>16</option><option value="32"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 32)?' selected':'').'>32</option><option value="64"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 64)?' selected':'').'>64</option><option value="96"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 96)?' selected':'').'>96</option><option value="128"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 128)?' selected':'').'>128</option><option value="256"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 256)?' selected':'').'>256</option><option value="320"'.((strval($this->settings['shoutcast']['minimum_bitrate']) == 320)?' selected':'').'>320</option></select></p>
			</div>

			<div id="section">
				<p><strong>Device information</strong></p>
				<p>Model:<br />'.$this->model.'</p>
				<p>Hostname:<br />'.$this->host.'</p>
				<p>User Agent:<br />'.$this->device.'</p>
				<p>Device ID:<br />'.$this->device_id.'<br />
				(MD5 of Model+Hostname+User Agent)</p>
				<p>Viewport:<br /><script type="text/javascript"> document.write(screen.width + " x " + screen.height) </script></p>
			</div>

		</div>

		</form>';
	}

	function checkSettings() {
		$write_config = false;

		if ($this->settings['general']['device'] <> $_POST['device']) {
			$this->settings['general']['device'] = $_POST['device'];
			$write_config = true;
		}

		if ($this->settings['general']['skin'] <> $_POST['skin']) {
			$this->settings['general']['skin'] = $_POST['skin'];
			$write_config = true;
		}

		if ($this->settings['general']['metainfo'] <> $_POST['metainfo']) {
			$this->settings['general']['metainfo'] = $_POST['metainfo'];
			$write_config = true;
		}

		if ($this->settings['general']['autorefresh'] <> $_POST['autorefresh']) {
			$this->settings['general']['autorefresh'] = $_POST['autorefresh'];
			$write_config = true;
		}

		if ($this->settings['general']['screenshots'] <> $_POST['screenshots']) {
			$this->settings['general']['screenshots'] = $_POST['screenshots'];
			$write_config = true;
		}

		if ($this->settings['extensions']['video'] <> $_POST['video']) {
			$this->settings['extensions']['video'] = str_replace(" ", "", $_POST['video']);
			$write_config = true;
		}

		if ($this->settings['extensions']['audio'] <> $_POST['audio']) {
			$this->settings['extensions']['audio'] = str_replace(" ", "", $_POST['audio']);
			$write_config = true;
		}

		if ($this->settings['extensions']['image'] <> $_POST['image']) {
			$this->settings['extensions']['image'] = str_replace(" ", "", $_POST['image']);
			$write_config = true;
		}

		if ($this->settings['general']['myshortcuts'] <> $_POST['myshortcuts']) {
			$this->settings['general']['myshortcuts'] = $_POST['myshortcuts'];
			$write_config = true;
		}

		if ($this->settings['shoutcast']['genrelistmode'] <> $_POST['genrelistmode']) {
			$this->settings['shoutcast']['genrelistmode'] = $_POST['genrelistmode'];
			$write_config = true;
		}

		if ($this->settings['shoutcast']['minimum_bitrate'] <> $_POST['minimum_bitrate']) {
			$this->settings['shoutcast']['minimum_bitrate'] = $_POST['minimum_bitrate'];
			$write_config = true;
		}

		if ($this->settings['general']['exceptions'] <> $_POST['exceptions']) {
			$this->settings['general']['exceptions'] = $_POST['exceptions'];
			$write_config = true;
		}

		if ($this->settings['general']['showhidden'] <> $_POST['showhidden']) {
			$this->settings['general']['showhidden'] = $_POST['showhidden'];
			$write_config = true;
		}

		if ($this->settings['general']['bracketfolders'] <> $_POST['bracketfolders']) {
			$this->settings['general']['bracketfolders'] = $_POST['bracketfolders'];
			$write_config = true;
		}

		$path_token = pathinfo($_SERVER['SCRIPT_FILENAME']);
		$skinlock = $path_token['dirname'].'/cache/'.$this->device_id;

		if ($_POST['releasedevice'] == 1) {
			@unlink($skinlock);
		}

		if ($_POST['binddevice'] == 1) {
			@file_put_contents($skinlock, $_POST['skin']);
		}

		// save
		if ($write_config) $this->writeConfig($this->settings, 'settings.ini');

		unset ($_POST['sent']);

		unset ($write_config);
	}

	/**
 * reads current status of what Xtreamer is doing
 *
 */
	function showStatus() {

		exec("echo -n '*' > /tmp/ir");
		usleep(300000);

		$nowstatus = @file_get_contents('/tmp/nowstatus');
		$line = explode("\n", $nowstatus);

		$status = $line[0];
		$type = $line[1];
		$file = $line[2];
		$time = $line[5];
	}

	function mountMyShortcuts() {
		$myshortcuts = parse_ini_file('/usr/local/etc/dvdplayer/NetworkBrowser.ini', true);

		$i = 0;
		while ( ($myshortcuts[$i]['label'] <> '') && (!strstr($myshortcuts[$i]['label'], ':')) && ($myshortcuts[$i]['ip1'] <> '') && ($myshortcuts[$i]['ip2'] <> '') && ($myshortcuts[$i]['ip3'] <> '') && ($myshortcuts[$i]['ip4'] <> '') ) {

			$label = $myshortcuts[$i]['label'];

			$id = $myshortcuts[$i]['id'];
			$pw = $myshortcuts[$i]['pw'];

			$ip1 = $myshortcuts[$i]['ip1'];
			$ip2 = $myshortcuts[$i]['ip2'];
			$ip3 = $myshortcuts[$i]['ip3'];
			$ip4 = $myshortcuts[$i]['ip4'];

			$host = $ip1.".".$ip2.".".$ip3.".".$ip4;

			$login = '';
			if ($id <> '' OR $pw <> '') {
				$login = "username='".$id."',password='".$pw."',";
			}

			$login = "username='".$id."',password='".$pw."',";

			if (!file_exists('/tmp/myshare/'.$label)) {
				exec("mkdir -p '/tmp/myshare/".$label."'");
				exec("mount -t cifs '//".$host."/".$label."' '/tmp/myshare/".$label."' -o ".$login."iocharset=utf8,mapchars,soft");
			}

			/* // make Xtreamer see the mount too (not working yet, dunno why...)
			if (!file_exists('/tmp/myshare/.cmd/'.$label)) {
			$mount = "mkdir -p '/tmp/myshare/".$label."'\n";
			$mount .= "mount -t cifs '//".$host."/".$label."' '/tmp/myshare/".$label."' -o ".$login."iocharset=utf8,mapchars,soft";
			file_put_contents('/tmp/myshare/.cmd/'.$label, $mount);
			chmod('/tmp/myshare/.cmd/'.$label, 0777);
			// todo: add to share.list

			}
			*/


			$i++;
		}

	}

} // end class

$xmrc = new xMRC();
?>