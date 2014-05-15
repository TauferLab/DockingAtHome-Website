<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/html-graphs/graphs.inc");

function exist_file($filename) {
   system("test -f $filename", $rval);
   return ($rval == 0);
}

display_page_top("Shared Memory, Database and Host Distribution");

// Some file name definitions
$shmemdistfile = "shmem_results.dat";
$acthostfile = "active_hosts.dat";
$unsentwufile = "unsent_results.dat";

// Find out where we store our data files. Resort to /tmp if this fails
exec("ls ".$_SERVER['DOCUMENT_ROOT']."/../..|grep tmp_", $tmpdir, $rval);
if ($rval > 0) $tmpdir[0] = "/tmp";

// Get data from shmem file and remove the date (last element)
if (exist_file($_SERVER['DOCUMENT_ROOT']."/../../$tmpdir[0]/$shmemdistfile")) {
   $datay1 = array_map("rtrim",file($_SERVER['DOCUMENT_ROOT']."/../../$tmpdir[0]/$shmemdistfile"));
   $gdate = "<br>Created ".array_pop($datay1);
} else {
   echo "<p>No data available. Please come back later.</p>";
   exit;
}

// Get data from active host file and remove the date (last element)
if (exist_file($_SERVER['DOCUMENT_ROOT']."/../../$tmpdir[0]/$acthostfile")) {
   $datay2 = array_map("rtrim",file($_SERVER['DOCUMENT_ROOT']."/../../$tmpdir[0]/$acthostfile"));
   array_pop($datay2);
} else {
   echo "<p>No data available. Please come back later.</p>";
   exit;
}

// Get data from unsent workunits file and remove the date (last element)
if (exist_file($_SERVER['DOCUMENT_ROOT']."/../../$tmpdir[0]/$unsentwufile")) {
   $datay3 = array_map("rtrim",file($_SERVER['DOCUMENT_ROOT']."/../../$tmpdir[0]/$unsentwufile"));
   array_pop($datay3);
} else {
   echo "<p>No data available. Please come back later.</p>";
   exit;
}



// Get labels for shmem distribution
$hrlabel = "";
$hrdata = "";
while ($temp = array_pop($datay1)) {
   $data = split(" ", $temp);
   $hrlabel = $data[0] . "," . $hrlabel;
   $hrdata =  $data[1] . "," . $hrdata;
}

// Get labels for host distribution
$hostlabel = "";
$hostdata = "";
while ($temp = array_pop($datay2)) {
   $data = split(" ", $temp);
   $hostlabel = $data[0] . "," . $hostlabel;
   $hostdata =  $data[1] . "," . $hostdata;
}

// Get labels for database HR distribution
$wulabel = "";
$wudata = "";
while ($temp = array_pop($datay3)) {
   $data = split(" ", $temp);
   $wulabel = $data[0] . "," . $wulabel;
   $wudata =  $data[1] . "," . $wudata;
}

// Remove that last comma we don't need
$hrlabel = substr($hrlabel,0,-1);
$hrdata = substr($hrdata,0,-1);
$hostlabel = substr($hostlabel,0,-1);
$hostdata = substr($hostdata,0,-1);
$wulabel = substr($wulabel,0,-1);
$wudata = substr($wudata,0,-1);

// We also don't want the underscores in the labels so let's
// replace these with a space
$hrlabel = ereg_replace("_", " ", $hrlabel);
$hostlabel = ereg_replace("_", " ", $hostlabel);
$wulabel = ereg_replace("_", " ", $wulabel);

// Create tables for the three graphs
echo "<table cellspacing=\"5\" cellpadding=\"5\" class=\"graph\">
        <tr>
          <td valign=\"top\" align=\"left\">
             <b>Shared Memory HR Distribution</b><br>
";

// Generate the horizontal bar graph for the shmem distribution
$graph = new BAR_GRAPH("hBar");
$graph->values = $hrdata;
$graph->labels = $hrlabel;
$graph->showValues = 1;
echo $graph->create();

echo "    </td>
          <td valign=\"top\" align=\"left\">
             <b>Database HR Distribution</b><br>
";

// Generate the horizontal bar graph for the database distribution
$graph = new BAR_GRAPH("hBar");
$graph->values = $wudata;
$graph->labels = $wulabel;
$graph->showValues = 1;
echo $graph->create();

echo "    </td>
          <td valign=\"top\" align=\"left\">
            <b>Host Distribution (Avg. credit > 0.1)</b><br>
";

// Generate the horizontal bar graph for the host distribution
$graph = new BAR_GRAPH("hBar");
$graph->values = $hostdata;
$graph->labels = $hostlabel;
$graph->showValues = 1;
echo $graph->create();

echo "    </td>
        </tr>
      </table>
";

# Put the timestamp underneath
echo "<p>".$gdate."</p>";

# Now for some explanation
echo "<p>This page shows three tables with information concerning the Homogeneous Redundancy (HR) scheduling policy.</p>";
echo "<ul>";
echo "<li>The first table shows the distribution of unsent results in the shared memory segment of the BOINC server. These are basically the results that are ready to be sent to your PCs.";
echo "<ul><li>The first column shows the HR class of the result, for example 'Linux Intel Family5' means that this result has been reserved for a Linux computer with an Intel processor of Family 5 (every processor belongs to a certain family, model and stepping series determined by the vendor of the processor).</li><li>The second column shows the number of reserved results for the HR class.</li><li>The blue bar shows the percentage of the total reserved number of results.</li></ul></li>";
echo "<li>The second table shows the same information for unsent results in the database (usually more than the number in the shared memory). One could say that the shared memory is really a window to the results in the database.</li>";
echo "<li>Lastly, the third table shows the number of active hosts of each HR class that are connected to D@H. Active in this case means having more than 0.1 average credits.</li>";
echo "</ul>";

display_page_bottom();
?>
