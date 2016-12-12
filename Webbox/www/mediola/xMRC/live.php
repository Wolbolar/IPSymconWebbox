<html>
<head>
<title>Screenshot</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="1">
<style type="text/css">
a {
	display: block;
	width: 100%;
	height: 100%;
}
body {
	font-family: Arial;
	color: #c0c0c0;
}
td {
	padding: 10px 0 0 10px;
}
</style>
</head>

<body style="margin: 0; padding: 0; overflow: hidden; background-color: #000000;" onload="counddownit(1,2,3);">
<?
$start = microtime(1);

print '<a href="">';

if (strstr(basename($_SERVER['HTTP_REFERER']), 'live.php')) {

	exec("echo -n '*' > /tmp/ir");
	usleep(300000);

	$nowstatus = @file_get_contents('/tmp/nowstatus');
	$line = explode("\n", $nowstatus);

	$status = $line[0];
	$type = $line[1];
	$file = $line[2];
	$time = $line[5];

	if ($type <> 'Video') {

		$file_model = @file('/tmp/model');
		$model = trim($file_model[0]);

		if ( ($model == '') OR ($model == 'PRODIGY') ) {
			$wwwroot = 'tmp';
			if (!file_exists('/'.$wwwroot.'/nfs')) @mkdir('/'.$wwwroot.'/nfs');
		}
		else { // for Prodigy
			$wwwroot = 'sbin';
		}

		// create screenshot
		@exec("echo -n ',' > /tmp/ir");

		if ( ($model == '') OR ($model == 'PRODIGY') ) {
			@exec("sleep 1 && cp `ls -lt /tmp/nfs/ScrCap*.bmp | awk 'NR==1{print $9}'` /tmp/www/screenshot.bmp");
		}

		// path to bmp2jpg
		$pathConverter = str_replace(basename($_SERVER['SCRIPT_FILENAME']), "", $_SERVER['SCRIPT_FILENAME']).'bin/bmp2jpg';

		$bmpFile = '/'.$wwwroot.'/www/screenshot.bmp';
		$jpgFile = '/'.$wwwroot.'/www/xmrc/cache/screenshot_'.strval($start).'.jpg';

		// convert bmp to jpg and display it
		@exec('rm /'.$wwwroot.'/www/xmrc/cache/screenshot_*');
		@exec($pathConverter. ' -q '.$_GET['q'].' '.$bmpFile.' '.$jpgFile);
		print '<img src="/xmrc/cache/screenshot_'.strval($start).'.jpg" width="'.$_GET['w'].'" height="'.$_GET['h'].'" border="0">';

		// using direct bmp
		//print '<a href=""><img src="/screenshot.bmp" width="'.$_GET['w'].'" height="'.$_GET['h'].'" border="0"></a>';

	}
	else {
		print '<table border="0" cellpadding="0" cellspacing="0"><tr><td>'.$type.':</td><td>'.basename($file).'</td></tr><tr><td>Time:</td><td>'.str_replace("/", " / ", $time).'</td></tr></table></a>';
	}
}

print '</a>';

$end = microtime(1);


?>
</body>
</html>