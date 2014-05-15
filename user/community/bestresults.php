<?php
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/uotd.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db_conn.inc");

display_page_top("Best Docking Results");
//$model=0;

// get model
if(isset($_GET['model'])){
  $model=get_str('model');
}else{
 // $model=0;
}


$config = get_config();
db_init();


get_models();

if(isset($model)){


?>


<p>The display of our results is powered by <a href="http://www.jmol.org" target="_blank">Jmol</a>: an open-source Java viewer for chemical structures in 3D. Just click the View Protein or View Ligand links to show them.</p> 

<?php

   display_best_results_model($model);

}

display_page_bottom();
?>

