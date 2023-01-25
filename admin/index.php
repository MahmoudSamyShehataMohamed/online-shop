<?php
    session_start();
    $nonavbar="";
    $pagetitle="Login";

    include "init.php";
    
    if(isset($_SESSION['username']))
    {
    	header("location:dashboard.php");
    }
    
    
    //cheack if user comming from php post method 
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
    	$username=$_POST['user'];
    	$password=$_POST['pass'];
    	$hashedpass=sha1($password);
    	//check if the user exist in database or not
    	$stmt=$con->prepare("
            SELECT 
                 Userid,Username,Password
            FROM 
                 users 
            WHERE
                 Username=?
            AND 
                 Password=?
            AND 
                 Groupid=1 
            LIMIT 1");
    	$stmt->execute(array($username,$hashedpass));
        $row=$stmt->fetch();
    	$count=$stmt->rowcount();
    	//if count > 0 this mean tha database contain this username,password and his info
    	if($count > 0)
    	{
    		$_SESSION['username']=$username; 
            $_SESSION['id'] = $row['Userid']; 
    		header("location:dashboard.php");
    		exit();
    	}

    }
?>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <h4 class="text-center">Admin login</h4>
    	<input class="form-control" type="tex" name="user" placeholder="Username" autocomplete="off">
    	<input class="form-control" type="paswword" name="pass" placeholder="password" autocomplete="off">
    	<input class="btn btn-primary btn-block" type="submit" value="login"> 
    </form>

<?php include $tbl."footer.php"; ?>
