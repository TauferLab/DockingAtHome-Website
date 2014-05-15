<?php

require_once("../inc/util.inc");
require_once("../project/project.inc");

$protein= array(
 		array("img/1abe.jpg","1abe.html","1abe"),  
		array("img/1abf.jpg","1abf.html","1abf"),  
		array("img/1apt.jpg","1apt.html","1apt"),  
		array("img/1cbx.jpg","1cbx.html","1cbx"),  
		array("img/1cil.jpg","1cil.html","1cil"),  
		array("img/1cnx.jpg","1cnx.html","1cnx"),  
		array("img/1etr.jpg","1etr.html","1etr"),  
		array("img/1ets.jpg","1etr.html","1etr"),  
		array("img/1ett.jpg","1ett.html","1ett"),  
		array("img/1nnb.jpg","1nnb.html","1nnb"),  
		array("img/1nsc.jpg","1nsc.html","1nsc"),  
		);

echo "<head>
        <title> Targets for " . PROJECT . "</title>
      </head>";

page_head("Docking@Home Targets");
echo "<body>
  <p>Click on the image for a 3D representation of the ligand.</p>
  <p>";

$items=sizeof($protein);
for ($i=0; $i<$items; $i++) {
  echo "<a href=\"javascript: void(0)\" onClick=\"window.open('" . $protein[$i][1] . "', '" . $protein[$i][2] . "', 'width=550, height=600');\"><img width='80' src='" . $protein[$i][0] . "' alt='" . $protein[$i][2] . "'>" . $protein[$i][ 2] . "</a>";
 }

echo "</body>";
page_tail();
?>
