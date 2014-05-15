<?php

// show a result
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/result.inc");

$resultid = get_int("resultid");
$result = lookup_result($resultid);
if (!$result) {
    error_page("No such task");
}
display_page_top("Task details");
show_result($result);
display_page_bottom();

?>
