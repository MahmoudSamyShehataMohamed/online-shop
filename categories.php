<?php include 'init.php'; ?>
    <div class='container'>
    	
    	<h1 class='text-center'><?php echo $_GET['PAGE_NAME']; ?></h1>
    	<div class='row'>
    	<?php 
    	foreach(getitems($_GET['PAGE_ID']) as $item){
    		
    		echo "<div class='col-sm-6 col-md-3'>";
    		echo "<span class='price-tag'>".$item['Price']."</span>";
            echo "<div class='thumbnail text-box'>";
            echo "<img class='img-responsive' width='100px' src='layout/images/moto.jpg' alt='item'>";
            echo "<div class='caption'>";
            echo "<h1>".$item['Item_name']."</h1>";
            echo "<p>".$item['Description']."</p>";
            echo "</div>";
            echo "</div>";
    	    echo "</div>";
    	    
    	   
    	    }
        
    	?>
        </div>
    </div>
    
<?php include $tbl.'footer.php'; ?>