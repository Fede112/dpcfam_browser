<?php include("_auxiliary.php");?>

<!doctype html>

<html lang="en" class="h-100">
<head>
  <meta charset="utf-8">

  <title>DPCfam</title>
  <meta name="description" content="DPCfam database">
  <meta name="author" content="SISSA">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/main.css">


  <?php
  // Global variables
  $pfam_eser_colors = array(
    'extended'=>"rgb(255,153,204)",
    'shifted'=>"rgb(82,235,133)",
    'reduced'=>"rgb(102,204,255)",
    'equivalent'=>"rgb(236, 212, 63)"
    )
  ?>




</head>
<!--
<body>
    <h1>DPCfam database</h1>




        <?php
        	// if ($user->isSuperUser()){} // to display only for admin (you can have distinct roles)

    		// include("./basic-page.php");
    		// echo $page->title;
            //
    		// echo "<ul>";
    		// foreach ($page->children as $child) {
    		// 	echo "<li><a href='{$child->url}'>{$child->title}</a></li>";
    		// }
    		// echo "</ul>";
    	?>



        <form action="<?php $_PHP_SELF ?>" method="GET">
            Search Metacluster: <input type = "text" name = "clustername" id = "clustername" placeholder="MC1234" />
            <input type = "submit" />
        </form> -->




        <body class="d-flex flex-column h-100">

        <header>
          <!-- Fixed navbar -->
          <nav class="navbar navbar-expand-md navbar-dark fixed-top">
            <div class="container">
                <!-- Name/logo -->
              <a class="navbar-brand" href="<?php echo $config->urls->httpRoot ?>">DPCfam</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                  <!-- MENU -->
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li> -->
                  <?php
                  // foreach ($pages->get(1)->children as $child) {
                  $metaclusters=$pages->findOne("template=metaclusters");
                  $about=$pages->findOne("template=about");
                  $downloads=$pages->findOne("template=downloads");
                  echo "<li class='nav-item'><a class='nav-link' href='{$metaclusters->url}'>{$metaclusters->title}</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='{$downloads->url}'>{$downloads->title}</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='{$about->url}'>{$about->title}</a></li>";
                  if($page->editable()) echo "<li class='nav-item'><a class='nav-link' href='$page->editURL'>Edit</a></li>";
          		  // }
                ?>
                </ul>
                <!-- small search form -->
                <?php if($page->id != 1): ?>
                    <form class="d-flex" action="<?php echo $pages->get(1)->url; ?>">
                      <input class="form-control me-2" type="search" placeholder="Enter MC" name="search_input" aria-label="Search">
                      <input name="category" type="hidden" value="DPCfam" />
                      <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                <?php endif; ?>
              </div>
            </div>
          </nav>
        </header>
