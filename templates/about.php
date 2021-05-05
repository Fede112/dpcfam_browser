<?php include("_header.php");?>

<main class="flex-shrink-0">
	<div class="container">	

		<h1 class="mt-5"><?php echo $page->title." DPCfam"; ?></h1>

		DPCfam [1] is a new unsupervised procedure that uses sequence alignments and Density Peak Clustering [2] to automatically classify homologous protein regions. DPCfam method was adopted to generate clusters for the UniRef50 database, that contains representatives of all known protein sequences (sharing less than 50% of similarity). The classification is evolutionary accurate and it covers a significant fraction of known homologs annotated in Pfam [3]. Moreover, DPCfam suggests the classification of previously unknown regions, some of which have been added to the latest version of the Pfam database. 

		<br/>
		<br/>
		<h3> References </h3>
		<ol>
			<li>Russo ET, Laio A, Punta M. Density Peak clustering of protein sequences associated to a Pfam clan reveals clear similarities and interesting differences with respect to manual family annotation. BMC Bioinformatics. 2021 Mar 12;22(1):121. doi: 10.1186/s12859-021-04013-x. PMID: 33711918; PMCID: PMC7955657 - <a href="https://doi.org/10.1186/S12859-021-04013-X"> DOI </a> - <a href="https://pubmed.ncbi.nlm.nih.gov/33711918/"> PubMed </a>
			</li>
			<li>Rodriguez A, Laio A. Clustering by fast search and find of density peaks. Science. 2014;344(6191):1492–1496. doi: 10.1126/science.1242072 - <a href="https://doi.org/10.1126/science.1242072"> DOI </a> - <a href="https://pubmed.ncbi.nlm.nih.gov/24970081/"> PubMed </a> </li>
			<li>Jaina Mistry, Sara Chuguransky, Lowri Williams, Matloob Qureshi, Gustavo A Salazar, Erik L L Sonnhammer, Silvio C E Tosatto, Lisanna Paladin, Shriya Raj, Lorna J Richardson, Robert D Finn, Alex Bateman, Pfam: The protein families database in 2021, Nucleic Acids Research, Volume 49, Issue D1, 8 January 2021, Pages D412–D419 - <a href="https://doi.org/10.1093/nar/gkaa913"> DOI </a> - <a href="https://pubmed.ncbi.nlm.nih.gov/33125078/"> PubMed </a> </li>
		</ol> 
		




		

	<div>
</main>

<?php include("_footer.php");?>