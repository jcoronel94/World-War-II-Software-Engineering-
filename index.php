

<!--
	Search Function
-->
<?php 
  
  //initialize some helper vars

  $firstname = NULL;
  $lastname = NULL;
  $middlename = NULL;
  $specialty = NULL;

  $datacount = 0;
  $namelength = 3;
  $middlenamelength = 1;

  $months = array("--" => "--",
                  "01" => "January",
                  "02" => "February",
                  "03" => "March",
                  "04" => "April",
                  "05" => "May",
                  "06" => "June",
                  "07" => "July",
                  "08" => "August",
                  "09" => "September",
                  "10" => "October",
                  "11" => "November",
                  "12" => "December");

  $querystring = 'SELECT * FROM letters, locdata WHERE';
  $errortext = NULL;

  if (isset($_GET['firstname']) && !empty($_GET['firstname']))
    $hasSubmittedFirstName = TRUE;
  else
    $hasSubmittedFirstName = FALSE;
  
  if (isset($_GET['lastname']) && !empty($_GET['lastname']))
    $hasSubmittedLastName = TRUE;
  else
    $hasSubmittedLastName = FALSE;

  if (isset($_GET['middlename']) && !empty($_GET['middlename']))
    $hasSubmittedMiddleName = TRUE;
  else
    $hasSubmittedMiddleName = FALSE;

  if (isset($_GET['specialty']) && !empty($_GET['specialty']))
    $hasSubmittedSpecialty = TRUE;
  else
    $hasSubmittedSpecialty = FALSE;

  if (isset($_GET['street']) && !empty($_GET['street']))
    $hasSubmittedStreet = TRUE;
  else
    $hasSubmittedStreet = FALSE;

  if (isset($_GET['city']) && !empty($_GET['city']))
    $hasSubmittedCity = TRUE;
  else
    $hasSubmittedCity = FALSE;

  if (isset($_GET['state']) && !empty($_GET['state']))
    $hasSubmittedState = TRUE;
  else
    $hasSubmittedState = FALSE;

  if (isset($_GET['country']) && !empty($_GET['country']))
    $hasSubmittedCountry = TRUE;
  else
    $hasSubmittedCountry = FALSE;

  if (isset($_GET['zipcode']) && !empty($_GET['zipcode']))
    $hasSubmittedZipcode = TRUE;
  else
    $hasSubmittedZipcode = FALSE;

  $gender = isset($_GET['gender']) && !ctype_space($_GET['gender']) ? $_GET['gender'] : "-";
  $service_branch = isset($_GET['service_branch']) && !ctype_space($_GET['service_branch']) ? $_GET['service_branch'] : "-";

  $orderType = isset($_GET['OrderType']) && !ctype_space($_GET['OrderType']) ? $_GET['OrderType'] : "chrono";

  $day = isset($_GET['day']) && !ctype_space($_GET['day']) ? $_GET['day'] : "--";
  $month = isset($_GET['month']) && !ctype_space($_GET['month']) ? $_GET['month'] : "--";
  $year = isset($_GET['year']) && !ctype_space($_GET['year']) ? $_GET['year'] : "----";
?>



<html>
	 <head>
	<title>Nancy Thompson WWII Scrapbook - Search functions</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	 
    <style type="text/css">
      body{ height: 100%; font-family: "Lucida Sans", Trebuchet, monospace; }
      .searchTermBox{ border:solid 1px #333; font-weight:bold; color:#333; padding: 5px;}
      .bold{ font-weight:bold; }
			
			.select-sty select {
  		 
   		 width: 268px;
   		 padding: 5px;
   		 font-size: 16px;
   		 line-height: 1;
  		  border: 0;
   			border-radius: 0;
   			height: 34px;
  			
   }
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
		 <!-- UI stuff -->
   <script type="text/javascript" src="assets/js/jquery-2.1.1.js"></script>
   <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	 
	   <!-- small script for dropdown redirection -->
   <script type="text/javascript">

   //listen when the document is ready
   $(document).ready(function() {

      $("#yearDropdown").on('change', function() {

          if($("#yearDropdown option:selected").index() !== 0) {

            window.location.href = $("#yearDropdown").val();
          }
      }); //end select listener

    }); //end doc ready listener

   </script>
		
		
		</head>
	<body class="no-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header">
				
				<div class="inner">
				<header>
				
				 <div class = "row %50">
				<left>
						<p><h1>Search the Scrapbook by Year &nbsp;&nbsp;</h1></p></left>
						
						<right><p><h1>&nbsp;&nbsp;Search the Scrapbook by Author</h1></p>
					</right>
				</div>
				
				
		
				<div class = "row">
				<p>
				<div class = "select-sty">
				    <select name="yearDropdown" id="yearDropdown"  style="color:black">
    		    <option value="">----</option>
    				<option value="viewyear.php?year=All">All</option>
    				<option value="viewyear.php?year=1941">1941</option>
    				<option value="viewyear.php?year=1942">1942</option>
    				<option value="viewyear.php?year=1943">1943</option>
    				<option value="viewyear.php?year=1944">1944</option>
    				<option value="viewyear.php?year=1945">1945</option>
    				<option value="viewyear.php?year=1946">1946</option>
    				<option value="viewyear.php?year=1950">1950</option>
  					</select>
						</p>
						</div>
						
			
			
				
				
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>
				
			
			
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			
				<?php 

      include 'dbinfo.php';

      	try {

            /****************************
            * 
            * For DB in this web application part of the WW2 Letters project,
            * we're going to use the PHP Data Objects (PDO) library
            * Documentation on PDO: http://www.php.net/manual/en/book.pdo.php
            *
            ****************************/

	           $pdostring = 'mysql:host=' . $host . ';dbname=' . $dbname;

             //open the mysql connection using a PDO interface object
             $dbh = new PDO($pdostring, $user, $pass);
             
             //VERY ROUGH output of Query Array, first 10 rows of DB

             //thinking of making each toc entry hyperlink to a search result for that particular person
             //requires toc.php to change to GET instead of POST, and be able to pull the parameters out of the URL
             //TODO: get the names from $row here to properly escape

             $ncount = 0;

             echo  '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

              echo  '<div class="panel panel-default" style="width:300px">';
                echo  '<div class="panel-heading" role="tab" id="ViewA-M" data-toggle="collapse" data-parent="#accordion" data-target="#collapseViewA-M">';
                  echo '<h2 class="panel-title" style="text-align:center">';
                    echo '<a class="accordion-toggle">';
                      echo 'A-M';
                    echo '</a>';
                  echo '</h2>';
                echo '</div>';

              echo '<div id="collapseViewA-M" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ViewA-M">';
                echo '<div class="panel-body">';

             foreach($dbh->query('SELECT lastname,firstname, COUNT(*) AS "numOfLetters" from letters GROUP BY lastname, firstname;') as $row) {
                 //var_dump($row);
                 //print_r($row); echo '<br/><br/>';

                 if(strtolower(substr($row['lastname'],0,1)) > "m") { //the letter would be "n, o, p, q, r, s, t..."
                    $ncount++;
                 } 

                 if($ncount === 1) {

                  echo '</div>';
                  echo '</div>';
                  echo '</div>'; //close out the A-M accordion divs

                  //start the N-Z accordion div
                  echo  '<div class="panel panel-default" style="width:300px">';
                    echo  '<div class="panel-heading" role="tab" id="ViewN-Z" data-toggle="collapse" data-parent="#accordion" data-target="#collapseViewN-Z">';
                      echo '<h2 class="panel-title" style="text-align:center">';
                        echo '<a class="accordion-toggle">';
                          echo 'N-Z';
                        echo '</a>';
                      echo '</h2>';
                    echo '</div>';

                  echo '<div id="collapseViewN-Z" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ViewN-Z">';
                    echo '<div class="panel-body">';

                 }

                 //hard-to-read echo, can break the URL into a query string variable if desired
                 echo '<a href="viewauthor.php?firstname=' . urlencode($row['firstname']) . '&lastname=' . urlencode($row['lastname']) . '"><p class="resultRow"><span class="lastname">' . $row['lastname'] . ',' . ' </span><span class="firstname">' . $row['firstname'] . ' (</span><span class="numOfLetters">' . $row['numOfLetters'] . '</span> letters)</p></a>';
             }

             if ($ncount > 0) { //if we ever even made the n-z div

                  echo '</div>';
                  echo '</div>';
                  echo '</div>'; //close out the N-Z accordion divs
             }

             //in either case, close out the panel-group div
             echo '</div>';

             $dbh = null; //connection closed
         } catch (PDOException $e) {
             print "Error!: " . $e->getMessage() . "<br/>";
             die();
         }

      ?> </p>
			</div>
			</div>
			
			
  </header>
				
	
	
	
	<div class="wrapper style1">
	<body>
				<h1>Search the Scrapbook by Inputs</h1>
				
				<?php

      if(strcmp($day,"--") != 0)
        $datacount++;

      if(strcmp($month,"--") != 0)
        $datacount++;

      if(strcmp($year,"----") != 0)
        $datacount++;

      if(strcmp($gender,"-") != 0)
        $datacount++;

      if(strcmp($service_branch,"-") != 0)
        $datacount++;

      if($hasSubmittedFirstName) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here

        $firstname = str_replace(array('%','_'),'',$_GET['firstname']);
        $firstname = trim($firstname);

        if(ctype_space($firstname)){
        $hasSubmittedFirstName = FALSE;
        $errortext .= "<font color=\"red\">First name not searched:</font> Invalid first name. Please enter a keyword. <br>";
        }

        if(strlen($firstname) < $namelength){
        $hasSubmittedFirstName = FALSE;
        $errortext .= "<font color=\"red\">First name not searched:</font> First name is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedFirstName) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedLastName) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $lastname = str_replace(array('%','_'),'',$_GET['lastname']);
        $lastname = trim($lastname);

        if(ctype_space($lastname)){
        $hasSubmittedLastName = FALSE;
        $errortext .= "<font color=\"red\">Last name not searched:</font> Invalid last name. Please enter a keyword. <br>";
        }

        if(strlen($lastname) < $namelength){
        $hasSubmittedLastName = FALSE;
        $errortext .= "<font color=\"red\">Last name not searched:</font> Last name is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedLastName) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedMiddleName) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $middlename = str_replace(array('%','_'),'',$_GET['middlename']);
        $middlename = trim($middlename);

        if(ctype_space($middlename)){
        $hasSubmittedMiddleName = FALSE;
        $errortext .= "<font color=\"red\">Middle name not searched:</font> Invalid middle name. Please enter a keyword. <br>";
        }

        if(strlen($middlename) < $middlenamelength){
        $hasSubmittedMiddleName = FALSE;
        $errortext .= "<font color=\"red\">Middle name not searched:</font> Middle name is too short. Please enter a keyword of at least " . $middlenamelength . " characters. <br>";
        }

        if($hasSubmittedMiddleName) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedSpecialty) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $specialty = str_replace(array('%','_'),'',$_GET['specialty']);
        $specialty = trim($specialty);

        if(ctype_space($specialty)){
        $hasSubmittedSpecialty = FALSE;
        $errortext .= "<font color=\"red\">Specialty not searched:</font> Invalid specialty. Please enter a keyword. <br>";
        }

        if(strlen($specialty) < $namelength){
        $hasSubmittedSpecialty = FALSE;
        $errortext .= "<font color=\"red\">Specialty not searched:</font> Specialty is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedSpecialty) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedStreet) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $street = str_replace(array('%','_'),'',$_GET['street']);
        $street = trim($street);

        if(ctype_space($street)){
        $hasSubmittedStreet = FALSE;
        $errortext .= "<font color=\"red\">Street not searched:</font> Invalid street. Please enter a keyword. <br>";
        }

        if(strlen($street) < $namelength){
        $hasSubmittedStreet = FALSE;
        $errortext .= "<font color=\"red\">Street not searched:</font> Street is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedStreet) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedCity) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $city = str_replace(array('%','_'),'',$_GET['city']);
        $city = trim($city);

        if(ctype_space($city)){
        $hasSubmittedCity = FALSE;
        $errortext .= "<font color=\"red\">City not searched:</font> Invalid city. Please enter a keyword. <br>";
        }

        if(strlen($city) < $namelength){
        $hasSubmittedCity = FALSE;
        $errortext .= "<font color=\"red\">City not searched:</font> City is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedCity) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedState) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $state = str_replace(array('%','_'),'',$_GET['state']);
        $state = trim($state);

        if(ctype_space($state)){
        $hasSubmittedState = FALSE;
        $errortext .= "<font color=\"red\">State not searched:</font> Invalid state. Please enter a keyword. <br>";
        }

        if(strlen($state) < $namelength){
        $hasSubmittedState = FALSE;
        $errortext .= "<font color=\"red\">State not searched:</font> State is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedState) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedCountry) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $country = str_replace(array('%','_'),'',$_GET['country']);
        $country = trim($country);

        if(ctype_space($country)){
        $hasSubmittedCountry = FALSE;
        $errortext .= "<font color=\"red\">Country not searched:</font> Invalid country. Please enter a keyword. <br>";
        }

        if(strlen($country) < $namelength){
        $hasSubmittedCountry = FALSE;
        $errortext .= "<font color=\"red\">Country not searched:</font> Country is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedCountry) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      if($hasSubmittedZipcode) {
        //VALIDATE INPUT & get user search string for first/last name, store in variable here
        $zipcode = str_replace(array('%','_'),'',$_GET['zipcode']);
        $zipcode = trim($zipcode);

        if(ctype_space($zipcode)){
        $hasSubmittedZipcode = FALSE;
        $errortext .= "<font color=\"red\">Zipcode not searched:</font> Invalid zipcode. Please enter a keyword. <br>";
        }

        if(strlen($zipcode) < $namelength){
        $hasSubmittedZipcode = FALSE;
        $errortext .= "<font color=\"red\">Zipcode not searched:</font> Zipcode is too short. Please enter a keyword of at least " . $namelength . " characters. <br>";
        }

        if($hasSubmittedZipcode) //if there is real data here that will be used
          $datacount++; //add to counter when it is certain there is real data there
      }

      //NOTHING VALID GIVEN

      if($hasSubmittedFirstName == FALSE && $hasSubmittedLastName == FALSE && $hasSubmittedMiddleName == FALSE && $hasSubmittedSpecialty == FALSE && $hasSubmittedStreet == FALSE && $hasSubmittedCity == FALSE && $hasSubmittedState == FALSE && $hasSubmittedCountry == FALSE && $hasSubmittedZipcode == FALSE && strcmp($gender,"-") == 0 && strcmp($service_branch,"-") == 0 && strcmp($day,"--") == 0 && strcmp($month,"--") == 0 && strcmp($year,"----") == 0)
        $errortext .= "<br>Please enter at least one field to search from. <br>"; 

      ?>

			<form name="formSearch" method="get" action="index.php" display="table">
          <div class="container" >
							 
					  <div class = "row">
            <p display="table-row"><label>First name:</label>
            <input name="firstname" type="text" id="firstname" <?php if($hasSubmittedFirstName) echo ' value="'. $firstname .'"';?> >
            </p>

            <p display="table-row"><label>Middle name:</label>
            <input name="middlename" type="text" id="middlename" <?php if($hasSubmittedMiddleName) echo ' value="' . $middlename . '"';?> >
            </p>

            <p display="table-row"><label>Last name:</label>
            <input name="lastname" type="text" id="lastname" <?php if($hasSubmittedLastName) echo ' value="'. $lastname .'"';?> >
            </p>

            <p display="table-row"><label>Gender:</label>
            <select name="gender" id="gender"  style="color:black" >
						 	
              <option value="-" <?php if(ctype_space($gender) || $gender == "-") echo 'selected="true"'; ?> >-</option>
              <option value="M" <?php if(ctype_space($gender) || $gender == "M") echo 'selected="true"'; ?> >M</option>
              <option value="F" <?php if(ctype_space($gender) || $gender == "F") echo 'selected="true"'; ?> >F</option>
            </select>
            </p>
						</div>
						
						<div class = "50%>
            <p display="table-row"><label>Specialty:</label>
            <input name="specialty" type="text" id="specialty" <?php if($hasSubmittedSpecialty) echo ' value="' . $specialty . '"';?> >
            </p>

            <p display="table-row"><label>Service Branch:</label>
            <select name="service_branch" id="service_branch"  style="color:black" >
								
              <option value="-" <?php if(ctype_space($service_branch) || $service_branch == "-") echo 'selected="true"'; ?> >-</option>
              <option value="Army" <?php if(ctype_space($service_branch) || $service_branch == "Army") echo 'selected="true"'; ?> >Army</option>
              <option value="Army (British)" <?php if(ctype_space($service_branch) || $service_branch == "Army (British)") echo 'selected="true"'; ?> >Army (British)</option>
              <option value="Coast Guard" <?php if(ctype_space($service_branch) || $service_branch == "Coast Guard") echo 'selected="true"'; ?> >Coast Guard</option>
              <option value="Harbor Defense" <?php if(ctype_space($service_branch) || $service_branch == "Harbor Defense") echo 'selected="true"'; ?> >Harbor Defense</option>
              <option value="Merchant Marines" <?php if(ctype_space($service_branch) || $service_branch == "Merchant Marines") echo 'selected="true"'; ?> >Merchant Marines</option>
              <option value="Navy" <?php if(ctype_space($service_branch) || $service_branch == "Navy") echo 'selected="true"'; ?> >Navy</option>
              <option value="Red Cross" <?php if(ctype_space($service_branch) || $service_branch == "Red Cross") echo 'selected="true"'; ?> >Red Cross</option>
              <option value="US Marine Corps" <?php if(ctype_space($service_branch) || $service_branch == "US Marine Corps") echo 'selected="true"'; ?> >US Marine Corps</option>
            </select>
            </p>

            <p display="table-row"><label><br></label></p>

            <p display="table-row"><label>Month:</label>
            <select name="month" id="month"  style="color:black" >
							
              <option value="--" <?php if(ctype_space($month) || $month == "--") echo 'selected="true"'; ?> >--</option>
              <option value="01" <?php if(ctype_space($month) || $month == "01") echo 'selected="true"'; ?> >January</option>
              <option value="02" <?php if(ctype_space($month) || $month == "02") echo 'selected="true"'; ?> >February</option>
              <option value="03" <?php if(ctype_space($month) || $month == "03") echo 'selected="true"'; ?> >March</option>
              <option value="04" <?php if(ctype_space($month) || $month == "04") echo 'selected="true"'; ?> >April</option>
              <option value="05" <?php if(ctype_space($month) || $month == "05") echo 'selected="true"'; ?> >May</option>
              <option value="06" <?php if(ctype_space($month) || $month == "06") echo 'selected="true"'; ?> >June</option>
              <option value="07" <?php if(ctype_space($month) || $month == "07") echo 'selected="true"'; ?> >July</option>
              <option value="08" <?php if(ctype_space($month) || $month == "08") echo 'selected="true"'; ?> >August</option>
              <option value="09" <?php if(ctype_space($month) || $month == "09") echo 'selected="true"'; ?> >September</option>
              <option value="10" <?php if(ctype_space($month) || $month == "10") echo 'selected="true"'; ?> >October</option>
              <option value="11" <?php if(ctype_space($month) || $month == "11") echo 'selected="true"'; ?> >November</option>
              <option value="12" <?php if(ctype_space($month) || $month == "12") echo 'selected="true"'; ?> >December</option>
            </select>
            </p>

            <p display="table-row"><label>Day:</label>
            <select name="day" id="day"  style="color:black" >
						 
              <option value="--" <?php if(ctype_space($day) || $day == "--") echo 'selected="true"'; ?> >--</option>
              <option value="01" <?php if(ctype_space($day) || $day == "01") echo 'selected="true"'; ?> >01</option>
              <option value="02" <?php if(ctype_space($day) || $day == "02") echo 'selected="true"'; ?> >02</option>
              <option value="03" <?php if(ctype_space($day) || $day == "03") echo 'selected="true"'; ?> >03</option>
              <option value="04" <?php if(ctype_space($day) || $day == "04") echo 'selected="true"'; ?> >04</option>
              <option value="05" <?php if(ctype_space($day) || $day == "05") echo 'selected="true"'; ?> >05</option>
              <option value="06" <?php if(ctype_space($day) || $day == "06") echo 'selected="true"'; ?> >06</option>
              <option value="07" <?php if(ctype_space($day) || $day == "07") echo 'selected="true"'; ?> >07</option>
              <option value="08" <?php if(ctype_space($day) || $day == "08") echo 'selected="true"'; ?> >08</option>
              <option value="09" <?php if(ctype_space($day) || $day == "09") echo 'selected="true"'; ?> >09</option>
              <option value="10" <?php if(ctype_space($day) || $day == "10") echo 'selected="true"'; ?> >10</option>
              <option value="11" <?php if(ctype_space($day) || $day == "11") echo 'selected="true"'; ?> >11</option>
              <option value="12" <?php if(ctype_space($day) || $day == "12") echo 'selected="true"'; ?> >12</option>
              <option value="13" <?php if(ctype_space($day) || $day == "13") echo 'selected="true"'; ?> >13</option>
              <option value="14" <?php if(ctype_space($day) || $day == "14") echo 'selected="true"'; ?> >14</option>
              <option value="15" <?php if(ctype_space($day) || $day == "15") echo 'selected="true"'; ?> >15</option>
              <option value="16" <?php if(ctype_space($day) || $day == "16") echo 'selected="true"'; ?> >16</option>
              <option value="17" <?php if(ctype_space($day) || $day == "17") echo 'selected="true"'; ?> >17</option>
              <option value="18" <?php if(ctype_space($day) || $day == "18") echo 'selected="true"'; ?> >18</option>
              <option value="19" <?php if(ctype_space($day) || $day == "19") echo 'selected="true"'; ?> >19</option>
              <option value="20" <?php if(ctype_space($day) || $day == "20") echo 'selected="true"'; ?> >20</option>
              <option value="21" <?php if(ctype_space($day) || $day == "21") echo 'selected="true"'; ?> >21</option>
              <option value="22" <?php if(ctype_space($day) || $day == "22") echo 'selected="true"'; ?> >22</option>
              <option value="23" <?php if(ctype_space($day) || $day == "23") echo 'selected="true"'; ?> >23</option>
              <option value="24" <?php if(ctype_space($day) || $day == "24") echo 'selected="true"'; ?> >24</option>
              <option value="25" <?php if(ctype_space($day) || $day == "25") echo 'selected="true"'; ?> >25</option>
              <option value="26" <?php if(ctype_space($day) || $day == "26") echo 'selected="true"'; ?> >26</option>
              <option value="27" <?php if(ctype_space($day) || $day == "27") echo 'selected="true"'; ?> >27</option>
              <option value="28" <?php if(ctype_space($day) || $day == "28") echo 'selected="true"'; ?> >28</option>
              <option value="29" <?php if(ctype_space($day) || $day == "29") echo 'selected="true"'; ?> >29</option>
              <option value="30" <?php if(ctype_space($day) || $day == "30") echo 'selected="true"'; ?> >30</option>
              <option value="31" <?php if(ctype_space($day) || $day == "31") echo 'selected="true"'; ?> >31</option>
            </select>
            </p>

            <p display="table-row"><label>Year:</label>
            <select name="year" id="year"  style="color:black" >
						  
              <option value="----" <?php if(ctype_space($year) || $year == "----") echo 'selected="true"'; ?> >----</option>
              <option value="1941" <?php if(ctype_space($year) || $year == "1941") echo 'selected="true"'; ?> >1941</option>
              <option value="1942" <?php if(ctype_space($year) || $year == "1942") echo 'selected="true"'; ?> >1942</option>
              <option value="1943" <?php if(ctype_space($year) || $year == "1943") echo 'selected="true"'; ?> >1943</option>
              <option value="1944" <?php if(ctype_space($year) || $year == "1944") echo 'selected="true"'; ?> >1944</option>
              <option value="1945" <?php if(ctype_space($year) || $year == "1945") echo 'selected="true"'; ?> >1945</option>
              <option value="1946" <?php if(ctype_space($year) || $year == "1946") echo 'selected="true"'; ?> >1946</option>
              <option value="1950" <?php if(ctype_space($year) || $year == "1950") echo 'selected="true"'; ?> >1950</option>
            </select>
            </p>

            <p display="table-row"><label><br></label></p>
						
						</div>
						
						<div class = "row 50%">

            <p display="table-row"><label>Street:</label>
            <input name="street" type="text" id="street" <?php if($hasSubmittedStreet) echo ' value="'. $street .'"';?> >
            </p>

            <p display="table-row"><label>City:</label>
            <input name="city" type="text" id="city" <?php if($hasSubmittedCity) echo ' value="'. $city .'"';?> >
            </p>

            <p display="table-row"><label>State:</label>
            <input name="state" type="text" id="state" <?php if($hasSubmittedState) echo ' value="'. $state .'"';?> >
            </p>
						
						</div>
						
						
						<div class = "row 50%">
            <p display="table-row"><label>Country:</label>
            <input name="country" type="text" id="country" <?php if($hasSubmittedCountry) echo ' value="'. $country .'"';?> >
            </p>

            <p display="table-row"><label>Zipcode:</label>
            <input name="zipcode" type="text" id="zipcode" <?php if($hasSubmittedZipcode) echo ' value="'. $zipcode .'"';?> >
            </p>
						
						</div>

            <p display="table-row"><label><br></label></p>

						<div class = "row 50%">
            <p display="table-row"><label>Sort results:</label>
            <select  style="color:black" name="OrderType" id="OrderType">

              <option value="fname" <?php if(ctype_space($orderType) || $orderType == "fname") echo 'selected="true"'; ?> >By First Name</option>
              <option value="lname" <?php if(ctype_space($orderType) || $orderType == "lname") echo 'selected="true"'; ?> >By Last Name</option>
              <option value="chrono" <?php if(ctype_space($orderType) || $orderType == "chrono") echo 'selected="true"'; ?> >Chronologically</option>
            </select>
            </p>
						</div?

            <p display="table-row"><label><br></label></p>
						<div class = "row 75%>
            <p display="table-row"><label></label>
            <input type="submit" value="Search">
            </p>
						</div>
          </div>
					
      </form>
			</body>
			</div>
	
	
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
</html>