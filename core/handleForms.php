<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConfig.php';
require_once 'models.php';
require_once 'validate.php';

if (isset($_POST['insertNewTutorBtn'])) {
    $created_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $gender = sanitizeInput($_POST['gender']);
    $age = sanitizeInput($_POST['age']);
    $subject_specialization = sanitizeInput($_POST['subjectSpecialization']);

    $query = insertTutor($pdo, $firstName, $lastName, $gender, 
                        $age, $subject_specialization, $created_by, $user_id);

    if ($query) {
        header("Location: ../index.php");
    } else {
        echo "Insertion Failed";
    }
}

if (isset($_POST['editTutorBtn'])) {
    $updated_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    
    $tutor_id = $_GET['tutor_id'];
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $gender = sanitizeInput($_POST['gender']);
    $age = sanitizeInput($_POST['age']);
    $subject_specialization = sanitizeInput($_POST['subjectSpecialization']);

    $query = updateTutor($pdo, $firstName, $lastName, $gender, $age, $subject_specialization, $tutor_id, $updated_by);

    if ($query) {
        header("Location: ../index.php");
    } else {
        echo "Edit Failed";
    }
}


if(isset($_POST['deleteTutorBtn'])) {
    $deleted_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $query = deleteTutor($pdo, $_GET['tutor_id'], $deleted_by);

    if ($query) {
        header("Location: ../index.php");
    } else {
        echo "Deletion Failed";
    }
}

if(isset($_POST['addPupilBtn'])) {
    $created_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $tutor_id = $_GET['tutor_id'];
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $gender = sanitizeInput($_POST['gender']);
    $age = sanitizeInput($_POST['age']);

    $query = insertPupil($pdo, $firstName, $lastName, $gender, $age, $created_by, $user_id, $tutor_id);

    if ($query) {
        header("Location: ../pupil/newPupil.php?tutor_id=" . $_GET['tutor_id']);
    } else {
        echo "Insertion Failed";
    }
}

if (isset($_POST['editPupilBtn'])) {
    $updated_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $pupil_id = $_GET['pupil_id'];
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);   
    $gender = sanitizeInput($_POST['gender']);        
    $age = sanitizeInput($_POST['age']);              

    $query = updatePupil($pdo, $firstName, $lastName, $gender, $age, $pupil_id, $updated_by);

    if ($query) {
        header("Location: ../pupil/newPupil.php?tutor_id=" . $_GET['tutor_id']);
        exit; 
    } else {
        echo "Update Failed";
    }
}

if (isset($_POST['deletePupilBtn'])) {
    $deleted_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $query = deletePupil($pdo, $_GET['pupil_id'], $deleted_by);

    if ($query) {
        header("Location: ../pupil/newPupil.php?tutor_id=" . $_GET['tutor_id']);
    }
} 

if (isset($_POST['registerUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $firstName = sanitizeInput($_POST['first_name']);
    $lastName = sanitizeInput($_POST['last_name']);
    $password = sanitizeInput($_POST['password']);

    $confirm_password = sanitizeInput($_POST['confirm_password']);

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        
        if ($password == $confirm_password) {

			if (validatePassword($password)) {

				$insertQuery = insertNewUser($pdo, $username, $firstName, $lastName, sha1($password));

				if ($insertQuery) {
					header("Location: ../acc/login.php");
				}
				else {
					header("Location: ../acc/register.php");
				}
			}

			else {
				$_SESSION['message'] = "Password should be more than 8 characters and should contain both uppercase, lowercase, and numbers";
				header("Location: ../acc/register.php");
			}
		}

		else {
			$_SESSION['message'] = "Please check if both passwords are equal!";
			header("Location: ../acc/register.php");
		}
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for registration!";
        header("Location: ../acc/login.php");
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sha1($_POST['password']); 

    if (!empty($username) && !empty($password)) {
        // Call loginUser function to handle login verification
        $loginQuery = loginUser($pdo, $username, $password);

        if ($loginQuery) {
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['message'] = "Username/password invalid";
            header("Location: ../acc/login.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
        header("Location: ../acc/login.php");
        exit;
    }
}



if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']);
    header("Location: ../acc/login.php");
}
?>