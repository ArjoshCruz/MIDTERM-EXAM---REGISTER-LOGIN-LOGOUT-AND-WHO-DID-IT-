<?php require_once '../core/handleForms.php'?>
<?php require_once '../core/models.php'?>

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
    
    <h2 style="margin-top: 30px;">ADMINS</h2>
    <table style="width:50%; margin: auto; ">
            <tr>
                <th style="text-align: center;">Admin List</th>
            </tr>

            <?php
            $getAllUsers = getAllUsers($pdo);
            foreach ($getAllUsers as $row) { ?>
            <tr>
                <td style="text-align: center;">
                    <a href="viewuser.php?user_id=<?php echo $row['user_id']; ?>&username=<?php echo $row['username']; ?>">
                    <?php echo htmlspecialchars($row['username']); ?>
                    </a>
                </td>
                
            </tr>
            <?php }?>
        </table>

</body>
</html>
