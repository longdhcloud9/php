<html>
<head>
    <meta charset="UTF-8">
	<title>Register form</title>
    <style>
	.error {color: #FF0000;}
	.avatar {color: #0000FF;}
	table.t1,.t1 th,.t1 td
   {
	border-style:solid;
    border-width:2px;
    border-color:pink;
   }
	</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>-->
</head>
<body >
<?php
// define variables and set to empty values
$usernameErr = $passErr = $emailErr = $avaErr = '';
$username = $pass = $email = $ava = '';

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$pass)) {
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
  
  if(isset($_POST['submit1'])){
   $filepath = "C:/xampp/htdocs/images/" . $_FILES["fileToUpload"]["name"];
   move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filepath);
   $ava= pathinfo(($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
    if($ava != "jpg" && $ava != "png" && $ava != "jpeg" && $ava!="")
     {
      $avaErr = "Only .jpg, .png, .jpeg files are allowed";
     }
	if ($_FILES["fileToUpload"]["size"] > 3000000) 
	 {
      $avaErr = "The size of the uploaded file must be smaller than 3MB";
     }
	if(($usernameErr == '') && ($passErr == '') && ($emailErr == '') && ($avaErr == ''))
    {
       $file_open = fopen("my_data.xlsx", "a");
       $form_data = array('username'  => $username,'email'  => $email,'pass' => $pass);
       fputcsv($file_open, $form_data);
       // $username = '';
       // $email = '';
       // $pass= '';
	} 
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
                <td><input type="password" id="pass" name="pass" minlength="8" maxlength="15" value="<?php echo $pass;?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}" title="Password must contain at least 8 characters include at least one digit number,one lowercase letter and one uppercae letter."></td>
			<td class ="error">*<?php echo $passErr;?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" id="email" name="email" value="<?php echo $email;?>"></td>
				<td class="error">*<?php echo $emailErr;?></td>	
			</tr>
			<tr>
				<td>Avatar:</td>
				<td><input type="file" name="fileToUpload" id="fileUpload" value="<?php echo $ava;?>" title = "Only .jpg, .png, .jpeg files are allowed."></td> 
				<td class="avatar"><?php echo $avaErr;?></td>
			</tr>
			<tr>
				<td colspan="2" align="left"><input type="submit" name="submit1" id="sub" value="Register"></td>
			</tr>
		</table>
		  <p class ="error">*:required field</p>
  </form>
  <table class ="t1">
  <tr>
    <th>Username</th>
    <th>Password</th>
	<th>Email</th>
	<th>Avatar</th>
  </tr>
  <tr >
    <td> <?php echo $username;?> </td>
    <td><?php echo $pass;?></td>
	<td> <?php echo $email;?> </td>
	<td> <img src="<?php echo "/../images/" . $_FILES["fileToUpload"]["name"];?>" height=200 width=300 /> </td>
  </tr>
  </table>
	<script>
	$(document).ready(function(){
		$('#myForm').submit(function(e){
			var name= $('#username').val();
			var email = $('#email').val();
            var pass = $('#pass').val();
			var usernameReg=/^[a-zA-Z0-9]*$/;
			var validUsername=usernameReg.test(name);
			var emailReg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var validEmail=emailReg.test(email);
			var passReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
			var validPass=passReg.test(pass);
			var imageExtension=$('#fileUpload').val().split('.').pop();
			$('#fileUpload').on('change',function(){
				const size =(this.files[0].size / 1024 / 1024).toFixed(2);
			});
			if((!validUsername)||(!validPass)||(!validEmail)||
			   (imageExtension != 'png' && imageExtension != 'jpg' && imageExtension != 'jpeg' && imageExtension != '')|| size > 3)
			{
			     alert("Fail to sign up");
			}
			else 
			{
			    alert("Sign up successfully");
			}
        });
	});
	/*function myFunction(){
		username = document.getElementById("username");
		pass = document.getElementById("pass");
		email = document.getElementById("email");
		picture =document.getElementById("fileUpload");
		var size = parseFloat(picture.files[0].size / (1024 * 1024)).toFixed(2);
		image = document.querySelector('#fileUpload').value;
        imageExtension = image.split('.').pop();
		if((username.value.search(/^[a-zA-Z0-9]*$/) == -1 ) ||
		   (pass.value.search(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/) == -1 ) || 
		   (email.value.search(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)==-1)
		   ||(imageExtension != "png" && imageExtension != "jpg" && imageExtension != "jpeg" && imageExtension != "") || size>3)
		  {
			alert("Fail to sign up");
		  }
		else 
		  {
            alert("Sign up successfully");
		  }			
	}*/
	</script>
</body>
</html>