<?php
include 'db_connection.php';
include 'delete.php';

// Define the number of records to display per page
$recordsPerPage = 10;

// Determine the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$startFrom = ($page - 1) * $recordsPerPage;

// Fetch user data from the database for the current page
$sql = "SELECT * FROM user LIMIT $startFrom, $recordsPerPage";
$result = $conn->query($sql);

// Fetch total number of records for pagination
$totalRecords = $conn->query("SELECT COUNT(*) as total FROM user")->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data Display</title>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        h2 {
            color: #0a0b0b;
            margin-bottom: 20px;
        }

        form {
           /* max-width: 600px;*/
            margin: 0 auto;        
            padding: 20px;
            border: 1px solid #dee2e6;
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
            background-color: #AE2121; /* Set your desired background color */
            color: #fff; /* Set the text color */
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
            background-color: #067a78; /* Set the navbar background color */
            overflow: hidden;
            padding: 10px;
            margin-top: -20px;
    margin-left: -20px;
    margin-right: -20px;
        }

        .logo {
            float: left;
            display: inline-block;
            color: #fff; /* Set the logo text color */
            font-size: 20px;
            margin-left: 20px;
        }

        .nav-links {
            float: right;
            display: inline-block;
            margin-right: 20px;
        }

        .nav-links a {
            color: #fff; /* Set the link text color */
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }
    </style>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .page-link {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #ddd;
            text-decoration: none;
            color: black;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .delete-btn {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    border-radius: 5px;
    cursor: pointer;
}

.edit-btn,
    .delete-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 5px; /* Add margin between buttons */
    }

    .delete-btn {
        background-color: #e01806;
    }

    </style>
</head>
<body>
<div class="navbar">
<div class="logo">
        <img src="http://www.synthesishealthsoft.in/images/Synthsis_Healthsoft.png" width="100px" height="45px" >
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="#">About Us</a>
        <a href="#">Login</a>
        <a href="display_users.php">Registration</a>
    </div>
</div>
    <h2>User Data Display</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Username</th>
                <th>lastname</th>
                <th>Email</th>
                <th>Address</th>
                <th>city</th>
                <th>State</th>
                <th>DOB</th>
                <th>phoneNumber</th>
                <th>zip</th>
                <th colspan="2">Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['state']; ?></td>
                    <td><?php echo $row['dob']; ?></td>
                    <td><?php echo $row['phoneNumber']; ?></td>
                    <td><?php echo $row['zip']; ?></td>
                    <td>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a> </td>
            <td><form method="post" action="">
                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="delete-btn">Delete</button></td>
            </form>
                   
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Pagination links -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p>No user data available.</p>
    <?php endif; ?>
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