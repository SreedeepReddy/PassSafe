<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: welcome.php");
}

$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Welcome Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-darkmode@1.0.0/dist/bootstrap-darkmode.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-darkmode@1.0.0/dist/bootstrap-darkmode.min.js"></script>
    <div class="header">
      <img src="http://localhost/PassSafe/Assets/Images/PassSafe_White.png" alt="PassSafe">
    </div>
	<style>
		.container {
			width: 1000px;
		}
	</style>
    <script type="text/javascript">
      function validateForm() {
        var siteName = document.forms["addSiteForm"]["siteName"].value;
		var username = document.forms["addSiteForm"]["userName"].value;
        var password = document.forms["addSiteForm"]["password"].value;
        if (siteName == "" || userName == "" || password == "") {
          alert("Site, Username, and Password must be filled out");
          return false;
        }
      }

      function togglePasswordVisibility(id) {
        var censor = document.getElementById(id);
        if (censor.type === "password") {
          censor.type = "text";
        } else {
          censor.type = "password";
        }
      }

      function generatePassword() {
        var length = 16,
          charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@",
          retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
          retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        document.getElementById("password").value = retVal;
      }
    </script>
  </head>
  <body>
    <div class="container">
      <h1>Welcome, <?php echo $username; ?>! </h1>
      <h1>Here are your saved passwords</h1>
      <table class = "table">
        <tr>
          <th>Site</th>
		  <th>Username</th>
          <th>Password</th>
		  <th>Date Added</th>
        </tr> <?php
        $hostname = "localhost";
        $database = "pass_safe";
        $user = "pass_safe_admin";
        $pass = "oPjhF0#i3707";
        $conn = mysqli_connect($hostname, $user, $pass, $database);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT site_name, user_name, password, entry_date FROM sites where user = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
										<tr>
											<td>" .
                    $row["site_name"] .
                    "</td>
											<td>" .
                    $row["user_name"] .
                    "</td>
											<td>
												<input type='password' id='password_" .
                    $row["site_name"] .
                    "' value='" .
                    $row["password"] .
                    "'>
													<label for='password_" .
                    $row["site_name"] .
                    "'>
														<span onclick='togglePasswordVisibility(\"password_" .
                    $row["site_name"] .
                    "\")'>Show/Hide</span>
													</label>
												</td>
											<td>" .
                    $row["entry_date"] .
                    "</td>
											</tr>";
            }
        } else {
            echo "
											<tr>
												<td colspan='2'>No saved sites found</td>
											</tr>";
        }

        mysqli_close($conn);
        ?>
      </table>
	  	      <button type="button" class="btn btn-dark" id="Delete">Delete</button>
      <script type="text/javascript">
        			var btn = document.getElementById('Delete');
btn.addEventListener('click', function() {
  document.location.href = 'delete.php';
});
	</script>
	  </div>
	  <div class = "container">
      <h2>Add a new site</h2>
      <form name="addSiteForm" action="add_site.php" onsubmit="return validateForm()" method="post">
        <div class="form-group">
          <label for="siteName">Site</label>
          <input type="text" id="siteName" name="siteName">
        </div>
		<div class="form-group">
          <label for="userName">Username</label>
          <input type="text" id="userName" name="userName">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password">
          <button type="button" class="btn btn-dark" value="Generate Secure Password" onclick="generatePassword()">Generate Secure Password</button>
        </div>
        <button type="submit">Add Site</button>
      </form>
    </div>
	<div class = "container">
	      <button type="button" class="btn btn-dark" id="Logout">Logout</button>
      <script type="text/javascript">
			var btn = document.getElementById('Logout');
btn.addEventListener('click', function() {
  document.location.href = 'logout.php';
});
      </script>
	</div>
  </body>
</html>