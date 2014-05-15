<?php
//redirect to real form
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
gotoLocation("/account/create_form.php?".$_SERVER['QUERY_STRING']);
?>