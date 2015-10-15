<?php 

    function setQueryVars(&$year) {

      $year = -1;

      if(isset($_GET['year']) && !empty($_GET['year'])) {
        $year = $_GET['year'];
      }

      else {
        include 'menu.php';
        echo '<p>You seem to be missing some important information. Please <a href="index.php">browse the index</a> to find a year you would like to view.</p>';

        die();
      }

    }

    ?>

<html>

   <head>
	<title>Nancy Thompson WWII Scrapbook -Years</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	 
    <style type="text/css">
      body{ height: 100%; font-family: "Lucida Sans", Trebuchet, monospace; }
      .searchTermBox{ border:solid 1px #333; font-weight:bold; color:#333; padding: 5px;}
      .bold{ font-weight:bold; }
      .row{ border-bottom:1px solid #ccc; }
      .alt{ background-color: #eee; }
      a:visited { color: #800080;}
      .letterLink,.filename{margin-left:20px;}
      .gm-style {
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
      }
      #map {height: 75%; width: 750px; position: relative;}
      #maperror {height: 3%;}
      #legend { background:white; padding:10px; display:none;}
      .panel-heading {cursor:pointer;}
    </style>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    
 <?php setQueryVars($year); ?>

    <meta charset="UTF-8">
    <title>

    <?php

    echo 'Year: ' . $year;

    ?>

    </title>


<!-- Map scripts/resources -->
   <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry"></script>
   <script type="text/javascript" src="map_libraries/OverlappingMarkerSpiderfier.js"></script>
   <script type="text/javascript" src="map_libraries/markerwithlabel.js"></script>
   <script type="text/javascript" src="map_libraries/polyline_labels.js"></script>

   <!-- UI stuff -->
   <script type="text/javascript" src="jquery/jquery-2.1.1.js"></script>
   <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>

   <!-- Custom map script -->
   <script type="text/javascript" src="map_js/map_year.js"></script>
   <script type="text/javascript" src="map_js/create_legend.js"></script>

   </head>
	 <body class="no-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
		
				<div id="header">
				<header>
				  <body onload="load(&#34;<?php echo $year; ?>&#34;)">
					 
    <?php //output goes here! 

        $filename = $array['filename']; //have the raw filename from the table

        

         echo '<h1>View Year: ' . $year . '</h1>'; ?>

				<center>

        <div id="maperror" style="color:#000000"></div>
          <div id="map" style="color:#000000"></div>
          <div id="legend" style="color:#000000"><h3>Legend</h3></div>

          <div id="marker_traveller">
              <div id="traversal"></div><br>
              <button onclick="goto_first_marker()">First Letter</button>
              <button onclick="goto_final_marker()">Final Letter</button><br><br>
              <button onclick="goto_previous_marker()">Previous Letter</button>
              <button onclick="goto_next_marker()">Next Letter</button><br><br>
              <button onclick="reset_map_view()">Reset Map View</button>
              <button onclick="toggle_legend_visibility()">Toggle Legend Visibility</button>
          </div>



				</center>

  

				</header>
				

					

						<!-- Nav -->
						<nav id="nav" color = "white">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li>
									<a href="index.php">Reading The Scrapbook</a>
									<ul>
										<li><a href="index.php">Table of Contents</a></li>
										<li><a href="no-sidebar.html">Search</a></li>
										<li><a href="years.php">Map by Year</a></li>
										<li>
											<a href="#">And a submenu &hellip;</a>
											<ul>
												<li><a href="#">Lorem ipsum dolor</a></li>
												<li><a href="#">Phasellus consequat</a></li>
												<li><a href="#">Magna phasellus</a></li>
												<li><a href="#">Etiam dolore nisl</a></li>
											</ul>
										</li>
										
									</ul>
								</li>
								<li><a href="index#slide">Experiencing WWII</a>
									<ul>
										<li><a href="index.html#letter writing">Letter Writing</a></li>
										<li><a href="index.html#wartime">Wartime Experience</a></li>
										<li><a href="index.html#homefront">Homefront</a></li>
										<li><a href="index.html#overseas">Overseas Experience</a></li>
										<li><a href="index.html#discovering">Discovering America</a></li>
										<li><a href="index.html#race">Race</a></li>
										<li><a href="index.html#women">Women</a></li>
										<li><a href="index.html#teachers">Teachers and Training</a></li>
										<li><a href="index.html#postwar">Postwar Education</a></li>
										<li><a href="index.html#thefallen">The Fallen</a></li>
										<li><a href="index.html#memory">Memory</a></li>
									</ul>
								</li>
								
								<li><a href="index.html#scrapbooking the war">Scrapbooking the War</a>
								  <ul>
											 <li><a href="index.html#Nancy">Nancy Thomspon</a></li>
											 <li><a href="index.html#newark">Newark State Teacher's College</a>
											 	 <ul>
												 <li><a href="#">School Newspaper</a></li>
												 <li><a href="#">Yearbooks</a></li>
												 <li><a href="#">Course Catalog</a></li>
												</ul>
											</li>
											 <li><a href="index.html#scrapbook">Scrapbook</a></li>
											 <li><a href="index.html#serviceman">Serviceman's News</a></li>
											 <li><a href="index.html#project">Project History</a></li>
								  </ul>		
								</li>
								
								
								<li><a href="#">Lesson Plans</a></li>
									<li><a href="#">Historial Analysis</a></li>
							</ul>
						</nav>

				</div>
	 

 

</body>

<!-- <p>IMPORTANT NOTE: AllowEncodedSlashes On *must* be set in the Apache httpd.conf for correct image loading.</p> -->

</html>
