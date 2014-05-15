<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	display_page_top("About the Docking@Home Science: Advanced Concepts");
?>

<table style="margin:0px;padding:0px;">
    <tr>
        <td style="padding-top:0px" colspan="2">
            <p>Docking@Home is part of the DAPLDS (Dynamically Adaptive Protein Ligand Docking System) project. This project aims to build a computational environment to assist scientists in understanding the atomic details of protein-ligand interactions. High-throughput, protein-ligand docking simulations are performed on a computational environment that deploys a large number of volunteer computers (donated compute cycles) connected to the Internet. The scales proposed in DAPLDS are not the traditional scales currently used in the life sciences. We deal with computational rather than experimental multi-scales.</p>
            <p>Our multi-scale approach comprises three spanning scales (dimensions) of docking assumptions: protein-ligand representation, solvent representation, and sampling strategy. Within a scale, different scale values require different models and different algorithms to represent the models.In such a scenario, the two most critical challenges in dealing with multiple scales computationally are:</p>
            <ol>
                <li>the ability to model biological systems with algorithms that dynamically adapt to the most appropriate value of each scale</li>
                <li>the ability to assure that the algorithms can, indeed, be executed in the “required” amount of time using large numbers of distributed volunteer computing systems.</li>
            </ol>
            <p>The latter point refers to having the necessary computational resources (CPU cycles, memory, network, etc.). The nature of these challenges requires collaboration among computational biophysicists, computational scientists, computer scientists, and system architects. These challenges and our main achievements are presented in this poster.</p>
            <h3>Our Objectives</h3>
            <ul>
                <li>Explore the multi-scale nature of dynamic protocol model adaptations for protein-ligand docking</li>
                <li>Develop methods and models that efficiently accommodate these computational adaptations in VC environments based on BOINC</li>
                <li>Extend knowledge with respect to protein-ligand complexes and make this knowledge accessible to the scientific community via cyber-infrastructures</li>
            </ul>
            <hr />
        </td>
    </tr>
    <tr>
        <td style="width:500px;">
            <h3> Multi-Scale Protein-Ligand Docking</h3>
            <ul>
                <li>Implement multi-scale docking models with different computational complexity and accuracy levels</li>
                <li>Cluster protein-ligand complexes in classes based on characteristics</li>
                <li>Define adaptive techniques to match models to classes dynamically</li>
                <li>Matching based on quantitative values</li>
            </ul>
            
            <h3>Protein-Ligand Representation</h3>
            <ul>
                <li>Spanning scale from rigid to flexible representation of protein-ligand interactions</li>
                <li>Coarse grid (1Å) with soft Lennard-Jones potential</li>
                <li>Finer grid (0.25Å) with soft Lennard-Jones potential</li>
                <li>All-atom  representation of the protein-ligand interaction</li>
                <li>Multiple protein structures of the same receptor considering small side-chain movements </li>
                <li>Multiple protein structures of the same receptor considering large protein movements</li>
            </ul>
            
            <h3>Sampling Policy</h3>
            <ul>
                <li>Spanning scale from fixed to adaptive sampling of the protein-ligand docking space</li>
                <li>Fixed number of trials per attempt and for each trial a fixed number of orientations per conformation</li>
                <li>Change the number of trials per attempt as well as the number of orientations per trial</li>
                <li>Different lengths for the heating and cooling phases as well as minimization in MD simulation</li>
            </ul>
            
            <h3>Potential energy and Solvent Treatment</h3>
            <ul>
                <li>Spanning scale from less accurate to more accurate modeling of solvent treatment</li>
                <li>Constant dielectric coefficient + potential energy</li>
                <li>Distance-dependent dielectric coefficient + potential energy</li>
                <li>Implicit representation of solvent using a Generalized Born model+free energy</li>
            </ul>
            
            <h3>Challenges in Computation</h3>
            <ul>
                <li>Implement robust docking simulations</li>
                <li>Across heterogeneous, volatile and error prone  machines</li>
                <li>Explore adaptive scheduling policies</li>
                <li>Need for reliable simulation environments for testing</li>
                <li>Deal with different levels of resource availability and reliability</li>
                <li>Prevent starving machines and reduce redundant computation</li>
                <li>Implement multi-scale algorithmic adaptations</li>
                <li>Accommodate adaptations in cyber-infrastructures</li>
                <li>Characterize resources and docking systems+models</li>
                <li>Design techniques for selection of models and resources at run-time</li>
            </ul>
        </td>
        <td>
            <p style="text-align:center;">
                <a href="/images/science/multi_scale_models.png" class="thickbox" title="Multi-Scale Models">
                    View Multi-Scale Models<br />
                    <img src="/images/science/multi_scale_models.png" alt="Multi-Scale Models" width="250">
                </a>
            </p>
            <p style="margin-top:50px;text-align:center;">
                <a href="/images/science/daplds1.png" class="thickbox" title="DAPLDS">
                    View DAPLDS<br />
                    <img src="/images/science/daplds1_thumb.png" alt="DAPLDS Thumbnail" width="250" />
                </a>
            </div> 
        </td>
    </tr>
</table>

<hr class="centered" />
<p>Go back to the <a href="index.php">Science Introduction</a></p>
<p>View <a href="/about/project/papers.php">Papers</a> on the subject</p>
<p>Learn more about Docking@Home terminology in the <a href="/about/glossary.php">Glossary</a></p>
<?php display_page_bottom(); ?>
