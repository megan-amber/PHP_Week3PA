<?php
    //Connect to the database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sdc310_wk3pa";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
  
    //Establish variables to support CRUD
    $userNo = -1;
    $fullName = "";
    $birthdate = "";
    $faveColor = "";
    $favePlace = "";
    $nickname = "";

    //Variables to determine type of operation
    $add = false;
    $edit = false;
    $update = false;
    $delete = false;

    if(isset($_POST['user_no'])) {
        $userNo = $_POST['user_no'];
        $add = isset($_POST['add']);
        $update = isset($_POST['update']);
        $edit = isset($_POST['edit']);
        $delete = isset($_POST['delete']);
    }

    if($add) {
        //Add a new user
        $fullName = $_POST['name'];
        $birthdate = $_POST['birthdate'];
        $faveColor = $_POST['fave_color'];
        $favePlace = $_POST['fave_place'];
        $nickname = $_POST['nickname'];

        $addQuery = "INSERT INTO personal_info (FullName, Birthdate, FavoriteColor, FavoritePlace, Nickname)
            VALUES ('$fullName', '$birthdate', '$faveColor', '$favePlace', '$nickname')";
        mysqli_query($conn, $addQuery);

        //Clear the fields
        $userNo = -1;
        $fullName = "";
        $birthdate = "";
        $faveColor = "";
        $favePlace = "";
        $nickname = "";
    }
    else if($edit) {
        //Edit an existing user
        $editQuery = "SELECT * FROM personal_info WHERE UserNo = $userNo";
        $result = mysqli_query($conn, $editQuery);
        $row = mysqli_fetch_assoc($result);

        //Fill the fields with the existing data
        $fullName = $row['FullName'];
        $birthdate = $row['Birthdate'];
        $faveColor = $row['FavoriteColor'];
        $favePlace = $row['FavoritePlace'];
        $nickname = $row['Nickname'];
    }
    else if($update) {
        //Update an existing user
        $fullName = $_POST['name'];
        $birthdate = $_POST['birthdate'];
        $faveColor = $_POST['fave_color'];
        $favePlace = $_POST['fave_place'];
        $nickname = $_POST['nickname'];

        $updateQuery = "UPDATE personal_info SET FullName='$fullName', Birthdate='$birthdate', FavoriteColor='$faveColor', FavoritePlace='$favePlace', Nickname='$nickname' WHERE UserNo=$userNo";
        mysqli_query($conn, $updateQuery);

        //Clear the fields
        $userNo = -1;
        $fullName = "";
        $birthdate = "";
        $faveColor = "";
        $favePlace = "";
        $nickname = "";
    }
    else if($delete) {
        //Delete an existing user
        $deleteQuery = "DELETE FROM personal_info WHERE UserNo=$userNo";
        mysqli_query($conn, $deleteQuery);
        $userNo = -1;
        
    }

    //Query for all users
    $query = "SELECT * FROM personal_info";
    $result = mysqli_query($conn, $query);
?>

<style>
    table {
        border-spacing: 5px;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        text-align: center;
    }
    th {
        background-color: lavender;
    }
    tr:nth-child(even) {
        background-color: ghostwhite;
    }
    tr:nth-child(odd) {
        background-color: mintcream;
    }
    tr:hover {
        background-color: thistle;
    }
</style>

<html>
    <head>
        <title>Week 3 GP2 - Megan Gerth</title>
    </head>
    <body>
        <h2>Current Users:</h2>
        <table>
            <tr style="font-size:large;">
                <th>User No</th>
                <th>Full Name</th>
                <th>Birthdate</th>
                <th>Favorite Color</th>
                <th>Favorite Place</th>
                <th>Nickname</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)):;?>
                <tr>
                    <td><?php echo $row['UserNo'];?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['Birthdate'];?></td>
                    <td><?php echo $row['FavoriteColor'];?></td>
                    <td><?php echo $row['FavoritePlace'];?></td>
                    <td><?php echo $row['Nickname'];?></td>
                    <td>
                        <form method="POST">
                            <input type="submit" name="edit" value="Edit">
                            <input type="hidden" name="user_no" value="<?php echo $row['UserNo'];?>">
                        </form>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="submit" name="delete" value="Delete">
                            <input type="hidden" name="user_no" value="<?php echo $row['UserNo'];?>">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?> 
        </table>
        <form method="POST">
            <input type="hidden" name="user_no" value="<?php echo $userNo;?>">
            <h3>Enter your full name:</h3>
            <input type="text" id="full_name" name="full_name" value="<?php echo $fullName;?>" required><br>
            <h3>Enter your birthdate:</h3>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate;?>" required><br>
            <h3>Enter your favorite color:</h3>
            <input type="text" id="fave_color" name="fave_color" value="<?php echo $faveColor;?>" required><br>
            <h3>Enter your favorite place:</h3>
            <input type="text" id="fave_place" name="fave_place" value="<?php echo $favePlace;?>" required><br>
            <h3>Enter your nickname:</h3>
            <input type="text" id="nickname" name="nickname" value="<?php echo $nickname;?>" required><br>
            <?php if(!$edit): ?>
                <input type="submit" name="add" value="Add User" style="margin-top: 10px;">
            <?php else: ?>
                <input type="submit" name="update" value="Update User" style="margin-top: 10px;">
            <?php endif; ?>
        </form>
    </body>
</html>
