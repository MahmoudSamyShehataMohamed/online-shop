<?php
    //pages:(Mnage, Edit=>Update, Add=>Insert, Delete , Statistics)
    
    $do="";
    if(isset($_GET['do']))
    {
        $do = $_GET['do'];
    }   
    else
    {
    	$do = 'Mange';
    }

    if($do == 'Mange')
    {
    	echo "welcome to manage page";
    	echo '<a href="page.php?do=Add">Add new category +</a>';
    }
    else if($do == 'Add')
    {
    	echo "Welcome to Add page";
    }
    
    else if($do == 'Insert')
    {
    	echo "Welcome to Insert page";
    }
    else if($do == 'Edit')
    {
    	echo "Welcome to Edit page";
    }
    else if($do == 'Ubdate')
    {
    	echo "Welcome to Ubdate page";
    }
    else if($do == 'Delete')
    {
    	echo "you are in delet page you can delet Delete";
    }
    else
    {
    	echo "There is no page with this name";
    }