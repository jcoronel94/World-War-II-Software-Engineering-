<?php 

  include 'dbinfo.php';

  //open the mysql connection using a PDO interface object
  $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);


  //START -- validate Letter ID

    function setQueryVars(&$LID) {

      $LID = -1;

      if(isset($_GET['letterid']) && !empty($_GET['letterid']) && is_numeric($_GET['letterid'])){
        $LID = $_GET['letterid'];
      }

      else {
        include 'menu.php';
        echo '<p>You seem to be missing some important information. Please <a href="index.php">browse the index</a> to find a letter you would like to view.</p>';

        die();
      }

    }

    function doQuery($LID,$dbh) {

        if($LID > 0){

        //check if LID exists in DB
        $checkLID = $dbh->prepare('SELECT * FROM letters WHERE id = :lid');
        $checkLID->bindValue(':lid',$LID,PDO::PARAM_INT);
        $checkLID->execute();

          if($checkLID->rowCount() == 0) { 
            $LID = -1; 
          }
        }

        if($LID <= 0){
        //force them to redirect
        //header("Location: search.php");

        include 'menu.php';
        //or give them a message with a link
        echo '<p>You seem to be missing some important information. Please <a href="index.php">browse the index</a> to find a letter you would like to view.</p>';
      
        die(); //halts further page processing, similar to System.exit()
        }

        else {

          //ret results when LID > 0 AND rowCount() != 0
          $results = $checkLID->fetch();
          return $results;
        }

    }

    function printTranscript($filename) {

        $filename = $filename . ".txt"; //here is the final filename ready to go

        //$textfoldername = "C:\\wamp\\www\\letters\\text\\"; //this will need to be changed
        //$textpathname = $textfoldername . $filename;

        $textpathname = "text/" . $filename; //complete path ready to be used!

        if(file_exists($textpathname)) {

        $textoutput = file_get_contents($textpathname, "r") or die("can't open file: $php_errormsg");

        $textoutput = nl2br($textoutput); //prep output
        $textoutput = str_replace("\t",'&nbsp; &nbsp; &nbsp; &nbsp;',$textoutput); //prep output more
        print $textoutput;
        //echo '<br>';

        }

        else echo "Letter transcription is not available at this time. <br>";
    }

    function printImageThumbnails($filename,$LID) {

        $imagename = $filename . "*.jp*"; //spooky code, need to make it easier to read later -- do this because there is .jpg AND .jpeg in the data

        $imagepathname = "images/" . $imagename; //complete path ready to be used!

        $images = glob($imagepathname); //grab all the images assoctiated with this particular letter

        $imgcount = 0;

        if($images) {

          foreach($images as $var) {  //this whole loop innard has to change when the images are actually on server
            //$var = rawurlencode($var); //ONLY WORKS LIKE THIS IF AllowEncodedSlashes On in apache httpd.conf
            //$var = str_replace("%2F","/",$var);

            $imgcount++;

            $string_array = explode("/",$var);

            $thumbs = "thumbs/" . $string_array[1]; //gives thumbs/filename.jpg
            $highres = "images/" . $string_array[1]; //gives images/filename.jpg

            $thumbs = htmlentities($thumbs, ENT_QUOTES, "UTF-8");
            $highres = htmlentities($highres, ENT_QUOTES, "UTF-8");

            $thumbstring= '<img src="' . $thumbs . '" >';
            
            if($imgcount === 1) { //the first image

              echo '<div id="carousel" class="carousel slide" style="width:750px !important;">';

              //indicators
              echo '<ol class="carousel-indicators"></ol>';

              //carousel inner class
              echo '<div class="carousel-inner" role="listbox" style="width:750px !important;">';

              echo '<div class="item active" style="max-height:400px;max-width:750px;">';
            } //endif oneimage

            else { //on image 2 or higher
              echo '<div class="item" style="max-height:400px;max-width:750px;">';
            } //endif greater than one image

                echo $thumbstring;
                echo '<div class="carousel-caption" style="margin: 0 auto; height:200px;">';
                  echo '<a href="' . 'letterimages.php?letterid=' . $LID . '&imgnum=' . $imgcount . '">' . $filename . '</a>';
                  //echo '<a href="' . $highres . '">' . $filename . '</a>';//href on caption only!
                  //echo '<a href=' . $var . '>';//href on image, not caption
                echo '</div>';
              echo '</div>';
          } //end foreach image link loop  
        } //endif images exist

      if($imgcount !== 0) {
            echo '</div>'; //end of the carousel-inner

            echo '<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">';
              echo '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
              echo '<span class="sr-only">Previous</span>';
              echo '</a>';
            echo '<a class="right carousel-control" href="#carousel" role="button" data-slide="next">';
              echo '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
              echo '<span class="sr-only">Next</span>';
              echo '</a>';

            echo '</div>';  //end of the carousel
      } //endif

      if($imgcount === 0) {
        echo "Letter scans are not available at this time. <br>";
      } //endif
    } //endfunction
?>

<html>

   <head>
	<title>Nancy Thompson WWII Scrapbook - Letter</title>
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
    
<?php

     setQueryVars($LID); //initalize vars 

     $array = doQuery($LID,$dbh); ?>

    <meta charset="UTF-8">

    <title>

    <?php

    echo 'Letter: ' . $array['filename'];

    ?>
    </title>

    <!-- Map scripts/resources -->
   <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>

   <!-- UI stuff -->
	  <!-- UI stuff -->
   <script type="text/javascript" src="assets/js/jquery-2.1.1.js"></script>
   <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>

   <!-- Custom map script -->
   <script type="text/javascript" src="map_js/map_letter.js"></script>
   <script type="text/javascript" src="map_js/create_legend.js"></script>

   </head>
	 <body class="no-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
		
				<div id="header">
				<header>
				   <body onload="load(&#34;<?php echo $LID; ?>&#34;)">
					 
    <?php //output goes here! 

        $filename = $array['filename']; //have the raw filename from the table

        include 'menuletter.php';

        echo '<h1>View Letter: ' . $filename . '</h1>'; ?>
				<center>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselctable="true">

          <div class="panel panel-default" style="width:775px">
            <div class="panel-heading" role="tab" id="ViewTranscript" data-toggle="collapse" data-parent="#accordion" data-target="#collapseViewTranscript">
              <h2 class="panel-title">
                <a class="accordion-toggle">

                  Transcript

                </a>
              </h2>
            </div>
            <div id="collapseViewTranscript" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ViewTranscript">
              <div class="panel-body">

        <font color = "black"><?php printTranscript($filename); ?></font>

              </div>
            </div>
          </div>

          <div class="panel panel-default" style="width:775px">
            <div class="panel-heading" role="tab" id="ViewImages" data-toggle="collapse" data-parent="#accordion" data-target="#collapseViewImages">
              <h2 class="panel-title">
                <a class="accordion-toggle">

                  Images

                </a>
              </h2>
            </div>
            <div id="collapseViewImages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ViewImages">
              <div class="panel-body">

        <font color = "black"><?php printImageThumbnails($filename,$LID); ?></font>

              </div>
            </div>
          </div>

          <div class="panel panel-default" style="width:775px">
            <div class="panel-heading" role="tab" id="ViewMap" data-toggle="collapse" data-parent="#accordion" data-target="#collapseViewMap">
              <h2 class="panel-title">
                <a class="accordion-toggle">

                  Mapping

                </a>
              </h2>
            </div>
            <div id="collapseViewMap" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ViewMap">
              <div class="panel-body">

                <div id="maperror" style="color:#000000"></div>
                <div id="map" style="color:#000000"></div>
                <div id="legend" style="color:#000000"><h3> <font color = "black">Legend</h3></font></div>
                <div id="button_container"><br><button onclick="reset_map_view()">Reset Map View</button>
                <button onclick="toggle_legend_visibility()">Toggle Legend Visibility</button></div>

              </div>
            </div>
          </div>
        </div>
				</center>

      <!-- <p>IMPORTANT NOTE: AllowEncodedSlashes On *must* be set in the Apache httpd.conf for correct image loading.<br>
      TODO: make the text and images display nicer<br>
      TODO: create dropdowns for the text and images to make presentation a lot cleaner<br></p> -->
   </body>

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
