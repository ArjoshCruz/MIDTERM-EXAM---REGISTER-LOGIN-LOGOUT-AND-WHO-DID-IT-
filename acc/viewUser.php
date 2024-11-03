<?php 
require_once '../core/dbConfig.php';
require_once '../core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: acc/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pupil</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body style="background-color: rgb(209, 243, 255);">
    
    <?php if (isset($_SESSION['username'])) {?>
    <header>
        <h1>Welcome to <span class="A">A</span><span class="B">B</span><span class="C">C</span> Tutoring School!</h1>

        <div class="admin-action">
            <ul class="ul-head">
                <li>
                    <a href="../index.php">Home</a>
                </li>
                <li class="li-head">
                    <a href="viewAllUsers.php" class="a-head">See Admin List</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="../auditLog.php">Audit Log</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="../core/handleForms.php?logoutAUser=1">Logout</a>
                    <?php } else { echo "<h1>No user Logged in</h1>";}?>
                </li>
            </ul>
        </div>
    </header>

    <section style="margin-top: 50px;">
        <?php $getUserByID = getUserByID($pdo, $_GET['user_id']);?>
        <h2>Username: <?php echo $getUserByID['username'];?></h2>
        <h2>Firstname: <?php echo $getUserByID['first_name'];?></h2>
        <h2>Lastname: <?php echo $getUserByID['last_name'];?></h2>
        <h2>Date Joined: <?php echo $getUserByID['date_added'];?></h2>
    </section>
</body>
</html>
