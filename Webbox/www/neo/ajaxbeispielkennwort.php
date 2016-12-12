<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Unbenanntes Dokument</title>
<link href="css/dreambox.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>

</head>

<body>
<script type="text/javascript">
function testekennwortqualitaet(inhalt)
{
    if (inhalt=="")
    {
        document.getElementById("sicherheitshinweise").innerHTML="keine Eingabe da";
        return;
    }
    if (window.XMLHttpRequest)
    {
        // AJAX nutzen mit IE7+, Chrome, Firefox, Safari, Opera
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // AJAX mit IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("sicherheitshinweise").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","kennwortserverajax.php?q="+inhalt,true);
    xmlhttp.send();
}
</script>
<input type="password" size="10" value="" 
onchange="testekennwortqualitaet(this.value)" />
<span id="sicherheitshinweise">hier kommt dann der AJAX-Inhalt</span>
</body>
</html>