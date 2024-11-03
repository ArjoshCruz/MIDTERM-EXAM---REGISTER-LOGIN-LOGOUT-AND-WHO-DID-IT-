<?php require_once '../core/handleForms.php'?>
<?php require_once '../core/models.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pupil</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body style="background-color: rgb(209, 243, 255);">
    <?php $getPupilById = getPupilById($pdo, $_GET['pupil_id']); ?>
    <header>
        <h1>Welcome to <span class="A">A</span><span class="B">B</span><span class="C">C</span> Tutoring School!</h1>
        <h2>Are you sure you want to delete, <?php echo $getPupilById['pupil_first_name']?>!</h2>
    </header>

    <section class="form-div">
        <div class="sky">
            <img class="sun" src="../img/sun.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />

        </div>
        <a class="back-btn" href="newPupil.php?tutor_id=<?php echo $_GET['tutor_id']; ?>"><button class="back-btn">G<br>O<br><br>B<br>A<br>C<br>K</button></a>
        
        <form action="../core/handleForms.php?pupil_id=<?php echo $_GET['pupil_id']; ?>&tutor_id=<?php echo $_GET['tutor_id']; ?>" method="POST">
            <p class="input-data">
                <label for="firstName">First Name: </label>
                <input type="text" name="firstName" required value="<?php echo $getPupilById['pupil_first_name']; ?>">
            </p>
            <p class="input-data">
                <label for="lastName">Last Name: </label>
                <input type="text" name="lastName" required value="<?php echo $getPupilById['pupil_last_name']; ?>">
            </p>
            <p class="input-data">
                <label for="gender">Gender: </label>
                <select name="gender">
                <option value="Male" <?php if ($getPupilById['pupil_gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($getPupilById['pupil_gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Prefer Not to Say" <?php if ($getPupilById['pupil_gender'] == 'Prefer Not to Say') echo 'selected'; ?>>Prefer Not to Say</option>
                </select>
            </p>               
            <p class="input-data">
                <label for="age">Age: </label>
                <input type="number" name="age" required value="<?php echo $getPupilById['pupil_age']; ?>">
            </p>
            
            <p class="btn">
                <input class="submit-btn" type="submit" value="Edit Pupil Info" name="editPupilBtn">
            </p>

        </form>
        
    </section>

  

</body>
</html>