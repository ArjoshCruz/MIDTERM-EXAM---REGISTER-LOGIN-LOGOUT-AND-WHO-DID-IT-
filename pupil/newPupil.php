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
    <?php $getTutorById = getTutorByID($pdo, $_GET['tutor_id']); ?>
    <header>
        <h1>Tutor <u><i><span style="color: #ffffba;"><?php echo $getTutorById['first_name']?></span>'s</i></u> Pupils </h1><br>
    </header>

    <section style="background-color: rgb(209, 243, 255); text-align: center; margin: 0;">
        <h2 style="padding:50px 0 0 0;">Add/Edit/Delete Pupil</h2>
    </section>

    <section class="form-div" style="padding:50px 0;">
        <div class="sky">
            <img class="sun" src="../img/sun.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />
            <img class="cloud" src="../img/cloud2.png" alt="" />

        </div>
        <form action="../core/handleForms.php?tutor_id=<?php echo $_GET['tutor_id']; ?>" method="POST">
            <p class="input-data">
                <label for="firstName">First Name: </label>
                <input type="text" name="firstName" required placeholder="e.g. Razzle">
            </p>
            <p class="input-data">
                <label for="lastName">Last Name: </label>
                <input type="text" name="lastName" required placeholder="e.g. Dazzle">
            </p>
            <p class="input-data">
                <label for="gender">Gender: </label>
                <select name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer Not to Say">Prefer Not to Say</option>
                </select>
            </p>               
            <p class="input-data">
                <label for="age">Age: </label>
                <input type="number" name="age" required placeholder="e.g. 12">
            </p>
            <p>
                <input class="submit-btn" type="submit" value="Add Pupil" name="addPupilBtn">
            </p>

        </form>
        
    </section>
    <section style="background-color: rgb(209, 243, 255); text-align: center; margin: 0; display: flex; justify-content: center; padding-bottom: 20px;">
        <a class="back-btn" style="padding: 10px 20px; width: 200px;" href="../index.php"><button class="back-btn" style="padding: 10px 20px; width: 200px;">Back to Main</button></a>
    </section>


    <!-- PUPIL RECORDS -->
    <section style="background-color: rgb(161, 249, 161); text-align: center; margin: 0; display: flex; justify-content: center; padding-bottom: 20px;">
        <h3 style="background-color: rgb(161, 249, 161); padding-top: 20px;">Pupil Records:</h3>
    </section>
    <section class="table">


        <table style="width:50%; padding-top: 0;">
            <tr>
                <th>Pupil ID</th>
                <th>Pupil First Name</th>
                <th>Pupil Last Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Created by</th>
                <th>Date Added</th>
                <th>Action</th>
                <th>Updated By</th>
                <th>Date Updated</th>
            </tr>

            <?php $seeAllPupil = getPupilsByTutor($pdo, $_GET['tutor_id'])?>
            <?php foreach ($seeAllPupil as $row) {?>
            <tr>
                <td><?php echo $row['pupil_id']?></td>
                <td><?php echo $row['pupil_first_name']?></td>
                <td><?php echo $row['pupil_last_name']?></td>
                <td><?php echo $row['pupil_gender']?></td>
                <td><?php echo $row['pupil_age']?></td>
                <td><?php echo $row['pupil_created_by']?></td>
                <td><?php echo $row['pupil_date_added']?></td>
                <td>
                    <a href="editPupil.php?tutor_id=<?php echo $_GET['tutor_id']; ?>&pupil_id=<?php echo $row['pupil_id']; ?>">Edit</a>
                    <a href="deletePupil.php?tutor_id=<?php echo $_GET['tutor_id']; ?>&pupil_id=<?php echo $row['pupil_id']; ?>">Delete</a>
                </td>
                <td><?php echo $row['pupil_updated_by']?></td>

                <td><?php echo $row['pupil_date_updated']?></td>
            </tr>
            <?php }?>
        </table>
    </section>
</body>
</html>