<? 
$action = $_GET['action'];

switch ($action) {

	case 'info':
		exec("echo -n i > /tmp/ir");
		break;
	case 'search':
		$command=$_GET['string'];
		$fp=fopen('/tmp/netkey.data', 'w');
		fwrite($fp, $command);
		fclose($fp);
		exec("echo -n r > /tmp/ir");
		break;
	case 'return':
		exec("echo -n r > /tmp/ir");
		break;

	case 'audio':
		exec("echo -n AA > /tmp/ir");
		break;
	case 'subtitle':
		exec("echo -n T > /tmp/ir");
		break;
		
	case 'up':
		exec("echo -n k > /tmp/ir");
		break;
	case 'down':
		exec("echo -n j > /tmp/ir");
		break;
	case 'left':
		exec("echo -n h > /tmp/ir");
		break;
	case 'right':
		exec("echo -n l > /tmp/ir");
		break;
	case 'enter':
		exec("echo -n ' ' > /tmp/ir");
		break;
		
	case 'mute':
		exec("echo -n M > /tmp/ir");
		break;
	case 'ab':
		exec("echo -n '@' > /tmp/ir");
		break;
		
	case 'pgup':
		exec("echo -n '{' > /tmp/ir");
		break;
	case 'pgdn':
		exec("echo -n '}' > /tmp/ir");
		break;

	case 'rew':
		exec("echo -n '<' > /tmp/ir");
		break;
	case 'ff':
		exec("echo -n '>' > /tmp/ir");
		break;

	case 'play':
		exec("echo -n p > /tmp/ir");
		break;
	case 'stop':
		exec("echo -n S > /tmp/ir");
		break;

	case 'reboot':
		exec("reboot");
		break;
	case 'power':
		exec("echo -n O > /tmp/ir");
		break;
	case 'home':
		exec("echo -n '!' > /tmp/ir");
		break;

	case '1':
		exec("echo -n a > /tmp/ir");
		break;
	case '2':
		exec("echo -n e > /tmp/ir");
		break;
	case '3':
		exec("echo -n d > /tmp/ir");
		break;
	case '4':
		exec("echo -n z > /tmp/ir");
		break;
	case '5':
		exec("echo -n g > /tmp/ir");
		break;
	case '6':
		exec("echo -n m > /tmp/ir");
		break;
	case '7':
		exec("echo -n s > /tmp/ir");
		break;
	case '8':
		exec("echo -n f > /tmp/ir");
		break;
	case '9':
		exec("echo -n t > /tmp/ir");
		break;
	case '0':
		exec("echo -n v > /tmp/ir");
		break;

	case 'vol_up':
		exec("echo -n '+' > /tmp/ir");
		break;
	case 'vol_down':
		exec("echo -n '-' > /tmp/ir");
		break;
	case 'shuffle':
		exec('echo -n u > /tmp/ir');
		break;
	case 'repeat':
		exec("echo -n '&' > /tmp/ir");
		break;
	case 'sync_left':
		exec("echo -n '.' > /tmp/ir");
		break;
	case 'sync_right':
		exec("echo -n '/' > /tmp/ir");
		break;
}
?>