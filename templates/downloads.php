<?php include("_header.php");?>

<main class="flex-shrink-0">
	<div class="container">	

		<h1 class="mt-5"><?php echo $page->title; ?></h1>

		<!-- Seeds: <a href="<?php echo $fasta_fileurl; ?>" download=<?php echo $fasta_filename; ?>> <?php echo $fasta_filename; ?> </a><br /> -->
		Uniref50 DPCfam classification: <a href="<?php echo $fasta_fileurl; ?>" > dpcfam_uniref50_labels.csv </a><br />
		Seeds fasta: <a href="<?php echo $fasta_fileurl; ?>" > all_seeds.fasta </a><br />
		Seeds cdhit060 fasta: <a href="<?php echo $fasta_fileurl; ?>" > all_seeds_cdhit060.fasta </a><br />
		HMM models: <a href="<?php echo $fasta_fileurl; ?>" > all_models.hmm </a><br />
	<div>
</main>

<?php include("_footer.php");?>