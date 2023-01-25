<?php
//Categories page
ob_start();
session_start();
$pagetitle='Categories';
if(isset($_SESSION['username']))
{	
include "init.php";

if(isset($_GET['do']))
{
	$do = $_GET['do'];
}
else
{
	$do ='Manage';
}

if($do == 'Manage')
{
    $stmt2=$con->prepare("SELECT * FROM categories ORDER BY Id DESC");
	$stmt2->execute();
	$cats=$stmt2->fetchall();
    if(!empty($cats)){
    ?>

	<h1 class="text-center">Manage Categories</h1>
	<div class="categories">
		<div class="container">
			<div class="panel panel-default">
			    <div class="panel-heading"><i class='fa fa-edit'></i> Manage Category</div>
			        <div class="panel-body">       
			        	<?php
			        	foreach($cats as $cat)
			        	{
			        		echo "<div class='cat'>";
			        		    echo "<div class='hidden-buttons'>";
			        		    echo "<a href='categories.php?do=Edit&CAT_ID=".$cat['Id']."' class='btn  btn-primary btn-sm'><i class='fa fa-edit'></i> Edit</a>";
			        		    echo "<a href='categories.php?do=Delete&CAT_ID=".$cat['Id']."' class='btn  btn-danger btn-sm'><span aria-hidden='true'>&times;</span> Delete</a>";
			        		    echo "</div>";
                            echo "<h3>" .$cat['Name'] . "</h3>";

                            echo "<p>";
                             if($cat['Description'] == '')
                             	{
                             		echo "This Category Has No Description";
                             	} 
                             	else
                             	{
                             			echo $cat['Description'];
                             	}
                            echo "</p>";

                            if($cat['Visibility'] == 0)
                            	{
                            		echo "<span class='visibility'><i class='fa fa-eye'></i> Hidden</span>";
                                }

                            if($cat['Allow_comments'] == 0)
                            	{
                            	echo "<span class='commenting'><span aria-hidden='true'>&times;</span> Comment Disable</span>";
                                } 

                            if($cat['Allow_ads'] == 0)
                            	{
                            	echo "<span class='advertises'><span aria-hidden='true'>&times;</span> Ads Disable</span>";
                                } 

                            echo "</div>";

                            echo "<hr>";
			        	}
			        	?>
			        </div>
			</div>
			<a href="categories.php?do=Add"><div  class='add-category btn btn-primary btn-sm'><i class="fa fa-plus"></i> Add New Category</div></a>
	    </div>
   </div>
   <?php }else{
            echo "<div class='container'>";
            echo "<div class='alert alert-info'>There is no categories to show</div>";
            echo "<a href='categories.php?do=Add'><div  class='add-category btn btn-primary btn-sm'><i class='fa fa-plus'></i> Add New Category</div></a>";
            echo "</div>";
   } ?>

    <?php 
}
elseif($do == 'Add')
{
?>
     
<h1 class="text-center">Add New Category</h1>
 <div class="container">
 <form action="categories.php?do=Insert" method="POST">

  <div class="form-group row">
    <label for="inputEmail" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control"autocomplete="off" 
      required="required">
    </div>
  </div>

  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-8">
      <input type="text" name="description" class="form-control">
    </div>
  </div>

  <div class="form-group row">
    <label for="inputemail" class="col-sm-2 col-form-label">Ordering</label>
    <div class="col-sm-8">
      <input type="text" name="ordering" class="form-control">
    </div>
  </div>

  <div class="form-group row">
    <label for="inputfullname" class="col-sm-2 col-form-label">Visible</label>
    <div class="col-sm-8">
        <div>
        	<input id="vis-yes" type="radio" name="visibility" value="1" checked>
        	<label for="vis-yes">Yes</label>
        </div>
        <div>
        	<input id="vis-no" type="radio" name="visibility" value="0">
        	<label for="vis-no">No</label>
        </div>
    </div>
  </div>

  <div class="form-group row">
    <label for="inputfullname" class="col-sm-2 col-form-label">Allow Commenting</label>
    <div class="col-sm-8">
        <div>
        	<input id="com-yes" type="radio" name="commenting" value="1" checked>
        	<label for="com-yes">Yes</label>
        </div>
        <div>
        	<input id="com-no" type="radio" name="commenting" value="0">
        	<label for="com-no">No</label>
        </div>
    </div>
  </div>

  <div class="form-group row">
    <label for="inputfullname" class="col-sm-2 col-form-label">Allow Ads</label>
    <div class="col-sm-8">
        <div>
        	<input id="ads-yes" type="radio" name="ads" value="1" checked>
        	<label for="ads-yes">Yes</label>
        </div>
        <div>
        	<input id="ads-no" type="radio" name="ads" value="0">
        	<label for="ads-no">No</label>
        </div>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-8">
      <button type="submit" class="btn btn-primary btn-sm">Add Category</button>
    </div>
  </div>
</form>
</div>            

<?php
}elseif($do == 'Insert')
{

echo "<div class='container'>";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//
    
    echo "<h1 class='text-center'>".'Insert Category'."</h1>";
    //get data from user by POST
    $name=$_POST['name'];
    $desc=$_POST['description'];
    $order=$_POST['ordering'];
    $visible=$_POST['visibility'];
    $comment=$_POST['commenting'];
    $ads=$_POST['ads'];
   
    //DB 
    //check if user exist in DB
    $check=checkitem("Name","categories",$name);
    if($check == 1)
    {
        $themsg ="<div class='alert alert-danger'>" . "Sorry This category Is Exist"
         . "</div>";
         redirecthome($themsg,'back');
    }
    else
    {
    $stmt=$con->prepare("INSERT INTO
    categories(Name,Description,Ordering,Visibility,Allow_Comments,Allow_ads) 
    VALUES(?, ?, ?, ?, ?, ?) ");
    $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads));
    $themsg = "<div class='alert alert-success'>"
    . $stmt->rowcount()
    . " Record Added"
    ."</div>";
    }
    redirecthome($themsg,'back');
    //Another code for insert to DB  
    /*$stmt=$con->prepare("INSERT INTO
    users(Username,Password,Email,Fullname) 
    VALUES(:zusername, :zpassword,:zemail,:zfullname)");
    $stmt->execute(array(
        'zusername' => $username,
        'zpassword' => $hashedpass,
        'zemail'    => $email,
        'zfullname' => $fullname
     ));


     echo "<div class='alert alert-success'>". $stmt->rowcount() . " Record Inserted" ."</div>";
     */

   
}

else
{

    $themsg="<div class='alert alert-danger'>"."Sorry you can't browse this page directly". "</div>";
    redirecthome($themsg,'back');
}

    
echo "</div>";

}
elseif($do == 'Edit')
{
        echo "<div class='container'>";

        if(isset($_GET['CAT_ID']) && is_numeric($_GET['CAT_ID']))
        {
            $CAT_ID=intval($_GET['CAT_ID']);
        }
        else
        {
            $CAT_ID=0;
        }
        
        //check if the item is exist in DB or not
        //and we must get data to print in hoookoool beacause itis edit page
        $stmt=$con->prepare("SELECT * FROM categories WHERE Id=?");
        $stmt->execute(array($CAT_ID));
        $cat=$stmt->fetch();
        $count=$stmt->rowcount();
        if($count > 0)
        { ?>

		<h1 class="text-center">Edit New Category</h1>
		 <div class="container">
		 <form action="categories.php?do=Update" method="POST">
             <input type="hidden" name="category_id" value="<?php echo $cat['Id']; ?>">
		  <div class="form-group row">
		    <label for="inputEmail" class="col-sm-2 col-form-label">Name</label>
		    <div class="col-sm-8">
		      <input type="text" name="category_name" required="required" class="form-control" value="<?php echo $cat['Name']?>">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
		    <div class="col-sm-8">
		      <input type="text" name="description" class="form-control" value="<?php echo $cat['Description']?>">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputemail" class="col-sm-2 col-form-label">Ordering</label>
		    <div class="col-sm-8">
		      <input type="text" name="ordering" class="form-control" value="<?php echo $cat['Ordering']?>">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputfullname" class="col-sm-2 col-form-label">Visible</label>
		    <div class="col-sm-8">
		        <div>
		        	<input id="vis-yes" type="radio" name="visible" value="1" <?php if($cat['Visibility'] == 1){echo 'checked'; }?>>
		        	<label for="vis-yes">Yes</label>
		        </div>
		        <div>
		        	<input id="vis-no" type="radio" name="visible" value="0" <?php if($cat['Visibility'] == 0){echo 'checked'; }?>>
		        	<label for="vis-no">No</label>
		        </div>
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputfullname" class="col-sm-2 col-form-label">Allow Commenting</label>
		    <div class="col-sm-8">
		        <div>
		        	<input id="com-yes" type="radio" name="comment" value="1" <?php if($cat['Allow_comments'] == 1){echo 'checked'; }?>>
		        	<label for="com-yes">Yes</label>
		        </div>
		        <div>
		        	<input id="com-no" type="radio" name="comment" value="0"  <?php if($cat['Allow_comments'] == 0){echo 'checked'; }?>>
		        	<label for="com-no">No</label>
		        </div>
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputfullname" class="col-sm-2 col-form-label">Allow Ads</label>
		    <div class="col-sm-8">
		        <div>
		        	<input id="ads-yes" type="radio" name="advertise" value="1" <?php if($cat['Allow_ads'] == 1){echo 'checked'; }?>>
		        	<label for="ads-yes">Yes</label>
		        </div>
		        <div>
		        	<input id="ads-no" type="radio" name="advertise" value="0" <?php if($cat['Allow_ads'] == 0){echo 'checked'; }?>>
		        	<label for="ads-no">No</label>
		        </div>
		    </div>
		  </div>

		  <div class="form-group row">
		    <div class="col-sm-8">
		      <button type="submit" class="btn btn-primary btn-sm">Update Category</button>
		    </div>
		  </div>
		</form>
		</div>            
		       	

       <?php  }
        else
        {
            $themsg="<div class='alert alert-danger'>"."There is no such ID "."</div>";
            redirecthome($themsg);

        }
        ?>

         </div>
    <?php	
}
elseif($do == 'Update')
{
		echo "<div class='container'>";
		if($_SERVER['REQUEST_METHOD']== 'POST')
		{
		echo "<h1 class='text-center'>" . "Update Category" . "</h1>";
		$cat_name = $_POST['category_name'];
		$desc     = $_POST['description'];
		$order    = $_POST['ordering'];
		$vis      = $_POST['visible'];
		$com      = $_POST['comment'];
		$ad       = $_POST['advertise'];
		$cat_id   = $_POST['category_id'];

		if(!empty($cat_name)){
		$stmt=$con->prepare('UPDATE categories SET Name=? , Description = ?, Visibility = ?,Ordering = ?,Allow_ads=? ,Allow_comments=? WHERE Id  = ? ');
        $stmt->execute(array($cat_name,$desc,$vis,$order,$ad,$com,$cat_id));

        $themsg="<div class='alert alert-success'>" . $stmt->rowcount() . " Record Updated". "</div>";
        redirecthome($themsg,'back');  
        }
	    else
	    {
			$themsg="<div class='alert alert-danger'>" . "Sory category name  can't be <strong>empty</strong>" ."</div>";
			redirecthome($themsg);       	
	    }  
	    }
	    else
		{
			$themsg="<div class='alert alert-danger'>" . "sorry you can't browse this page directly"."</div>";
			redirecthome($themsg);
		}
	    echo "</div>";
}
elseif($do == 'Delete')
{
        echo "<div class='container'>";

        if(isset($_GET['CAT_ID']) && is_numeric($_GET['CAT_ID']))
        {
            echo "<h1 class='text-center'>".'Delete Category'."</h1>";
            $CAT_ID=intval($_GET['CAT_ID']);
        }
        else
        {
            $CAT_ID=0;
        }
        
        //check if the item is exist in DB or not
        $check = checkitem("Id","categories",$CAT_ID);
        if($check > 0)
        {
            $stmt=$con->prepare("DELETE FROM categories WHERE Id=?");
            $stmt->execute(array($CAT_ID));

            $themsg= " <div class='alert alert-success'> " 
            .$stmt->rowcount() 
            .' Record Deleted'
            ."</div>";
            redirecthome($themsg,'back');
        }
        else
        {
            $themsg = "<div class='alert alert-danger'>". 'There is no such ID' . "</div>";
            redirecthome($themsg);
            
        }

        echo "</div>";
}

include $tbl."footer.php";

}
else
{
header("location:index.php");
exit();
}

ob_end_flush();
?>
