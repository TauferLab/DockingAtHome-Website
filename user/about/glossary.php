<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db_conn.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");

db_init();
$concept = get_str("concept",true);
if ($concept) {
	$concept = urldecode($concept);
	$qry = "SELECT concept, definition, url, ref FROM docking_glossary WHERE concept like '$concept'";
	
	$result = mysql_query($qry);
	if ($row = mysql_fetch_assoc($result)) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?= PROJECT ?> Concept: <?= $row['concept'] ?></title>
	<link rel="stylesheet" type="text/css" href="/includes/css/v2.css" media="all" />
</head>
<body style="background-color:#FFFFFF;width:500px;">
    <h3 class="title"><?= $row['concept'] ?></h3>
    <p><?= $row['definition'] ?></p>
    <p><a href="<?= $row['url'] ?>" target="_blank"><?= $row['url'] ?></a></p>
    <p><?= $row['ref'] ?></p>
</body>
</html>
<?
	}
	else {
		echo "Concept not found!";
	} 
}
else {
	display_page_top(PROJECT." Glossary");
	
	$qry = "SELECT id, concept, LEFT(concept, 1) AS first_char FROM docking_glossary WHERE UPPER(concept) BETWEEN 'A' AND 'Z' OR concept BETWEEN '0' AND '9' ORDER BY concept";
	
	$result = mysql_query($qry);
	$current_char = '';
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['first_char'] != $current_char) {
			$current_char = $row['first_char'];
			echo "<a href=\"#".strtoupper($current_char)."\"> ". strtoupper($current_char) ." </a>";
		}
	} 
	
	
	echo "<hr><table>";
	
	$result = mysql_query($qry);
	$current_char = '';
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['first_char'] != $current_char) {
			$current_char = $row['first_char'];
			echo "<tr><td><a name=\"".strtoupper($current_char)."\"><h2>".strtoupper($current_char)."</h2></a></td></tr>";
			//echo '<br />' . strtoupper($current_char) . '<br />-----<br />';
		}
		echo "<tr><td>".glossary_link($row['concept']).'</td></tr>';
	} 
	echo "</table>";
	display_page_bottom();
}
?>