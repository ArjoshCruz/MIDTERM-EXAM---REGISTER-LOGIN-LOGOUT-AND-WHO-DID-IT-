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
    <title>ABC Tutoring School</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    
    <?php if (isset($_SESSION['username'])) {?>
    <header>
        <h1>Welcome to <span class="A">A</span><span class="B">B</span><span class="C">C</span> Tutoring School!</h1>
        <h2>Hello there admin <u><i><?php echo $_SESSION['username'];?></i></u>!</h2>

        <div class="admin-action">
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="acc/viewAllUsers.php">See Admin List</a>
                </li>
                <li>
                    <a href="auditLog.php">Audit Log</a>
                </li>
                <li>
                    <a href="core/handleForms.php?logoutAUser=1">Logout</a>
                    <?php } else { echo "<h1>No user Logged in</h1>";}?>
                </li>
            </ul>
        </div>
    </header>
    


    <section class="form-div" style="flex-direction: column; align-items: center; background-color: rgb(209, 243, 255);">
        <h2>Add a new Tutor &darr;</h2>
        <div class="sky">
            <img class="sun" src="img/sun.png" alt="" />
            <img class="cloud" src="img/cloud2.png" alt="" />
            <img class="cloud" src="img/cloud2.png" alt="" />
            <img class="cloud" src="img/cloud2.png" alt="" />
            <img class="cloud" src="img/cloud2.png" alt="" />
        </div>
        <form action="core/handleForms.php" method="POST">
            <p class="input-data">
                <label for="firstName">First Name: </label>
                <input type="text" name="firstName" required placeholder="e.g. Bobby">
            </p>
            <p class="input-data">
                <label for="lastName">Last Name: </label>
                <input type="text" name="lastName" required placeholder="e.g. Lee">
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
                <input type="number" name="age" required placeholder="e.g. 25">
            </p>
            <p class="input-data">
                <label for="subjectSpecialization">Subject Specialization: </label>
                <input type="text" name="subjectSpecialization" required placeholder="e.g. Physics">
            </p>
            <p class="btn">
                <input class="submit-btn" type="submit" name="insertNewTutorBtn">
            </p>
        </form>
    </section>
    
    <section style="background-color: rgb(161, 249, 161); text-align: center; margin: 0; display: flex; justify-content: center; padding-bottom: 20px;">
        <h3 style="background-color: rgb(161, 249, 161); padding-top: 20px;">Tutor Records:</h3>
    </section>
    <section class="table" style="padding-top: 0;">
        <table style="width:100%; margin:50px 20px 0; ">
            <tr>
                <th>Tutor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Subject Specialization</th>
                <th>Created by</th>
                <th>Date Added</th>
                <th>Pupils</th>
                <th>Action</th>
                <th>Updated By</th>
                <th>Date Updated</th>
            </tr>

            <?php $seeAllTutor = getAllTutors($pdo)?>
            <?php foreach ($seeAllTutor as $row) {?>
            <tr>
                <td><?php echo $row['tutor_id']?></td>
                <td><?php echo $row['first_name']?></td>
                <td><?php echo $row['last_name']?></td>
                <td><?php echo $row['gender']?></td>
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['subject_specialization']?></td>
                <td><?php echo $row['created_by']?></td>
                
                <td><?php echo $row['date_added']?></td>

                
                <td>
                <a href="pupil/newPupil.php?tutor_id=<?php echo $row['tutor_id'];?>">View Pupils</a>
                </td>
                <td>
                    <a href="tutor/editTutor.php?tutor_id=<?php echo $row['tutor_id'];?>">Edit</a>
                    <a href="tutor/deleteTutor.php?tutor_id=<?php echo $row['tutor_id'];?>">Delete</a>
                </td>
                <td><?php echo $row['updated_by']?></td>

                <td><?php echo $row['date_updated']?></td>
            </tr>
            <?php }?>
        </table>
    </section>

</body>
</html>