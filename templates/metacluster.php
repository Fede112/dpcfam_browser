<?php include("_header.php");?>

<link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/protein_table.css">
<main class="flex-shrink-0">
	<div class="container">	

<?php
// Functions
function pfam_da_split($pfam_da) {
	
	$pfam_da = str_replace ("PF" , "-PF", $pfam_da);
    $pfam_da = ltrim($pfam_da, '-'); 

	// $test=$test[1:];

	$test = explode ( "-" , $pfam_da);

	return $test;
}

?>




<?php //foreach ($pfam_da as $pf) {echo $pf. "\t";} ?>
<h1 class="mt-5"><?php echo "MC".$page->title; ?></h1>


Number of sequences (UniRef50): <?php echo $page->size; ?><br>
Average sequence length: <?php echo $page->len_avg; ?><span>&#177;</span><?php echo $page->len_std; ?><br>
<!-- Metacluster: <?php echo $page->metacluster; ?><br> -->
<?php 
// Check if comparisson against pfam exists
if($page->pfam_da != "-")
{
	// check if it has a Pfam label
	if (strpos($page->pfam_da, "PF") !== false)
	{
		$pfam_das = pfam_da_split($page->pfam_da);
		$pfam_count =  count($pfam_das);
	?>
	
	Pfam equivalence: <?php for ($i=0; $i < $pfam_count; ++$i) {?> <a href="<?=$pages->get(1)->url."?category=Pfam&search_input=".$pfam_das[$i];?>" target="_blank"> <?php echo $pfam_das[$i]; ?> </a> <?php if($i!=$pfam_count-1){echo "-";}} if($pfam_count > 1){echo "(architecture)";}?><br>

	<!-- <svg width="18px" height="18px" viewBox="0 0 24 24"><g id="external_link" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 13.5 17 19.5 5 19.5 5 7.5 11 7.5"></polyline><path d="M14,4.5 L20,4.5 L20,10.5 M20,4.5 L11,13.5"></path></g></svg><br>  -->

	<?php }

	else{ ?>
		Pfam equivalence: <?php echo $page->pfam_da; ?><br>
	<?php } ?>
	<!-- Pfam equivalence: <?php foreach (pfam_da_split($page->pfam_da) as $pf) {?> echo $pf. "\t";<?php } ?><br> -->

	


	Pfam overlap: <?php echo $page->pfam_overlap; ?><br>
	Pfam overlap type: <span style="color:<?=$pfam_eser_colors[$page->pfam_eser]?>;"> <strong><?= $page->pfam_eser; ?></strong></span>

<?php 
}
else{
	echo "Pfam comparisson not available.";
}?>

<hr/>
<h4><?php echo "Downloads"; ?></h4>



<?php 
$cdhit_path = $page->cdhit_path;
$cdhit_fileurl = path2url($cdhit_path);
$cdhit_filename = basename($cdhit_path);

$msa_path = $page->msa_path;
$msa_fileurl = path2url($msa_path);
$msa_filename = basename($msa_path);

$hmm_path = $page->hmm_path;
$hmm_fileurl = path2url($hmm_path);
$hmm_filename = basename($hmm_path);
?>

<?php
if (file_exists($cdhit_path)){ ?>
	Seeds (cdhit 60%): <a href="<?php echo $cdhit_fileurl; ?>" download=<?php echo $cdhit_filename; ?>> <?php echo $cdhit_filename; ?> </a><br/>
<?php
}else
{ ?>
	Seeds (cdhit 60%): Not available <br/>

<?php 
}
?>

<?php
if (file_exists($msa_path)){ ?>
	MSA: <a href="<?php echo $msa_fileurl; ?>" download=<?php echo $msa_filename; ?>> <?php echo $msa_filename; ?> </a><br />
<?php
}else
{ ?>
	MSA: Not available <br/>

<?php 
}
?>

<?php
if (file_exists($hmm_path))
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
<h4><?php echo "Sequences list (cdhit 60%)"; ?></h4>


<?php // $protein_matches = $pages->find("template=protein, mcs_in_protein.metacluster={$page->title})"); ?>



<?php if (file_exists($cdhit_path)){?>
<table id="protein_table" border = '2'>
		<tr>
		<th>Protein</th>
		<th>Range</th>
		<th style="width: 100%">AA</th>
		</tr>

	<?php



		$file = fopen($cdhit_path, 'r');
		
		$index = 0;
		while (($line = fgetcsv($file, 1000, '|')) !== FALSE) {
			//$line is an array of the csv elements		
			if($index%2==0){
				$uniprot = substr($line[0], 1);
				$range = $line[1];
			}
			else{

		    	echo "<tr>";
		    	echo '<td><a href="' . $config->urls->httpRoot. 'proteins/'. $uniprot . '">' . $uniprot . '</a></td>';
		    	// echo "<td>" . $uniprot . "</td>";
		    	echo "<td>" . $range . "</td>";
		    	echo "<td>" . trim($line[0]) . "</td>";
		    	echo "</tr>";
		    }
		    $index++;
			
		}
		fclose($file);
}
else{
	echo "<b>Sequences information not available! </b> <br>";
}

	// echo $query;
	// foreach ($protein_matches as $entry)
	// {
	//     echo "<tr>";
	//     echo '<td><a href="' . $config->urls->httpRoot. 'proteins/'. $entry['title'] . '">' . $entry['title'] . '</a></td>';
	//     // echo "<td>" . $entry['title'] ."</td>";
	//     echo "<td>" . $entry['mcs_in_protein'][0]->regionStart . "</td>";
	//     echo "<td>" . $entry['mcs_in_protein'][0]->regionEnd . "</td>";
	//     // echo "<td>" . substr($entry['regionAA'], 0, 100)."..." . "</td>";
	//     echo "<td>" . $entry['mcs_in_protein'][0]->regionAA . "</td>";
	//     echo "</tr>";
	// }
	?>

</table>


<div>
</main>

<?php include("_footer.php");?>
