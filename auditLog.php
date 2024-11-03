<?php
    require_once 'core/dbConfig.php';
    require_once 'core/models.php';
    
    if (!isset($_SESSION['username'])) {
        header("Location: acc/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body style="background-color: rgb(209, 243, 255);">
    <?php if (isset($_SESSION['username'])) {?>
    <header>
        <h1>Welcome to <span class="A">A</span><span class="B">B</span><span class="C">C</span> Tutoring School!</h1>

        <div class="admin-action">
            <ul class="ul-head">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li class="li-head">
                    <a href="acc/viewAllUsers.php" class="a-head">See Admin List</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="auditLog.php">Audit Log</a>
                </li>
                <li class="li-head" class="a-head">
                    <a href="core/handleForms.php?logoutAUser=1">Logout</a>
                    <?php } else { echo "<h1>No user Logged in</h1>";}?>
                </li>
            </ul>
        </div>
    </header>

    <h2 style="margin-top: 30px; padding-bottom: 0;">AUDIT LOGS</h2>

<section class="table" style="padding-top: 0; background-color: rgb(209, 243, 255);">
        <table style="width:80%; margin:50px 20px 0; ">
            <tr>
                <th>Audit ID</th>
                <th>Username</th>
                <th>Action Made</th>
                <th>Attribute ID</th>
                <th>Details</th>
                <th>Date</th>
            </tr>

            <?php $getAllAuditLog = getAllAuditLog($pdo)?>
            <?php foreach ($getAllAuditLog as $row) {?>
            <tr>
                <td><?php echo $row['audit_id']?></td>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['action_made']?></td>
                <td><?php echo $row['attribute_id']?></td>
                <td><?php echo $row['details']?></td>
                <td><?php echo $row['date_added']?></td>

            </tr>
            <?php }?>
        </table>
    </section>
</body>
</html>