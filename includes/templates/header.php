<!DOCTYPE html>
	<head>
		 <meta charset="UTF-8">
		 <meta name="descriptin" content="Welcome to my website ecommerce shop">
		 <title><?php gettitle() ?></title>
		
		 <!--this meta for mobile resosnsive (first-mobile meta)-->
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

         <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
        
         <!-- this is for normalization btzbt el khotot we eldenia for reset-->
         

         <!--CSS FILE-->	
		 <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">

         <!-- <link rel="stylesheet" href="<?php  $css; ?>normalize.css">-->
		 <!--font awesome-->
		 <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
		 <link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css">
		 <link rel="stylesheet" href="<?php echo $css; ?>brands.css">
		 <link rel="stylesheet" href="<?php echo $css; ?>solid.css">
		
    </head>
          <div class='upper-bar'>
              <div class='container'> 
                <?php 
                    if(isset($_SESSION['user_name']))
                    {
                    	echo 'Welcome '.$_SESSION['user_name'];
                    }
                    else{
                ?>
	                <a href="login.php">
	              	<span class='text-right'>Login </span>
	                </a>       
	                /         
	          		<a href="signup.php">
	              	<span class='text-right'> Signup</span>
	                </a>
	            <?php
                    }
                ?>
               

              </div>
          </div>
	      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <!--link-->
		  <div class="container">
		  <a class="navbar-brand" href="index.php"><?Php echo lang('home'); ?></a>

		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="nav navbar-nav ml-auto">
		    	<?php 
                    foreach(getcat() as $cat)
                    {
                    	echo "
		                <li class='nav-item'>
				        <a class='nav-link' href='categories.php?PAGE_ID=".$cat['Id']."&PAGE_NAME=".str_replace(' ','-',$cat['Name'])."'>
				        ".$cat['Name']."</a>
				        </li>
				        ";
				    }
		           
		    	?>
		    </ul>
		  </div>
		  </div>
	      </nav>
    <body>