<html>
<head>
    <meta charset="UTF-8">
	<title>Register form</title>
	<style>
	.error {color: #FF0000;}
	</style>
</head>
<body>
<?php
// define variables and set to empty values
//phpinfo(); 
$usernameErr = $passErr = $emailErr = "";
$username = $pass = $email = "";
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
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
  <p class ="error">*required field</p>
  <form id ="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
				<td><input type="file" name="file" accept="image/*"></td>
			</tr>
			<tr>
				<td colspan="2" align="left"><input type="submit" name="button_submit" value="Register"></td>
			</tr>
		</table>
  </form>
	<script>
	document.getElementById("myForm").addEventListener("submit", myFunction);
	function myFunction(){
		if((document.getElementById("username").value == "/^[a-zA-Z0-9-'_]*$/") && (document.getElementById("pass").value == "/^[a-zA-Z0-9-'_]*$/") && (document.getElementById("email").value == "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"))
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

