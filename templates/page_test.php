<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page->title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates?>styles/main.css" />
	</head>
	<body>
		<h1><?php echo $page->title; ?></h1>
		<?php 
		 $page->of(false); 
		echo $page->of()."<br/>";

		foreach($page->test as $event) {
	  		echo "
		    <p>
		      Date: $event->date<br/>
		      Title: $event->title<br/>
		      Start: $event->align_start
		    </p>
		    ";

		    $event->align_start=20;

			
			echo "
			<p>
		      Date: $event->date<br/>
		      Title: $event->title<br/>
		      Start: $event->align_start
		    </p>
		    ";		    

		}

		// echo "Start: ". $event->align_start;
		// $page->save();
		// $pages->saveField($page, 'test');
		
		?>
	
	</body>
</html>
