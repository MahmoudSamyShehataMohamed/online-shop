<?php
    ob_start();
    $pagetitle="Comments";
    session_start();
    if(isset($_SESSION['username']))
    {
        include "init.php";

        $DO="";

        if(isset($_GET['DO']))
        {
        	$DO=$_GET['DO'];
        }
        else
        {
        	$DO='MANAGE';
        }
        if($DO == 'MANAGE')
        {
        	$stmt=$con->prepare("SELECT comments.* ,users.Username,items.Item_name FROM comments INNER JOIN users on users.Userid=comments.User_id
        		INNER JOIN items on items.Item_id=comments.Item_id ORDER BY Comment_id DESC");
        	$stmt->execute();
        	$comments=$stmt->fetchall();
            if(!empty($comments)){?>
	        <h1 class="text-center">Manage Comments</h1>
	        <div class='container'>
	        <div class="table-responsive">
	        <table class="table table-bordered">
	          <thead>
	            <tr>
	              <th scope="col">#ID</th>
	              <th scope="col">Comment</th>
	              <th scope="col">Item Name</th>
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

	                echo "<td scope='row'>" . $comment['Comment_id'] . "</td>";
	                echo "<td>" .$comment['Comment'] ."</td>";
	                echo "<td>" . $comment['Item_name'] . "</td>";
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
            </div>
        <?php }
        else{
            echo "<div class='container'>";
            echo "<div class='alert alert-info'>There is no comments to show</div>";
            echo "</div>";          
        } ?>

        <?php 
        }
        else if($DO == 'EDIT')
        {
            echo "<div class='container'>";
        	if(isset($_GET['COMMENT_ID']) && is_numeric($_GET['COMMENT_ID']))
            {
                 echo "<h1 class='text-center'>Edit Comment</h1>";
                $COMMENT_ID=intval($_GET['COMMENT_ID']);
            }
            else
            {
                $COMMENT_ID=0;
            }

            $stmt=$con->prepare('SELECT * FROM comments WHERE Comment_id = ?');
            $stmt->execute(array($COMMENT_ID));
            $row=$stmt->fetch();
            $count=$stmt->rowcount();
            if($count > 0)
            { ?>

                 <form action="comments.php?DO=Update" method="POST">
                    <input type="hidden" name="comment_id" value="<?php echo $COMMENT_ID?>">
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Comment</label>
                    <div class="col-sm-8">
                        <textarea class='form-control' name="comment" required="required"><?php echo $row['Comment']?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-8">
                      <button type="submit" class="btn btn-primary  btn-sm">Update</button>
                    </div>
                  </div>
                </form>

            <?php }
            else
            {
                $themsg="<div class='alert alert-danger'>".'There is no such id'."</div>";
                redirecthome($themsg);
            }
            echo"</div>";

        }
        else if($DO == 'Update')
        {
            echo "<div class='container'>";
        	if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                echo "<h1 class='text-center'>Update Comment</h1>";
                $com_id=$_POST['comment_id'];
                $com=$_POST['comment'];
                    
                $stmt=$con->prepare('UPDATE comments SET Comment = ? WHERE Comment_id = ?');
                $stmt->execute(array($com,$com_id));
                $count=$stmt->rowcount();
                $themsg="<div class='alert alert-success'>".$count." Row Updated</div>";
                redirecthome("$themsg",'back');

            }
            else
            {
                $themsg="<div class='alert alert-danger'>You cant't browse this page directly</div>";
                redirecthome($themsg);
            }
            echo "<div>";
        }
        else if($DO == "Delete")
        {
        	echo "<div class='container'>";
            if(isset($_GET['COMMENT_ID']) && is_numeric($_GET['COMMENT_ID']))
            {
                echo "<h1 class='text-center'>Delete Comment</h1>";
                $COMMENT_ID=intval($_GET['COMMENT_ID']);
            }
            else
            {
                $COMMENT_ID=0;
            }

            $check=checkitem("Comment_id","comments",$COMMENT_ID);

            if($check > 0)
            {
            $stmt=$con->prepare('DELETE FROM comments WHERE Comment_id = ?');
            $stmt->execute(array($COMMENT_ID));
            $count=$stmt->rowcount();

            $themsg="<div class='alert alert-success'>".$count.' Row Deleted'."</div>";
            redirecthome($themsg,'back');
            }  
            else
            {
                $themsg="<div class='alert alert-danger'>"."There is no such id"."</div>";
                redirecthome($themsg);
            }
            echo "</div>";
        }
        else if($DO == "APPROVE")
        {
        	echo "<div class='container'>";
            if(isset($_GET['COMMENT_ID']) && is_numeric($_GET['COMMENT_ID']))
            {
                echo "<h1 class='text-center'>Approve Comment</h1>";
                $COMMENT_ID=intval($_GET['COMMENT_ID']);
            }
            else
            {
                $COMMENT_ID=0;
            }

            $check=checkitem("Comment_id","comments",$COMMENT_ID);

            if($check > 0)
            {
                $stmt=$con->prepare('UPDATE comments SET Approve = 1 WHERE Comment_id = ?');
                $stmt->execute(array($COMMENT_ID));
                $count=$stmt->rowcount();
                $themsg="<div class='alert alert-success'>".$count. "Comment Approved"."</div>";
                redirecthome($themsg,"back");
            }
            else
            {
                $themsg="<div class='alert alert-danger'>"."There is no such id"."</div>";
                redirecthome($themsg);
            }
            echo "</div>";
        }
        
        include $tbl."footer.php";
    }
    else
    {
    	header('location:index.php');
    	exit();
    }
    ob_end_flush();
?>