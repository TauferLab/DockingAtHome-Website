<?php
	if(isset($_GET["target"])) $target=$_GET["target"];
	else $target='1hvi';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="Target, Ligand, Docking@Home" />
    <meta name="description" content="A Docking@Home target." />
	<title>Welcome to Docking@Home!</title>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/head.php"); ?>
</head>

<body>
	<div id="content">
		<p style="text-align:center">
        	<img src="img/<?php $target ?>.gif" alt="<?php $target ?>" />
            <br />
            <b>Ligand <?php $target ?></b>
            <br />
            <a href="javascript:self.close()">Close this Window</a>
        </p>
	</div>
</body>
</html>

