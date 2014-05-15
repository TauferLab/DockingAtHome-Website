<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	display_page_top("About the Docking@Home Science: Preliminary Results");
?>

<table style="margin:0px;padding:0px;">
    <tr>
        <td style="padding-top:0px" colspan="2">
	    <h3> Preliminary results for three simulation phases for HIV1</h3>
            <p>Docking@Home uses a postprocessing algorithm to find native-like structures (structures that are similar to those in nature). Using this algorithm D@H avoids the use of replication and finds from millions of potential candidates one that is more likely to occur in nature.</p>
            <p>Preliminary tests were done using 23 HIV1 complexes in three pases. The first phase (A) tested a simple model and fast model. The second phase(B) tested a  more accurate and computationally expensive model. The third phase (C) tested the second model (accurate but expensive) producing a random variation from a structure that was proven to be at least 5A different from the native (crystal) structure.</p>
	    <p>The following figures compare the single candidate obtained using our prostprocessing algorithm versus the top 5 structures with minimum energy. The <b>star</b> represents our candidate while the boxplot represents the variance of the Top-5 minimum energy structures.<b> A good candidate should be at most 2A away from the crystal structure.</b> The vertical axis show the RMSD with respect to the crystal structure (the lower the better). The horizontal axis show the different complexes.</p>
           <p> Preliminary results show that our postprocessing method is reliable and robust. It is insensitive to the model being used and to the initial conditions of the simulations. Our algorithm finds good candidates in 86% of the cases, while minimum energy finds good candidates only in 34% of the cases </p>
        </td>
        <td>
            <p style="text-align:center;">
                <a href="results/boxplot_hiv_mod13.png" class="thickbox" title="A.- First phase HIV1. The star is our candidate structure while the boxplot are the Top-5 minimum energy structures">
                    View First Phase HIV1 (A) <br />
                    <img src="results/boxplot_hiv_mod13_small.png" alt="Fisrt phase HIV1" width="400">
                </a>
            </p>
            <p style="text-align:center;">
                <a href="results/boxplot_hiv_mod14.png" class="thickbox" title="B.- Second phase HIV1. The star is our candidate structure while the boxplot are the Top-5 minimum energy structures">
                    View Second Phase HIV1 (B) <br />
                    <img src="results/boxplot_hiv_mod14_small.png" alt="Second phase HIV1" width="400">
                </a>
            </p>
            <p style="text-align:center;">
                <a href="results/boxplot_hiv_mod14b.png" class="thickbox" title="C.- Third phase HIV1. The star is our candidate structure while the boxplot are the Top-5 minimum energy structures">
                    View Third Phase HIV1 (C) <br />
                    <img src="results/boxplot_hiv_mod14b_small.png" alt="Third phase HIV1" width="400">
                </a>
            </p>
            </div> 
        </td>
    </tr>
</table>

<hr class="centered" />
<p>Go back to the <a href="index.php">Science Introduction</a></p>
<p>View <a href="/about/project/papers.php">Papers</a> on the subject</p>
<p>Learn more about Docking@Home terminology in the <a href="/about/glossary.php">Glossary</a></p>
<?php display_page_bottom(); ?>
