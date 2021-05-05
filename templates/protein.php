<?php include("_header.php");?>

<main class="flex-shrink-0">
	<div  class="container">	
		<h1 class="mt-5"><?php echo $page->title; ?></h1>


		<!-- https://www.uniprot.org/uniref/?query=UPI0008A9CF20&sort=score -->
		<!-- <?php $metacluster=$pages->findOne("template=metacluster, name=$page->metacluster"); ?> -->
		<!-- Metacluster: <a href="<?php echo $metacluster->url; ?>"><?php echo "MC".$metacluster->title; ?></a><br /> -->

		<br/>
		<h2> DPCfam Domains </h2>
		<?php echo $page->mcs_in_protein->count."<br/>"; ?>
		<?php foreach($page->protein_labels as $label){ ?>
			<hr/>
			<h4><?="MC".$label->metacluster ?></h4>

			<p>
			<!-- Metacluster: <?php echo $region->metacluster; ?><br> -->
			Sequence Start: <?php echo $label->align_start; ?><br>
			Sequence End: <?php echo $label->align_end; ?><br>
			<span style="width:800px; word-wrap:break-word; display:inline-block;"> 
			</span><br>
			</p>
			

		<?php } ?>
		<hr/>
	<div>
</main>

<?php include("_footer.php");?>