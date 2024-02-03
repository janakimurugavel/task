<?php
include 'db_connection.php';

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];

    // Fetch user data from the database based on the ID
    $sql = "SELECT * FROM user WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "User ID not provided.";
    exit();
}

// Handle form submission for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['new_username'];
    $newLastname = $_POST['new_lastname'];
    $newEmail = $_POST['new_email'];
    $newAddress = $_POST['new_address'];
    $newCity = $_POST['new_city'];
    $newState = $_POST['new_state'];
    $newDOB = $_POST['new_dob'];
    $newPhonenumber = $_POST['new_phoneNumber'];
    $newZip = $_POST['new_zip'];

    // Use prepared statements to prevent SQL injection
    $updateSql = $conn->prepare("UPDATE user SET username=?, lastname=?, email=?, address=?, city=?, state=?, dob=?, phoneNumber=?, zip=? WHERE id = ?");
    $updateSql->bind_param("sssssssssi", $newUsername, $newLastname, $newEmail, $newAddress, $newCity, $newState, $newDOB, $newPhonenumber, $newZip, $userId);

    if ($updateSql->execute()) {
        echo "User data updated successfully!";
    } else {
        echo "Error updating user data: " . $conn->error;
        // Add the following line to print the SQL query for debugging
        echo "SQL Query: " . $updateSql->error;
    }

    $updateSql->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Form</title>
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .error-message {
            color: red;
        }
    </style>


    <script>
        function validateInput(input) {
            input.value = input.value.replace(/\D/g, ''); // Allow only digits
        }

        function validateName(inputId) {
            var nameInput = document.getElementById(inputId);
            nameInput.value = nameInput.value.replace(/[^A-Za-z\s']/g, ''); // Allow only alphabets and single quotes
        }

        function validateEmail() {
            var emailInput = document.getElementById("new_email");
            var email = emailInput.value.trim();

            // Email validation using a simple regex
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '' || !emailRegex.test(email)) {
                document.getElementById("emailError").textContent = 'Please enter a valid email address.';
                return false;
            } else {
                document.getElementById("emailError").textContent = '';
                return true;
            }
        }

        function validateForm() {
            var username = document.getElementById("new_username").value;
            var lastname = document.getElementById("new_lastname").value;
            var city = document.getElementById("new_city").value;
            var state = document.getElementById("new_state").value;
            var phoneNumber = document.getElementById("new_phoneNumber").value;
            var zip = document.getElementById("new_zip").value;

            // Check if the username is not empty
            if (username.trim() === '') {
                alert("Please enter a valid username.");
                return false;
            }

            if (lastname.trim() === '') {
                alert("Please enter a valid lastname.");
                return false;
            }

            // Check if the district is not empty
            if (city.trim() === '') {
                alert("Please enter a valid city.");
                return false;
            }

            // Check if the state is not empty
            if (state.trim() === '') {
                alert("Please enter a valid state.");
                return false;
            }

            // Check if the phone number contains only digits and has a length of exactly 10
            if (!/^\d{10}$/.test(phoneNumber)) {
                alert("Please enter a valid phone number with a length of exactly 10 digits.");
                return false;
            }
            if (!/^\d{5}$/.test(zip)) {
                alert("Please enter a valid zip number with a length of exactly 5 digits.");
                return false;
            }

            // Check email validation
            if (!validateEmail()) {
                return false;
            }

            return true;
        }
    </script>

    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        h2 {
            color: #fbfbfb;
            margin-bottom: 20px;
            background: #2b2b6b;
            text-align: left;
            padding: 5px;
        }

        form {
            /* max-width: 600px;*/
            margin: 0 auto;
            background-color: #ccc;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #AE2121;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            left: 87%;
        }

        input[type="submit"]:hover {
            background-color: #ae2121;
        }

        .footer {
            background-color: #AE2121;
            /* Set your desired background color */
            color: #fff;
            /* Set the text color */
            padding: 20px;
            text-align: center;
            margin-left: -20px;
            margin-right: -20px;
        }

        .contact-address {
            font-size: 14px;
            margin-top: 10px;
        }

        .navbar {
            background-color: #067a78;
            /* Set the navbar background color */
            overflow: hidden;
            padding: 10px;
            margin-top: -20px;
            margin-left: -20px;
            margin-right: -20px;
        }

        .logo {
            float: left;
            display: inline-block;
            color: #fff;
            /* Set the logo text color */
            font-size: 20px;
            margin-left: 20px;
        }

        .nav-links {
            float: right;
            display: inline-block;
            margin-right: 20px;
        }

        .nav-links a {
            color: #fff;
            /* Set the link text color */
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="http://www.synthesishealthsoft.in/images/Synthsis_Healthsoft.png" width="100px" height="45px">
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="#">About Us</a>
            <a href="#">Login</a>
            <a href="display_users.php">Registration</a>
        </div>
    </div>
    <!--side bar starts here-->
<style> 

.nav-pills > li > a {
   border-radius: 0;
}

#wrapper {
   padding-left: 0;
   -webkit-transition: all 0.5s ease;
   -moz-transition: all 0.5s ease;
   -o-transition: all 0.5s ease;
   transition: all 0.5s ease;
   overflow: hidden;
}

#wrapper.toggled {
   padding-left: 250px;
   overflow: hidden;
}

#sidebar-wrapper {
   z-index: 1000;
   position: absolute;
   left: 250px;
   width: 0;
   height: 100%;
   margin-left: -250px;
   overflow-y: auto;
   background: #f8f9fa;
   -webkit-transition: all 0.5s ease;
   -moz-transition: all 0.5s ease;
   -o-transition: all 0.5s ease;
   transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
   width: 250px;
}

#page-content-wrapper {
   position: absolute;
   padding: 15px;
   width: 100%;
   overflow-x: hidden;
}

.xyz {
   min-width: 360px;
}

#wrapper.toggled #page-content-wrapper {
   position: relative;
   margin-right: 0px;
}

.fixed-brand {
   width: auto;
}
/* Sidebar Styles */

.sidebar-nav {
   position: absolute;
   top: 0;
   width: 250px;
   margin: 0;
   padding: 0;
   list-style: none;
   margin-top: 2px;
}

.sidebar-nav li {
   text-indent: 15px;
   line-height: 40px;
}

.sidebar-nav li a {
   display: block;
   text-decoration: none;
   color: #999999;
}

.sidebar-nav li a:hover {
   text-decoration: none;
   color: #fff;
   background: rgba(255, 255, 255, 0.2);
   border-left: red 2px solid;
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
   text-decoration: none;
}

.sidebar-nav > .sidebar-brand {
   height: 65px;
   font-size: 18px;
   line-height: 60px;
}

.sidebar-nav > .sidebar-brand a {
   color: #999999;
}

.sidebar-nav > .sidebar-brand a:hover {
   color: #fff;
   background: none;
}

.no-margin {
   margin: 0;
}
#sidebar-wrapper{
    width: 16%!important;
    height: 96%!important;
}
@media (min-width: 768px) {
   #wrapper {
      padding-left: 250px;
   }
   .fixed-brand {
      width: 250px;
   }
   #wrapper.toggled {
      padding-left: 0;
   }
   #sidebar-wrapper {
      width: 250px;
   }
   #wrapper.toggled #sidebar-wrapper {
      width: 250px;
   }
   #wrapper.toggled-2 #sidebar-wrapper {
      width: 50px;
   }
   #wrapper.toggled-2 #sidebar-wrapper:hover {
      width: 250px;
   }
   #page-content-wrapper {
      padding: 20px;
      position: relative;
      -webkit-transition: all 0.5s ease;
      -moz-transition: all 0.5s ease;
      -o-transition: all 0.5s ease;
      transition: all 0.5s ease;
   }
   #wrapper.toggled #page-content-wrapper {
      position: relative;
      margin-right: 0;
      padding-left: 250px;
   }
   #wrapper.toggled-2 #page-content-wrapper {
      position: relative;
      margin-right: 0;
      margin-left: -200px;
      -webkit-transition: all 0.5s ease;
      -moz-transition: all 0.5s ease;
      -o-transition: all 0.5s ease;
      transition: all 0.5s ease;
      width: auto;
   }
}
</style>
<script>
    $("#menu-toggle").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled");
});
$("#menu-toggle-2").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled-2");
   $('#menu ul').hide();
});

function initMenu() {
   $('#menu ul').hide();
   $('#menu ul').children('.current').parent().show();
   //$('#menu ul:first').show();
   $('#menu li a').click(
      function() {
         var checkElement = $(this).next();
         if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            return false;
         }
         if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('#menu ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
            return false;
         }
      }
   );
}
$(document).ready(function() {
   initMenu();
});
</script>
<div id="sidebar-wrapper">
         <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
            <li class="active">
               <a href="https://www.synthesishealthinc.com/" style="color: #fff;background: #2b2b6b;"><i class="fa fa-credit-card" style="font-size:24px"></i> Total Price</a>
               <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                  <li><a href="https://www.synthesishealthinc.com/"><i class='fas fa-dollar-sign' style='font-size:24px'></i>0</a></li>
                 
               </ul>
            </li>
            <li>
               <a href="#" style="color: #fff;background: #2b2b6b;"><span class="fa-stack fa-lg pull-left"><i class="fa fa-flag fa-stack-1x "></i></span>CATEGORY</a>
               <ul class="nav-pills nav-stacked" style="list-style-type:none;">
               </ul>
            </li>
            <li>
               <a href="#" style="color: #fff;background: #bd2130;"><i class="fa fa-address-book" style="font-size:24px"></i> Contact Information</a>
            </li>
            <li>
               <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cloud-download fa-stack-1x "></i></span>Plan Options</a>
            </li>
            <li>
               <a href="#"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-cart-plus fa-stack-1x "></i></span>Dependents</a>
            </li>
            <li>
               <a href="#"><i class="fa fa-credit-card" style="font-size:24px"></i> Payments</a>
            </li>
            <li>
               <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-wrench fa-stack-1x "></i></span>Agreements</a>
            </li>
            <li>
               <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-server fa-stack-1x "></i></span>Confirmation</a>
            </li>
         </ul>
      </div>
      <!--side bar end-->
    <div class="container"style="margin-left: 14%;width: 100%;padding-right: 0px;margin-right: auto;position: relative;left: 5px";>
    <h2>MEMBER ENROLLMENT</h2>
    <h6 style="color: red;">DEMOGRAPHIC DETAILS</h6>
    <p>Start with primary Member. One adult in the family to be the contact person of the application.</p>
        <form action="" method="post" onsubmit="return validateForm()">
            <div class="row col-md-12">
                <div class="col-xs-12 col-sm-4">
                    <label for="new_username">Username:</label>
                    <input type="text" class="form-control" id="new_username" name="new_username" oninput="validateName('new_username')" value="<?php echo $user['username']; ?>" required>
                    <span id="usernameError" class="error-message"></span><br>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label for="new_lastname">Lastname:</label>
                    <input type="text" class="form-control" id="new_lastname" name="new_lastname" oninput="validateName('new_lastname')" value="<?php echo $user['lastname']; ?>" required>
                    <span id="lastnameError" class="error-message"></span><br>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label for="new_address">Address:</label>
                    <input type="text" class="form-control" id="new_address" name="new_address" pattern="^[a-zA-Z0-9\s\-\.,#]*$" value="<?php echo $user['address']; ?>" required>
                    <span id="addressError" class="error-message"></span><br>
                </div>
            </div>

            <div class="row col-md-12">
                <div class="col-xs-12 col-sm-4">
                    <label for="new_city">City:</label>
                    <input type="text" class="form-control" id="new_city" name="new_city" oninput="validateName('new_city')" value="<?php echo $user['city']; ?>" required>
                    <span id="cityError" class="error-message"></span><br>
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="new_state">State:</label>
                    <select class="form-control" id="new_state" name="new_state" required>
                        <option value="">Select State</option>
                        <option value="California" <?php echo ($user['state'] == 'California') ? 'selected' : ''; ?>>California</option>
                        <option value="New York" <?php echo ($user['state'] == 'New York') ? 'selected' : ''; ?>>New York</option>
                        <option value="Texas" <?php echo ($user['state'] == 'Texas') ? 'selected' : ''; ?>>Texas</option>
                        <option value="Florida" <?php echo ($user['state'] == 'Florida') ? 'selected' : ''; ?>>Florida</option>
                    </select><br>
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="new_email">Email:</label>
                    <input type="text" class="form-control" id="new_email" name="new_email" oninput="validateEmail()" value="<?php echo $user['email']; ?>" required><br>
                    <span id="emailError" class="error-message"></span><br>
                </div>
            </div>

            <div class="row col-md-12">
                <div class="col-xs-12 col-sm-4">
                    <label for="new_dob">Date of Birth:</label>
                    <input type="date" class="form-control" id="new_dob" name="new_dob" max="2005-12-31" min="1950-01-01" value="<?php echo $user['dob']; ?>" required><br>
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="new_phoneNumber">Phone Number:</label>
                    <input type="tel" class="form-control" id="new_phoneNumber" name="new_phoneNumber" maxlength="10" oninput="validateInput(this)" value="<?php echo $user['phoneNumber']; ?>" required>
                    <br>
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="new_zip">Zip:</label>
                    <input type="tel" class="form-control" id="new_zip" name="new_zip" maxlength="5" oninput="validateInput(this)" value="<?php echo $user['zip']; ?>" required>
                    <br>
                </div>
            </div>

            <input type="submit" value="Update">
        </form>
        <!-- Bootstrap JS and Popper.js (optional) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    <!--Footer starts-->
    <div class="footer">
        <p>&copy; 2024 Your Website. All rights reserved.</p>
        <div class="contact-address">
            <p>Contact us at:</p>
            <address>
                Your Company Name<br>
                123 Main Street, Cityville<br>
                State, Country<br>
                Phone: +1 (123) 456-7890<br>
                Email: info@yourwebsite.com
            </address>
        </div>
    </div>
</body>

</html>