<?php include 'init.php'?>
	<div class='container login-page'>
		<h1 class='text-center'>
			<span class='signup'>Signup</span>
		</h1>
		<form class='signup' action='<?php echo $SERVER['PHP_SELF'] ?>' method='POST'>
			<input required='required' class='form-control' placeholder='Type Your UserName' type='text' name='username' autocomplete='off'>
			<input required='required' class='form-control' placeholder='Type a Complex password' type='password' name='password' autocomplete='new-password'>
			<input required='required' class='form-control' placeholder='Type a password Again' type='password' name='password2' autocomplete='new-password'>			
			<input required='required' class='form-control' placeholder='Type a Valid email' type='email' name='email' autocomplete='new-password'>			
			<input required='required' class='btn btn-success btn-block' type='submit' value='Signup'>
		</form>
	</div>
<?php include $tbl.'footer.php'?>