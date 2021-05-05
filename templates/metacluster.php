<?php include("_header.php");?>

<link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/protein_table.css">
<main class="flex-shrink-0">
	<div class="container">	

<?php
// Functions
function pfam_label_split($pfam_label) {
	
	$pfam_label = str_replace ("PF" , "-PF", $pfam_label);
    $pfam_label = ltrim($pfam_label, '-'); 

	// $test=$test[1:];

	$test = explode ( "-" , $pfam_label);

	return $test;
}

?>


<?php 

// Auxiliary variables
$eser_dict = array(
	"-" => "None",
    "1" => "Equivalent",
    "2" => "Shifted",
    "3" => "Extended",
    "4" => "Reduced",
);

?>


<?php //foreach ($pfam_label as $pf) {echo $pf. "\t";} ?>
<h1 class="mt-5"><?php echo "MC".$page->title; ?></h1>


Number of sequences: <?php echo $page->size; ?><br>
Average sequence length: <?php echo $page->len_avg; ?><span>&#177;</span><?php echo $page->len_std; ?><br>
<!-- Metacluster: <?php echo $page->metacluster; ?><br> -->
<?php 
// Check if comparisson against pfam exists
if($page->pfam_label != "-")
{
	// check if it has a Pfam label
	if (strpos($page->pfam_label, "PF") !== false)
	{
		$pfam_labels = pfam_label_split($page->pfam_label);
		$pfam_count =  count($pfam_labels);
	?>
	
	Pfam equivalence: <?php for ($i=0; $i < $pfam_count; ++$i) {?> <a href="<?php echo "http://pfam.xfam.org/family/".$pfam_labels[$i]; ?>" target="_blank"> <?php echo $pfam_labels[$i]; ?> </a> <?php if($i!=$pfam_count-1){echo "-";}} if($pfam_count > 1){echo "(architecture)";}?><svg width="18px" height="18px" viewBox="0 0 24 24"><g id="external_link" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 13.5 17 19.5 5 19.5 5 7.5 11 7.5"></polyline><path d="M14,4.5 L20,4.5 L20,10.5 M20,4.5 L11,13.5"></path></g></svg><br> 

	<?php }

	else{ ?>
		Pfam equivalence: <?php echo $page->pfam_label; ?><br>
	<?php } ?>
	<!-- Pfam equivalence: <?php foreach (pfam_label_split($page->pfam_label) as $pf) {?> echo $pf. "\t";<?php } ?><br> -->

	


	Pfam overlap: <?php echo $page->pfam_overlap; ?><br>
	Pfam overlap type: <?php echo $eser_dict[$page->pfam_eser]; ?><br>


<?php 
}
else{
	echo "Pfam comparisson not available.";
}?>

<hr/>
<h4><?php echo "Downloads"; ?></h4>

<?php 
$fasta_fileurl = path2url($page->fasta_path);
$fasta_filename = basename($page->fasta_path);
$hmm_fileurl = path2url($page->hmm_path);
$hmm_filename = basename($page->hmm_path);

?>

Seeds: <a href="<?php echo $fasta_fileurl; ?>" download=<?php echo $fasta_filename; ?>> <?php echo $fasta_filename; ?> </a><br />

<?php
if (file_exists($page->hmm_path))
{ ?>
	HMM model: <a href="<?php echo $hmm_fileurl; ?>" download=<?php echo $hmm_filename; ?>> <?php echo $hmm_filename; ?> </a><br />
<?php
}else
{ ?>
	HMM model: Not available <br/>

<?php 
}
?>





<?php

// QUERY PROTEINS


?>
<hr/>
<h4><?php echo "Sequences list"; ?></h4>


<?php $protein_matches = $pages->find("template=protein, mcs_in_protein.metacluster={$page->title})"); ?>

<!-- <?php  print_r($protein_matches) ?> -->


<table id="protein_table" border = '2'>
		<tr>
		<th>Protein</th>
		<th>Start</th>
		<th>End</th>
		<th>AA</th>
		</tr>

	<?php
	// echo $query;
	foreach ($protein_matches as $entry)
	{
	    echo "<tr>";
	    echo '<td><a href="' . $config->urls->httpRoot. 'proteins/'. $entry['title'] . '">' . $entry['title'] . '</a></td>';
	    // echo "<td>" . $entry['title'] ."</td>";
	    echo "<td>" . $entry['mcs_in_protein'][0]->regionStart . "</td>";
	    echo "<td>" . $entry['mcs_in_protein'][0]->regionEnd . "</td>";
	    // echo "<td>" . substr($entry['regionAA'], 0, 100)."..." . "</td>";
	    echo "<td>" . $entry['mcs_in_protein'][0]->regionAA . "</td>";
	    echo "</tr>";
	}
	?>

</table>


<div>
</main>

<?php include("_footer.php");?>
