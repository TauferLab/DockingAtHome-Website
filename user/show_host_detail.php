<?php
//redirect to new results page
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
gotoLocation("/community/show_host_detail.php?".$_SERVER['QUERY_STRING']);
?>