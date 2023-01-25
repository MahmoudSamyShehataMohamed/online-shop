<?php
    
    /*Manage mebers page you can Add,Edit,Delete Members from here*/
    //pages:(Mnage, Edit=>Update, Add=>Insert, Delete , Statistics)
    ob_start();
    session_start();
    $pagetitle="Members";
    if(isset($_SESSION['username'])){
     
    include "init.php";

    $do="";

    if(isset($_GET['do']))
    {
        $do = $_GET['do'];
    }   
    else
    {
    	$do = 'Manage';
    }
    
    if($do == "Manage")
    {
        $query='';
        if(isset($_GET['page']) && $_GET['page'] == 'pending')
        {
            $query='AND Regstatus = 0';
        }

        $stmt=$con->prepare("SELECT * FROM users WHERE Groupid !=1 $query ORDER BY Userid DESC");
        $stmt->execute();
        $rows=$stmt->fetchall();
        if(!empty($rows)){
        ?>
        <h1 class="text-center">Manage Members</h1>
        <div class='container'>
        <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#ID</th>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Full Name</th>
              <th scope="col">Registerd Date</th>
              <th scope="col">Control</th>
            </tr>
          </thead>
          <tbody>

            <?php
            foreach($rows as $row)
            {   
                echo "<tr>";
                echo "<td scope='row'>" . $row['Userid'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['Fullname'] . "</td>";
                echo "<td>" .$row['Date'] ."</td>";
                echo "<td>
                 <div class='members'>
                  <a href='members.php?do=Edit&userid=".$row['Userid']."' class='btn btn-success btn-sm'> <i class='fa fa-edit'></i> Edit</a>
                  <a href='members.php?do=Delete&userid=".$row['Userid']."'class='btn btn-danger btn-sm'><span aria-hidden='true'> &times;</span> Delete</a> ";
                  if($row['Regstatus'] == 0)
                  {

                    echo "<a href='members.php?do=Activate&userid=".$row['Userid']."' class='btn btn-info btn-sm'> <i class='fa fa-check'></i> Activate</a>";
                  }
                   
                echo "</div>";
                echo "</td>";

               
                  
                  
                echo "</tr>";   
            }
            ?>
          </tbody>
        </table>
        </div>

        <a href='members.php?do=Add' class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add new member</a>

        </div>
        <?php } else
        {
            echo "<div class='container'>";
            echo "<div class='alert alert-info'>There is no members to show</div>";
            echo "<a href='members.php?do=Add' class='btn btn-primary btn-sm'><i class='fa fa-plus'></i> Add new member</a>";
            echo "</div>";
        }?>

    <?php }

    else if($do == 'Add')
    {?>
       <h1 class="text-center">Add New Member</h1>
         <div class="container">
         <form action="members.php?do=Insert" method="POST">

          <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-8">
              <input type="text" name="username" class="form-control"autocomplete="off" 
              required="required">
            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" autocomplete="new-password" required="required">
            </div>
          </div>

          <div class="form-group row">
            <label for="inputemail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" required="required">
            </div>
          </div>

          <div class="form-group row">
            <label for="inputfullname" class="col-sm-2 col-form-label">FullName</label>
            <div class="col-sm-8">
              <input type="text" name="fullname" class="form-control" required="required">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-8">
              <button type="submit" class="btn btn-primary btn-sm">Add Member</button>
            </div>
          </div>
        </form>
        </div>
        
    <?php 

    }else if($do == 'Insert')

     {
        echo "<div class='container'>";

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            
            echo "<h1 class='text-center'>".'Insert Member'."</h1>";
            //get data from user by POST
            $username=$_POST['username'];
            $password=$_POST['password'];
            $email=$_POST['email'];
            $fullname=$_POST['fullname'];
            $hashedpass=sha1($_POST['password']);
            //validate the form whiche come from edit page to update
            $formerrors=array();
            if(strlen($username) < 4)
            {
                $formerrors[]= "Username can't be less than <strong>4 characters</strong>";
            }
            if(strlen($username) > 20)
            {
                $formerrors[]= "Ueser name can't be more than <strong>20 characters</strong>";
            }
            if(empty($username))
            {
                $formerrors[]= "Username can't be <strong>empty</strong>";
            }
            if(empty($password))
            {
                $formerrors[]= "Password can't be <strong>empty</strong>";
            }
            if(empty($email))
            {
                $formerrors[] = "Email can't be <strong>empty</strong>";
            }
            if(empty($fullname))
            {
                $formerrors[]= " Fullname can't be <strong> empty </strong>";
            }
            foreach($formerrors as $error)
            {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }

            //DB
            if(empty($formerrors))
            {  
                //check if user exist in DB
                $check=checkitem("Username","users",$username);
                if($check == 1)
                {
                    $themsg ="<div class='alert alert-danger'>" . "Sorry This User Is Exist"
                     . "</div>";
                     redirecthome($themsg,'back');
                }
                else
                {
                $stmt=$con->prepare("INSERT INTO
                users(Username,Password,Email,Fullname,Regstatus,Date) 
                VALUES(?, ?, ?, ?,1,now())");
                $stmt->execute(array($username,$hashedpass,$email,$fullname));
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

           
        }
        
        
        

        else
        {

            $themsg="<div class='alert alert-danger'>"."Sorry you can't browse this page directly". "</div>";
            redirecthome($themsg);
        }

            
       echo "</div>";
    }

    else if($do == "Edit")
    {
        echo "<div class='container'>";

        if(isset($_GET['userid']) && is_numeric($_GET['userid']))
        {
            $userid=intval($_GET['userid']);
        }
        else
        {
            $userid=0;
        }
        
        //check if the item is exist in DB or not
        //and we must get data to print in hoookoool beacause itis edit page
        $stmt=$con->prepare("SELECT * FROM users WHERE Userid=?");
        $stmt->execute(array($userid));
        $row=$stmt->fetch();
        $count=$stmt->rowcount();
        if($count > 0)
        { ?>
         
        <h1 class="text-center">Edit Member</h1>
         
		 <form action="members.php?do=Update" method="POST">

            <input type="hidden" name="userid" value="<?php echo $userid?>" required="required">

		  <div class="form-group row">
		    <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
		    <div class="col-sm-8">
		      <input type="text" value="<?php echo $row['Username']?>" name="username" class="form-control"autocomplete="off" required="required">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
		    <div class="col-sm-8">
              <input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
		      <input type="password" name="newpassword" class="form-control" autocomplete="new-password">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputemail" class="col-sm-2 col-form-label">Email</label>
		    <div class="col-sm-8">
		      <input type="email" value="<?php echo $row['Email']?>" name="email" class="form-control" required="required">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="inputfullname" class="col-sm-2 col-form-label">FullName</label>
		    <div class="col-sm-8">
		      <input type="text" value="<?php echo $row['Fullname']?>" name="fullname" class="form-control" required="required">
		    </div>
		  </div>

		  <div class="form-group row">
		    <div class="col-sm-8">
		      <button type="submit" class="btn btn-primary  btn-sm">Update</button>
		    </div>
		  </div>
		</form>
    

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

    else if($do == "Update")
    {

        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            echo "<h1 class='text-center'>".'update Member'."</h1>";
            //get data from user by POST
            $id=$_POST['userid'];
            $username=$_POST['username'];
            $email=$_POST['email'];
            $fullname=$_POST['fullname'];
            
            //trick password
            
            $pass='';
            if(empty($_POST['newpassword']))
            {
                $pass=$_POST['oldpassword'];
            }
            else
            {
                $pass=sha1($_POST['newpassword']);
            }
            //validate the form whiche come from edit page to update
            $formerrors=array();
            if(strlen($username) < 4)
            {
                $formerrors[]="Username can't be less than<strong> 4 characters</strong> </div>";
            }
            if(strlen($username) > 20)
            {
                $formerrors[]= "Ueser name can't be more than<strong> 20 characters</strong>";
            }
            if(empty($username))
            {
                $formerrors[]= "Username can't be <strong>empty</strong>";
            }
            if(empty($email))
            {
                $formerrors[] = "Email can't be <strong>empty</strong>";
            }
            if(empty($fullname))
            {
                $formerrors[]= "Fullname can't be <strong>empty</strong>";
            }
            foreach($formerrors as $error)
            {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }

            //DB
            if(empty($formerrors))
            {
             
            $stmt2=$con->prepare('SELECT * FROM users WHERE Username=? AND Userid != ?');
            $stmt2->execute(array($username,$id));
            $count=$stmt2->rowcount();
            
            if($count == 1)
            {
                $themsg="<div class='alert alert-danger'>Sorry this user is exist</div>";
                redirecthome($themsg,'back');
            } 
            else
            {

            $stmt=$con->prepare("UPDATE users SET Username=?,Email=?,Fullname=?,Password=? WHERE Userid=?");
            $stmt->execute(array($username,$email,$fullname,$pass,$id));

            $themsg = "<div class='alert alert-success'>"
                  .$stmt->rowcount()
                  .'  Record Updated' 
                  ."</div>";

            redirecthome($themsg,'back');
            }
            }
          
        }
          
        
        else
        {
            $themsg="<div class='alert alert-danger'>"."Sorry you can't browse this page directly "."</div>";
            redirecthome($themsg);
           
        }


        echo "</div>";
        
    }
    else if($do == "Delete")
    {
        echo "<div class='container'>";

        if(isset($_GET['userid']) && is_numeric($_GET['userid']))
        {
            echo "<h1 class='text-center'>".'Delete Member'."</h1>";
            $userid=intval($_GET['userid']);
        }
        else
        {
            $userid=0;
        }
        
        //check if the item is exist in DB or not
        $check = checkitem("Userid","users",$userid);
        if($check > 0)
        {
            $stmt=$con->prepare("DELETE FROM users WHERE Userid=?");
            $stmt->execute(array($userid));

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

    elseif($do = 'Activate')
    {
        echo "<div class='container'>";
        

        if(isset($_GET['userid']) && is_numeric($_GET['userid']))
        {
            echo "<h1 class='text-center'>".'Activate Member'."</h1>";
            $userid=intval($_GET['userid']);
        }
        else
        {
            $userid=0;
        }
        
        //check if the item is exist in DB or not
        $check = checkitem("Userid","users",$userid);
        if($check > 0)
        {
            $stmt=$con->prepare("UPDATE  users SET Regstatus=1 WHERE Userid=?");
            $stmt->execute(array($userid));

            $themsg= " <div class='alert alert-success'> " 
            .$stmt->rowcount() 
            .' Record Activated'
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
    else{
    	header("location:index.php");
    	exit();
    }

    ob_end_flush();
?>
