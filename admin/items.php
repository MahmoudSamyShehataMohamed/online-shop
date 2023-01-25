<?php
    ob_start();
    session_start();
    $pagetitle='Items';
    if(isset($_SESSION['username']))
    {
    	include "init.php";

        if(isset($_GET['DO']))
        {
        	$DO=$_GET['DO'];
        }
        else
        {
            $DO="MANAGE";
        }

        if($DO == 'MANAGE')
        {
        	$stmt=$con->prepare("SELECT items.* , categories.Name , users.Username
					        	  FROM items
					        	  inner join categories 
					        	  on categories.Id = items.Cat_id 
					        	  inner join users 
					        	  on users.Userid = items.User_id ORDER BY Item_id DESC");
        	$stmt->execute();
        	$items=$stmt->fetchall();
        	if(!empty($items)){
        	?>
	        <h1 class="text-center">Manage Items</h1>
	        <div class='container'>
	        <div class="table-responsive">
	        <table class="table table-bordered">
	          <thead>
	            <tr>
	              <th scope="col">#ID</th>
	              <th scope="col">Name</th>
	              <th scope="col">Description</th>
	              <th scope="col">Price</th>
	              <th scope="col">Adding Date</th>
	              <th scope="col">Category Name</th>
	              <th scope="col">Member Name</th>
	              <th scope="col">Control</th>
	            </tr>
	          </thead>
	          <tbody>

	            <?php
	            foreach($items as $item)
	            {   
	                echo "<tr>";

	                echo "<td scope='row'>" . $item['Item_id'] . "</td>";
	                echo "<td>" .$item['Item_name'] ."</td>";
	                echo "<td>" . $item['Description'] . "</td>";
	                echo "<td>" . $item['Price'] . "</td>";
	                echo "<td>" . $item['Add_date'] . "</td>";
	                echo "<td>" . $item['Name'] . "</td>";  
	                echo "<td>" . $item['Username'] ." </td>";
	                echo "<td>
	                  <div class='items'>
	                  <a href='items.php?DO=EDIT&ITEM_ID=".$item['Item_id']."' class='btn btn-success btn-sm'> <i class='fa fa-edit'></i> Edit</a>
	                  <a href='items.php?DO=Delete&ITEM_ID=".$item['Item_id']."'class='btn btn-danger btn-sm'><span aria-hidden='true'> &times;</span> Delete</a> ";
	                  if($item['Approve'] == 0)
	                  {
	                  	echo "<a href='items.php?DO=APPROVE&ITEM_ID=".$item['Item_id']."' class='btn btn-info btn-sm'><i class='fa fa-check'></i> Approve</a>";
	                  }
	                echo "</div>";
	                echo "</td>";
                    
	                echo "</tr>";   
	            }
	            ?>
	          </tbody>
	        </table>
	        </div>

             <a href='items.php?DO=ADD' class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add new Item</a>

            </div>
        <?php }
        else
        {
        	echo "<div class='container'>";
        	echo "<div class='alert alert-info'>There is no items to show</div>";
        	echo "<a href='items.php?DO=ADD' class='btn btn-primary btn-sm'><i class='fa fa-plus'></i> Add new Item</a>";
        	echo "</div>";
        } ?>
 
        <?php         	
        }
        else if($DO == 'ADD')
        {?>
			<h1 class="text-center">Add New Item</h1>
			 <div class="container">
				 <form action="items.php?DO=Insert" method="POST">
					  <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Name</label>
					    <div class="col-sm-8">
					      <input type="text" name="item_name" class="form-control" required="required">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Description</label>
					    <div class="col-sm-8">
					      <input type="text" name="description" class="form-control" required="required">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Price</label>
					    <div class="col-sm-8">
					      <input type="text" name="price" class="form-control" required="required">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Country</label>
					    <div class="col-sm-8">
					      <input type="text" name="country" class="form-control" required="required">
					    </div>
					  </div>

					  <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Status</label>
					    <div class="col-sm-8">
					      <select class='form-control' name='status'>
					      	<option value='0'>....</option>
					      	<option value='1'>New</option>
					      	<option value='2'>Like New</option>
					      	<option value='3'>Used</option>
					      	<option value='4'>Very Old</option>
					      </select>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Member</label>
					    <div class="col-sm-8">
					      <select class='form-control' name='member'>
					      	<option value='0'>....</option>
					        <?php 
					        $stmt=$con->prepare("SELECT * FROM users");
					        $stmt->execute();
					        $users=$stmt->fetchall();
					        foreach($users as $user)
					        {
                             
                            ?>
                                <option value='<?php echo $user['Userid']?>'> <?php echo $user['Username'] ?></option>
                            <?php 

					        }

					        ?>
					      </select>
					    </div>
					  </div>
                        <div class="form-group row">
					    <label for="inputEmail" class="col-sm-2 col-form-label">Category</label>
					    <div class="col-sm-8">
					      <select class='form-control' name='category'>
					      	<option value='0'>....</option>
					        <?php 
					        $stmt2=$con->prepare("SELECT * FROM categories");
					        $stmt2->execute();
					        $cats=$stmt2->fetchall();
					        foreach($cats as $cat)
					        {
                             
                            ?>
                                <option value='<?php echo $cat['Id']?>'> <?php echo $cat['Name'] ?></option>
                            <?php 

					        }

					        ?>
					      </select>
					    </div>
					  </div>
					  <div class="form-group row">
					    <div class="col-sm-8">
					      <button type="submit" class="btn btn-primary btn-sm"><i class='fa fa-plus'></i> Add Item</button>
					    </div>
					  </div>
				</form>
			 </div> 
        <?php }
        else if($DO == 'Insert')
        {
        	echo "<div class='container'>";
        	if($_SERVER['REQUEST_METHOD'] == 'POST')
        	{
        		echo "<h1 class='text-center'>Insert Item</h1>";
        		$name=$_POST['item_name'];
        		$desc=$_POST['description'];
        		$price=$_POST['price'];
        		$country=$_POST['country'];
        		$stat=$_POST['status'];
        		$member=$_POST['member'];
        		$cat=$_POST['category'];
        		$formerrors=array();
        		if(empty($name))
        		{
        			$formerrors[]="Item name can't be empty";
        		}
        		if(empty($desc))
        		{
        			$formerrors[]="Description of the item can't be empty";
        		}
        		if(empty($price))
        		{
        			$formerrors[]="Item price can't be empty";
        		}
        		if(empty($country))
        		{
        			$formerrors[]="Country made of the item can't be empty";
        		}
        		if($stat == 0)
        		{
        			$formerrors[]="You must choose the status of the item";
        		}
        		if($member == 0)
        		{
        			$formerrors[]="You must choose the member who add the item";
        		}
        		if($cat == 0)
        		{
        			$formerrors[]="You must choose the category name of the item";
        		}
        		foreach($formerrors as $error)
        		{
        			$themsg="<div class='alert alert-danger'>". $error."</div>";
        			redirecthome($themsg,'back');

        		}
        		if(empty($formerrors))
        		{


                        $stmt=$con->prepare("INSERT INTO items(Item_name,Description,Price,Country_made,Status,Add_date,User_id,Cat_id) VALUES(?,?,?,?,?,now(),?,?)");
                        $stmt->execute(array($name,$desc,$price,$country,$stat,$member,$cat));

                        $themsg="<div class='alert alert-success'>".$stmt->rowcount()." record Updated"."</div>";
                        redirecthome($themsg,'back');
                    

        		}
        	}
        	else
        	{
        		$themsg="<div class='alert alert-danger'>" . "You can't browse this page directly". "</div>";
        		redirecthome($themsg);
        	}
        	echo "</div>";
        }
        else if ($DO == 'EDIT')
        {

        	echo "<div class='container'>";
        	if(isset($_GET['ITEM_ID']) && is_numeric($_GET['ITEM_ID']))
        	{
        		$ITEM_ID=intval($_GET['ITEM_ID']);
        	}
        	else
        	{
        		$ITEM_ID=0;
        	}

        	$stmt=$con->prepare("SELECT * FROM items WHERE Item_id=?");
        	$stmt->execute(array($ITEM_ID));
        	$row=$stmt->fetch();
        	$count=$stmt->rowcount();

        	if($count > 0)
        	{?>

	          <h1 class="text-center">Edit Item</h1>
			 <form action="items.php?DO=Update" method="POST">

	            <input type="hidden" name="item_id" value="<?php echo $ITEM_ID?>">

			  <div class="form-group row">
			    <label for="inputEmail" class="col-sm-2 col-form-label">Name</label>
			    <div class="col-sm-8">
			      <input type="text" name="item_name"  value="<?php echo $row['Item_name']?>" class="form-control"autocomplete="off" required="required">
			    </div>
			  </div>

			  <div class="form-group row">
			    <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
			    <div class="col-sm-8">
			      <input type="text" name="description" value="<?php echo $row['Description']?>" class="form-control" autocomplete="new-password" required="required">
			    </div>
			  </div>

			  <div class="form-group row">
			    <label for="inputemail" class="col-sm-2 col-form-label">Price</label>
			    <div class="col-sm-8">
			      <input type="text" name="price" value="<?php echo $row['Price']?>" class="form-control" required="required">
			    </div>
			  </div>

			  <div class="form-group row">
			    <label for="inputfullname" class="col-sm-2 col-form-label">Country Made</label>
			    <div class="col-sm-8">
			      <input type="text" name="country_made"  value="<?php echo $row['Country_made']?>" class="form-control" required="required">
			    </div>
			  </div>
	  			<div class="form-group row">
			    <label for="inputEmail" class="col-sm-2 col-form-label">Status</label>
			    <div class="col-sm-8">
			      <select class='form-control' name='status'>
			      	<option value='1' <?php if($row['Status'] == 1){echo "selected";}?> >New</option>
			      	<option value='2' <?php if($row['Status'] == 2){echo "selected";}?> >Like New</option>
			      	<option value='3' <?php if($row['Status'] == 3){echo "selected";}?> >Used</option>
			      	<option value='4' <?php if($row['Status'] == 4){echo "selected";}?> >Very Old</option>
			      </select>
			    </div>
			    </div>
				<div class="form-group row">
			    <label for="inputEmail" class="col-sm-2 col-form-label">Member</label>
			    <div class="col-sm-8">
			      <select class='form-control' name='member'>
			        <?php 
			        $stmt=$con->prepare("SELECT * FROM users");
			        $stmt->execute();
			        $users=$stmt->fetchall();
			        foreach($users as $user)
			        {
	                 
	                ?>
	                    <option value='<?php echo $user['Userid']?>'  <?php if($row['User_id'] == $user['Userid']){echo "selected";}?>> <?php echo $user['Username'] ?></option>
	                <?php 

			        }

			        ?>
			      </select>
			    </div>
			  </div>
	            <div class="form-group row">
			    <label for="inputEmail" class="col-sm-2 col-form-label">Category</label>
			    <div class="col-sm-8">
			      <select class='form-control' name='category'>
			        <?php 
			        $stmt2=$con->prepare("SELECT * FROM categories");
			        $stmt2->execute();
			        $cats=$stmt2->fetchall();
			        foreach($cats as $cat)
			        {
	                 
	                ?>
	                    <option value='<?php echo $cat['Id']?>'   <?php if($row['Cat_id'] == $cat['Id']){echo "selected";}?> > <?php echo $cat['Name'] ?></option>
	                <?php 

			        }

			        ?>
			      </select>
			    </div>
			  </div>
			  <div class="form-group row">
			    <div class="col-sm-8">
			      <button type="submit" class="btn btn-primary  btn-sm">Update</button>
			    </div>
			  </div>
			</form>
			<?php 
        	$stmt=$con->prepare("SELECT comments.* ,users.Username FROM comments INNER JOIN users on users.Userid=comments.User_id WHERE Item_id = ?");
        	$stmt->execute(array($ITEM_ID));
        	$comments=$stmt->fetchall();
        	if(! empty($comments)){
            ?>
	        <h1 class="text-center">Manage [<?php echo $row['Item_name']?>] Comments</h1>
	        <div class="table-responsive">
	        <table class="table table-bordered">
	          <thead>
	            <tr>
	              <th scope="col">Comment</th>
	              <th scope="col">Member Name</th>
	              <th scope="col">Adding Date</th>
	              <th scope="col">Control</th>
	            </tr>
	          </thead>
	          <tbody>
	            <?php
	            foreach($comments as $comment)
	            {   
	                echo "<tr>";

	                echo "<td>" .$comment['Comment'] ."</td>";
	                echo "<td>" . $comment['Username'] . "</td>";
	                echo "<td>" . $comment['Comment_date'] . "</td>";

	                echo "<td>
	                  <div class='comments'>
	                  <a href='comments.php?DO=EDIT&COMMENT_ID=".$comment['Comment_id']."' class='btn btn-success btn-sm'> <i class='fa fa-edit'></i> Edit</a>
	                  <a href='comments.php?DO=Delete&COMMENT_ID=".$comment['Comment_id']."'class='btn btn-danger btn-sm'><span aria-hidden='true'> &times;</span> Delete</a> ";
	                  if($comment['Approve'] == 0)
	                  {
	                  	echo "<a href='comments.php?DO=APPROVE&COMMENT_ID=".$comment['Comment_id']."' class='btn btn-info btn-sm'><i class='fa fa-check'></i> Approve</a>";
	                  }

                    echo "</div>";

                    echo "</td>";

	                echo "</tr>";   
	            }
	            ?>
	          </tbody>
	        </table>
	        </div>
	        <?php }?>

		    <?php }
        	else
        	{
        		$themsg="<div class='alert alert-danger'>"."There is no such id"."</div>";
        		redirecthome($themsg);
        	}
        	echo "</div>";
        }
        else if($DO == 'Update')
        {
        	echo "<div class='container'>";
        	if($_SERVER['REQUEST_METHOD'] == 'POST')
        	{
        		echo "<h1 class='text-center'>".'Update Item'."</h1>";
        		$id=$_POST['item_id'];
        		$name=$_POST['item_name'];
        		$desc=$_POST['description'];
        		$price=$_POST['price'];
        		$country=$_POST['country_made'];
        		$stat=$_POST['status'];
        		$cat=$_POST['category'];
        		$member=$_POST['member'];
	            $formerrors=array();

	            if(empty($name))
	            {
	                $formerrors[]= "Name can't be <strong>empty</strong>";
	            }
	            if(empty($desc))
	            {
	                $formerrors[]= "description can't be <strong>empty</strong>";
	            }
	            if(empty($price))
	            {
	                $formerrors[] = "Price can't be <strong>empty</strong>";
	            }
	            if(empty($country))
	            {
	                $formerrors[]= " Country can't be <strong> empty </strong>";
	            }
	            if(empty($stat))
	            {
	                $formerrors[]= " Status can't be <strong> empty </strong>";
	            }
	            if(empty($cat))
	            {
	                $formerrors[]= " category name can't be <strong> empty </strong>";
	            }
	            if(empty($member))
	            {
	                $formerrors[]= " member name can't be <strong> empty </strong>";
	            }
	            foreach($formerrors as $error)
	            {
	                echo "<div class='alert alert-danger'>" . $error . "</div>";
	            }
	            if(empty($formerrors))
                {
        		$stmt=$con->prepare("UPDATE items SET Item_name=? , Description=? , Price=? , Country_made=? ,Status=? ,User_id=? , Cat_id=?  WHERE Item_id=?");
        		$stmt->execute(array($name,$desc,$price,$country,$stat,$member,$cat,$id));
        		$count=$stmt->rowcount();

        		$themsg="<div class='alert alert-success'>".$count." Row Updated"."</div>";
        		redirecthome($themsg,'back');
        	    }
        	}
        	
        	else 
        	{
        		$themsg="<div class='alert alert-danger'>" . "You cant't browse this page directly" . "</div>";
        		redirecthome($themsg);
        	}
        	echo "</div>";
        }
        else if($DO == 'Delete')
        {
        	echo "<div class='container'>";
        	if(isset($_GET['ITEM_ID']) && is_numeric($_GET['ITEM_ID']))
        	{
        		echo "<h1 class='text-center'>".'Delete Member'."</h1>";
        		$ITEM_ID=intval($_GET['ITEM_ID']);
        	}
        	else
        	{
        		$ITEM_ID=0;
        	}

            $check=checkitem("Item_id","items",$ITEM_ID);

            if($check > 0)
            {
            	$stmt=$con->prepare("DELETE FROM items WHERE Item_id=?");
            	$stmt->execute(array($ITEM_ID));
            	$row=$stmt->rowcount();
            	$themsg = "<div class='alert alert-success'>".$row." Record Deleted"."</div>";
            	redirecthome($themsg,'back');
            }
            else
            {
            	$themsg="<div class='alert alert-danger'>"."There is no such id"."</div>";
            	redirecthome($themsg);
            }
        	echo "</div>";
        }
        else if($DO == 'APPROVE')
        {
        	echo "<div class='container'>";
        	if(isset($_GET['ITEM_ID']) && is_numeric($_GET['ITEM_ID']))
        	{
        		echo "<h1 class='text-center'>".'Approve page'."</h1>";
        		$ITEM_ID=intval($_GET['ITEM_ID']);
        	}
        	else
        	{
        		$ITEM_ID=0;
        	}
        	$check=checkitem('Item_id',"items",$ITEM_ID);
        	if($check > 0){
        		$stmt=$con->prepare("UPDATE items SET Approve = 1 WHERE Item_id=?");
        		$stmt->execute(array($ITEM_ID));
        		$row=$stmt->rowcount();
        		$themsg="<div class='alert alert-success'>" . $row . ' Row Updated' . "</div>";
        		redirecthome($themsg,'back');

        	}
        	else
        	{
        		$themsg="<div class='alert alert-danger'>There is no such id</div>";
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