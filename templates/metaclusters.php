<?php include("_header.php");?>


<main class="flex-shrink-0">
	<div class="container">	
		
	<h1 class="mt-5">Metaclusters</h1>
	
	<div> 
		Metaclusters are collections of homologous protein sequence regions... <br/>
		TODO: include general statistics plots: length distribution, size distribution, etc.

	</div>

	<br/>

	<?php
	foreach ($page->children() as $child) {
	    echo "<a href='$child->url'>MC$child->title</a><br>";
	    // $child->delete();
	}

	?>
	<div>
</main>

<?php include("_footer.php");?>