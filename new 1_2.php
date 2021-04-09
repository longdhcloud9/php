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
//phpinfo(); 
$usernameErr = $passErr = $emailErr = $avaErr ="";
$username = $pass = $email ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $usernameErr = "Userame is required";
  } else {
    $username = test_input($_POST["username"]);
    // check if username only contains letters and number 0->9
    if (!preg_match("/^[a-zA-Z0-9-'_]*$/",$username)) {
      $usernameErr = "Invalid username";
    }
  }
  
  if (empty($_POST["pass"])) {
    $passErr = "Password is required";
  } else {
    $pass = test_input($_POST["pass"]);
    // check if password only contains letters and number 0->9
    if (!preg_match("/^[a-zA-Z0-9'_]*$/",$pass)) {
      $passErr = "Invalid password";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
  
   if(isset($_POST['submit1']))
 { 
   $ava= pathinfo(($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
   if($ava != "jpg" && $ava != "png" && $ava != "jpeg")
    {
     $avaErr= "Only .jpg, .png, .jpeg files are allowed.";
    }
   /*if ($_FILES["fileToUpload"]["size"] > 3000000) 
	{
    $avaErr = "Sorry, your file is too large.";
    }*/
 }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
  <p class ="error">*required field</p>
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
			</tr>
		</table>
  </form>
	<script>
	document.getElementById("myForm").addEventListener("submit", myFunction);
	function myFunction(inputText){
		username = document.getElementById("username");
		pass = document.getElementById("pass");
		email = document.getElementById("email");
		//var email = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
		image = document.querySelector('#fileUpload').value;
        imageExtension = image.split('.').pop();
		if((username.value.search(/^[a-zA-Z0-9-'_]*$/) != -1) &&
		   (pass.value.search(/^[a-zA-Z0-9-'_]*$/)!= -1) && 
		   (email.value.search(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)!=-1)&&
		   (imageExtension == "png"||imageExtension == "jpg"||imageExtension == "jpeg"|| imageExtension == ""))
		  {
			alert("Sign up successfully");
		  }
		else 
		  {
            alert("Fail to sign up");
		  }			
	}
	</script>
</body>
</html>