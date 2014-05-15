<?php
//redirect to new results page
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
gotoLocation("/status/?".$_SERVER['QUERY_STRING']);
?>