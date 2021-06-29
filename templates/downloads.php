<?php include("_header.php");?>

<main class="flex-shrink-0">
	<div class="container">	

		<h1 class="mt-5"><?php echo $page->title; ?></h1>

		<div style="padding: 25px 0px 0px 0px;">
		<?= $page->body; ?>
		</div>

		<table class="table">
		<thead>
		    <tr>
		      <th scope="col">File</th>
		      <th scope="col">Description</th>
		      <th scope="col">Link</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td>DPCfam full seeds</td>
		      <td>DPCfam classification of the UniRef50 database (v. 201707)</td>
		      <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  </svg>
			  </td>
		    </tr>
		    <tr>
		      <td>DPCfam cdhit-0.60 seeds</td>
		      <td>DPCfam classification of the UniRef50 database (v. 201707) filtered using 60% as the similarity threshold in cdhit.</td>
		      <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  </svg></td>
		    </tr>
		    <tr>
		      <td>DPCfam MSA</td>
		      <td>Multiple sequence alignment of each Metacluster using DPCfam cdhit-060 seeds as input.</td>
		      <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  </svg></td>
		    </tr>
		    <tr>
		      <td>DPCfam HMM profiles</td>
		      <td>HMM-profiles for all MCs</td>
		      <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  </svg></td>
		    </tr>
		    </tbody>

		    <caption style="font-size: .9rem;
								color: #767676;
								width: 80%;
								padding-top: .5rem;">Table 1: DPCfam full output and post processed files.
			</caption>
		</table>
		
		<!-- Seeds: <a href="<?php echo $fasta_fileurl; ?>" download=<?php echo $fasta_filename; ?>> <?php echo $fasta_filename; ?> </a><br /> -->
<!-- 		Uniref50 DPCfam classification: <a href="<?php echo $fasta_fileurl; ?>" > dpcfam_uniref50_labels.csv </a><br />
		Seeds fasta: <a href="<?php echo $fasta_fileurl; ?>" > all_seeds.fasta </a><br />
		Seeds cdhit060 fasta: <a href="<?php echo $fasta_fileurl; ?>" > all_seeds_cdhit060.fasta </a><br />
		HMM models: <a href="<?php echo $fasta_fileurl; ?>" > all_models.hmm </a><br /> -->
	<div>
</main>

<?php include("_footer.php");?>