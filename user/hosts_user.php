<?php
//redirect to new user hosts page
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
gotoLocation("/community/hosts_user.php?".$_SERVER['QUERY_STRING']);
?>