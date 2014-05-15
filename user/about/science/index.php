<?
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");

$proteins = array(
	array(
		"name" => "P38 alpha",
		"targets" => array(
			"1bl6",
			"1bl7",
			"1di9",
			"1kv1",
			"1kv2",
			"1ouk",
			"1ouy",
			"1oz1",
			"1w83",
			"1w84",
			"1yqj")
        ),
	array(
		"name" => "Trypsin",
		"targets" => array(
			"1c1r",
			"1c2d",
			"1c5p",
			"1c5q",
			"1c5s",
			"1c5t",
			"1ce5",
			"1g36",
			"1ghz",
			"1gi1",
			"1gi4",
			"1gi6",
			"1gj6",
			"1k1i",
			"1k1j",
			"1k1l",
			"1k1m",
			"1k1n",
			"1ppc",
			"1pph",
			"1qb6",
			"1tpp",
			"1xug",
			"2bza",
			"3ptb")
	),
	array(
		"name" => "HIV Proteases",
		"targets" => array(
			"1hvi",
			"1hvj",
			"1ajv",
			"1ajx",
			"1c70",
			"1d4h",
			"1d4i",
			"1d4j",
			"1dif",
			"1ebw",
			"1ebz",
			"1g2k",
			"1g2k",
			"1g35",
			"1gno",
			"1hbv",
			"1hih",
			"1hps",
			"1hpv",
			"1hpx",
			"1hsg",
			"1htf",
			"1hvk",
			"1hvl",
			"1iiq",
			"1m0b",
			"1ohr",
			"1t7k",
			"2bpv",
			"2bpy")
	)
);

function display_all_proteins($proteins) {
	foreach ($proteins as $protein) {
		echo "<h5>".$protein["name"]."</h5>\n";
		display_all_targets($protein["targets"]);
	}
}

function display_all_targets($targets) {
	$cellcount = 0;
	$cellsperrow = 12;
	echo "<table style=\"margin:5px\"><tr>\n";
	foreach ($targets as $target) {
		echo "<td style=\"text-align:center\">\n\t";
		display_target_image_link($target);
		echo "</td>\n";
		$cellcount++;
		if (($cellcount%$cellsperrow) == 0) echo "</tr><tr>\n";
	}
	echo "</tr></table>\n";
}

function display_target_image_link($target) {
	echo "<a href=\"/images/targets/".$target.".gif\" class=\"thickbox\" title=\"Target ".$target."\">";
	echo "<img src=\"/images/targets/".$target."_thumb.jpg\" alt=\"Target ".$target."\" /><br />".$target."</a>\n";
}
	
display_page_top("About the Docking@Home Science");
?>

<table style="margin-left:auto;margin-right:auto;width:800px;">
    <tr>
        <td style="text-align:center; vertical-align:top">
            <a href="/images/science/protein_ligand_docking.png" class="thickbox" title="Protein-Ligand Docking">
                View Protein-Ligand Docking<br />
                <img src="/images/science/protein_ligand_docking.png" alt="Protein-Ligand Docking" width="200" />
            </a>
        </td>
        <td style="text-align:center; vertical-align:top">
            <a href="/images/targets/docking_movie.gif" class="thickbox" title="Model Animation">
                View Model Animation<br />
                <img src="/images/targets/docking_movie_thumb.png" alt="Model Animation" height="110" />
            </a>
        </td>
        <td style="text-align:center; vertical-align:top">
            <a href="/images/science/docking_algorithm.png" class="thickbox" title="Docking Algorithm">
                View Protein-Ligand Docking<br />
                <img src="/images/science/docking_algorithm.png" alt="Docking Algorithm" width="200" />
            </a>
        </td>
    </tr>
</table>
    
<h3>Docking</h3>
<p>Docking is a molecular modeling method which predicts the preferred orientation of one <?= glossary_link("molecule") ?> binding to another. Knowing the preferred orientation of these two molecules allows scientists to also predict how tightly they will bind. We perform docking simulations on small molecule drug candidates, which we call <?= glossary_link("ligand") ?>s, and their target proteins inside the human body in order to predict how affective the ligand might be in a drug. After the docking simulation, well-docked protein-ligand complexes are produced in experimental laboratories for testing.</p>

<h3>Targets</h3>
<p>Click on the image for a 3D representation of the ligand. <b>Note</b>: These are 2MB+, so they make take a few seconds to load.</p>

<? display_all_proteins($proteins); ?>

<hr class="centered" />
<p>Read about more <a href="advanced.php">Advanced Concepts</a></p>
<p>View <a href="/about/project/papers.php">Papers</a> on the subject</p>
<p>Learn more about Docking@Home terminology in the <a href="/about/glossary.php">Glossary</a></p>
<p>Go back to <a href="/about/">About Docking@Home</a></p>
<?php display_page_bottom(); ?>
