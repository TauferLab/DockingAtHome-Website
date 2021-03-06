<?php
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/html-graphs/graphs.inc");

function exist_file($filename) {
   system("test -f $filename", $rval);
   return ($rval == 0);
}

display_page_top("Host and Job Distributions");

// Create tables for the three graphs
echo "<table cellspacing=\"5\" cellpadding=\"5\" class=\"graph\">
      <tr>
      <td valign=\"top\" align=\"left\">
      <b>Host Distribution (Avg. credit > 0.1)</b><br>";

// Generate the horizontal bar graph for the host distribution avg credit > .1
$graph = new BAR_GRAPH("hBar");
$result = mysql_query("select host.os_name as name, count(*) as num_results from host where host.expavg_credit>.1 group by host.os_name");
$hostdata = "";
$hostlabel = "";
while($host = mysql_fetch_object($result)){
  $hostdata = $hostdata . $host->num_results . ',';
  $hostlabel = $hostlabel . $host->name . ',';
 }
$hostlabel = substr($hostlabel,0,-1);
$hostdata = substr($hostdata,0,-1);
mysql_free_result($result);
$graph->values = $hostdata;
$graph->labels = $hostlabel;

$graph->showValues = 1;
echo $graph->create();

echo "</td></tr>
      </table><br>";

echo "<table cellspacing=\"5\" cellpadding=\"5\" class=\"graph\">
      <tr>
      <td valign=\"top\" align=\"left\">
      <b>Jobs In-Progress</b><br>";
// Generate the horizontal bar graph for the host distribution of in progress jobs
$graph = new BAR_GRAPH("hBar");
$result = mysql_query("select host.os_name as name, count(result.id) as num_results from host, result where result.hostid=host.id and result.server_state=4 group by host.os_name");
$hostdata = "";
$hostlabel = "";
while($host = mysql_fetch_object($result)){
  $hostdata = $hostdata . $host->num_results . ',';
  $hostlabel = $hostlabel . $host->name . ',';
 }
$hostlabel = substr($hostlabel,0,-1);
$hostdata = substr($hostdata,0,-1);
mysql_free_result($result);
$graph->values = $hostdata;
$graph->labels = $hostlabel;

$graph->showValues = 1;
echo $graph->create();

echo "</td></tr>
      </table><br>";

echo "<table cellspacing=\"5\" cellpadding=\"5\" class=\"graph\">
      <tr>
      <td valign=\"top\" align=\"left\">
      <b>Jobs Successfully Validated</b><br>";

// Generate the horizontal bar graph for the host distribution of successfully validated jobs
$graph = new BAR_GRAPH("hBar");
$result = mysql_query("select host.os_name as name, count(result.id) as num_results from host, result where result.hostid=host.id and result.server_state=5 and result.outcome=1 and result.validate_state=1 group by host.os_name");
$hostdata = "";
$hostlabel = "";
while($host = mysql_fetch_object($result)){
  $hostdata = $hostdata . $host->num_results . ',';
  $hostlabel = $hostlabel . $host->name . ',';
 }
$hostlabel = substr($hostlabel,0,-1);
$hostdata = substr($hostdata,0,-1);
mysql_free_result($result);
$graph->values = $hostdata;
$graph->labels = $hostlabel;
$graph->showValues = 1;
echo $graph->create();

echo "</td></tr>
      </table><br>";

# Put the timestamp underneath
echo "<p>".$gdate."</p>";

# Now for some explanation
echo "<p>This page shows three tables with information concerning the host and job distributions of D@H</p>";
echo "<ul>";

echo "<li>The first table shows the number of active hosts for each OS type that is connected to D@H. Active in this case means having more than 0.1 average credits.</li>";
echo "<li>The second table shows the number of in-progress jobs for each type of OS. </li>";
echo "<li>The third table shows the number of successfully validated jobs for each OS type. </li>";
echo "</ul>";

display_page_bottom();
?>
