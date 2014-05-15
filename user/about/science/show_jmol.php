<?php
	$file = $_GET["file"];
	
	if (!isset($file)) {
		echo "File not found!";
		exit;
	}
	$width = $_GET["jwidth"];
	if (!isset($width)) {
		$width = 400;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Jmol Viewer</title>
    <script src="/jmol/Jmol.js" type="text/javascript"></script>
</head>

<body>
	<script>
		jmolInitialize("/jmol");
        jmolSetAppletColor("white");
		<?php echo "jmolApplet(".$width.",\"load ".$file."\");"; ?>
    </script>
</body>
</html>
