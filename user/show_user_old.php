<?php
//redirect to new user page
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
gotoLocation("/community/show_user.php?".$_SERVER['QUERY_STRING']);
?>