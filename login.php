<?php 
    session_start();
    $pagetitle="Login";

    include "init.php";
    
    if(isset($_SESSION['user_name']))
    {
    	header("location:index.php");
    }
    
    
    //cheack if user comming from php post method 
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
    	$user=$_POST['username'];
    	$pass=$_POST['password'];
    	$hashedpass=sha1($pass);
    	//check if the user exist in database or not
    	$stmt=$con->prepare("
            SELECT 
                 Username,Password
            FROM 
                 users 
            WHERE
                 Username=?
            AND 
                 Password=? ");
    	$stmt->execute(array($user,$hashedpass));

    	$count=$stmt->rowcount();
    	//if count > 0 this mean tha database contain this username,password and his info
    	if($count > 0)
    	{
    		$_SESSION['user_name']=$user; 
    		header("location:index.php");
    		exit();
    		
    	}

    }
?>
	<div class='container login-page'>
		<h1 class='text-center'>
			<span class='login'>Login</span>
		</h1>
		<form class='login' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
			<input required='required' class='form-control' placeholder='Type Your Username' type='text' name='username' autocomplete='off'>
			<input required='required' class='form-control' placeholder='Type Your Password' type='password' name='password' autocomplete='new-password'>
			<input required='required' class='btn btn-primary btn-block' type='submit' value='login'>
		</form>  
	</div>

<?php 
    include $tbl."footer.php"
?>