<?php

$protein= array(
        array("1hvi_thumb.jpg","1hvi"),
        array("1hvj_thumb.jpg","1hvj"),
        array("1ajv_thumb.jpg","1ajv"),
        array("1ajx_thumb.jpg","1ajx"),
        array("1c70_thumb.jpg","1c70"),
        array("1d4h_thumb.jpg","1d4h"),
        array("1d4i_thumb.jpg","1d4i"),
        array("1d4j_thumb.jpg","1d4j"),
        array("1dif_thumb.jpg","1dif"),
        array("1ebw_thumb.jpg","1ebw"),
        array("1ebz_thumb.jpg","1ebz"),
        array("1ec1_thumb.jpg","1ec1"),
        array("1g2k_thumb.jpg","1g2k"),
        array("1g35_thumb.jpg","1g35"),
        array("1gno_thumb.jpg","1gno"),
        array("1hbv_thumb.jpg","1hbv"),
        array("1hih_thumb.jpg","1hih"),
        array("1hps_thumb.jpg","1hps"),
        array("1hpv_thumb.jpg","1hpv"),
        array("1hpx_thumb.jpg","1hpx"),
        array("1hsg_thumb.jpg","1hsg"),
        array("1htf_thumb.jpg","1htf"),
        array("1hvk_thumb.jpg","1hvk"),
        array("1hvl_thumb.jpg","1hvl"),
        array("1iiq_thumb.jpg","1iiq"),
        array("1m0b_thumb.jpg","1m0b"),
        array("1ohr_thumb.jpg","1ohr"),
        array("1t7k_thumb.jpg","1t7k"),
        array("2bpv_thumb.jpg","2bpv"),
        array("2bpy_thumb.jpg","2bpy"),
);



//$items=sizeof($protein);
$items=6;
$start=23;
$end=$start+$items;
if($end>29) $end=29;
for ($i=$start; $i<$end; $i++) {
        echo "<a href=\"\" onclick=\"window.open('./target_pop?target=" . $protein[$i][1] . "', '" . $protein[$i][1] . "', 'menubar=0, width=550, height=650,resizable=1');return false;\"> <img width='50' height='50' src='./img/" . $protein[$i][0] . "' alt='" . $protein[$i][1] . "'>" . $protein[$i][1]."</a> ";
}
?>
