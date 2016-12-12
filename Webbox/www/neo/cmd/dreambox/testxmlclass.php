<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default.js" type="text/javascript"></script>
<script>var __adobewebfontsappname__="dreamweaver"</script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.--><?PHP
include "class.xmlresponse.php";

  $retval = "output of PHP script";

  $xml = new xmlResponse();
  $xml->start();

  $xml->command("setstyle",
    array("target" => "output", "property" => "display", "value" => "block")
  );

  $xml->command("setcontent", 
    array("target" => "samplecode"), 
    array("content" => htmlentities($retval))
  );

  $xml->end();
  ?>