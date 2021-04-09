<html>
<head>
    <meta charset="UTF-8">
	<title>Register form</title>
    <style>
	.error {color: #FF0000;}
	.avatar {color: #0000FF;}
	</style>
</head>
<body>
<?php
// define variables and set to empty values
$usernameErr = $passErr = $emailErr = $avaErr = '';
$username = $pass = $email = $error = '';

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['submit1'])) {
  if (empty($_POST["username"])) {
    $usernameErr = "Please enter your username";
  } else {
    $username = test_input($_POST["username"]);
    // check if username only contains letters and number 0->9
    if (!preg_match("/^[a-zA-Z0-9-']*$/",$username)) {
     $usernameErr = "Invalid username format";
    }
  }
  
  if (empty($_POST["pass"])) {
    $passErr = "Please enter your password";
  } else {
    $pass = test_input($_POST["pass"]);
    // check if password only contains letters and number 0->9
    if (!preg_match("/^[a-zA-Z0-9-']*$/",$pass)) {
      $passErr = "Invalid password";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Please enter your email";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
  
   $ava= pathinfo(($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
   if($ava != "jpg" && $ava != "png" && $ava != "jpeg" && $ava!="")
    {
     $avaErr = "Only .jpg, .png, .jpeg files are allowed";
    }
	if ($_FILES["fileToUpload"]["size"] > 3000000) 
	{
    $avaErr = "The size of upload file must be smaller than 3MB";
    }
	
	if(($usernameErr == '') && ($passErr == '') && ($emailErr == ''))
  {
     $file_open = fopen("my_data.xlsx", "a");
     $form_data = array('username'  => $username,'email'  => $email,'pass' => $pass);
     fputcsv($file_open, $form_data);
	 $error = "Thank you for sign up";
     $username = '';
     $email = '';
     $pass= '';
  }
}
?>
  <form id ="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	<table>
			<tr>
				<td>Username:</td>
				<td><input type="text" id="username" name="username" minlength="5" maxlength="15" value="<?php echo $username;?>" title="Username must contain at least 5 characters not include symbol and the maxlength is 15 characters"></td>
				<td class ="error">*<?php echo $usernameErr;?></td>
			</tr>
			<tr>
				<td>Password:</td>
                <td><input type="password" id="pass" name="pass" minlength="8" maxlength="15" value="<?php echo $pass;?>" title="Password must contain at least 8 characters include at least one number,one uppercase letter,one lowercase letter and the maxlength is 15 characters."></td>
			<td class ="error">*<?php echo $passErr;?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" id="email" name="email" value="<?php echo $email;?>"></td>
				<td class="error">*<?php echo $emailErr;?></td>	
			</tr>
			<tr>
				<td>Avatar:</td>
				<td><input type="file" name="fileToUpload" id="fileUpload" title = "Only .jpg, .png, .jpeg files are allowed."></td> 
				<td class="avatar"><?php echo $avaErr;?></td>
			</tr>
			<tr>
				<td colspan="2" align="left"><input type="submit" name="submit1" value="Register"></td>
				<td color="#0000FF"><?php echo $error;?></td>
			</tr>
		</table>
		  <p class ="error">*:required field</p>
  </form>
	<script>
	document.getElementById("myForm").addEventListener("submit", myFunction);
	function myFunction(){
		username = document.getElementById("username");
		pass = document.getElementById("pass");
		email = document.getElementById("email");
		image = document.querySelector('#fileUpload').value;
        imageExtension = image.split('.').pop();
		if((username.value.search(/^[a-zA-Z0-9]*$/) == -1 || username.value=="") ||
		   (pass.value.search(/^[a-zA-Z0-9]*$/) == -1 || pass.value=="") || 
		   (email.value.search(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)==-1)
		   ||(imageExtension != "png" && imageExtension != "jpg" && imageExtension != "jpeg" && imageExtension != ""))
		  {
			alert("Fail to sign up");
		  }
		else 
		  {
            alert("Sign up successfully");
		  }			
	}
	</script>
</body>
</html>