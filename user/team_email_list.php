<?php
//redirect to new results page
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
gotoLocation("/community/team/email_list.php?".$_SERVER['QUERY_STRING']);
?>