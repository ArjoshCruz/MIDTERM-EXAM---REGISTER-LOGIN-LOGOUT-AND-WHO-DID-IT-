<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// TUTOR


function insertTutor ($pdo, $firstName, $lastName, $gender, $age, $subjectSpecialization, $created_by, $user_id) {
        $sql = "INSERT INTO tutor_record (first_name, last_name, gender, age, subject_specialization, created_by, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$firstName, $lastName, $gender, $age, $subjectSpecialization, $created_by, $user_id]);

        if ($executeQuery) {
            $attribute_id = $pdo->lastInsertId();
            insertAuditLog($pdo, $created_by, 'Insert', $attribute_id, 'Inserted in Tutor Table');
            return true;
    }
}

function getAllTutors ($pdo) {
    $sql = "SELECT * FROM tutor_record";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getTutorByID ($pdo, $tutor_id) {
    $sql = "SELECT * FROM tutor_record
            WHERE tutor_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$tutor_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function updateTutor($pdo, $first_name, $last_name, $gender, $age, $subjectSpecialization, $tutorID,  $updated_by ) {
    $sql = "UPDATE tutor_record
                SET first_name = ?,
                    last_name = ?,
                    gender = ?,
                    age = ?,
                    subject_specialization = ?,
                    updated_by = ?
                WHERE tutor_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $isUpdated = $stmt->execute([$first_name, $last_name, $gender, $age, $subjectSpecialization, $updated_by, $tutorID ]);

    if ($isUpdated) {
        insertAuditLog($pdo, $updated_by, 'Update', $tutorID, 'Updated in Tutor Table');
        return true;
    } else {
        return false;
    }
}


function deleteTutor($pdo, $tutor_id, $deleted_by){
    $sql = "DELETE FROM tutor_record
            WHERE tutor_id = ?";
    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([$tutor_id]);

    if ($executeQuery){
        
        insertAuditLog($pdo, $deleted_by, 'Delete', $tutor_id, 'Deleted in Tutor Table');
        return true;
    }
}

// PUPIL
function getPupilsByTutor($pdo, $tutor_id) {
    $sql = "SELECT
                pupil_record.pupil_id AS pupil_id,
                pupil_record.first_name AS pupil_first_name,
                pupil_record.last_name AS pupil_last_name,
                pupil_record.gender AS pupil_gender,
                pupil_record.age AS pupil_age,
                pupil_record.date_added AS pupil_date_added,
                pupil_record.created_by AS pupil_created_by,
                pupil_record.updated_by AS pupil_updated_by,
                pupil_record.date_updated AS pupil_date_updated
            FROM pupil_record
            JOIN tutor_record ON 
                pupil_record.tutor_id = tutor_record.tutor_id
            WHERE pupil_record.tutor_id = ?
            GROUP BY pupil_first_name;
        ";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$tutor_id]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function insertPupil ($pdo, $first_name, $last_name, $gender, $age, $created_by, $user_id, $tutor_id) {
    $sql = "INSERT INTO pupil_record (first_name, last_name, gender, age, created_by, user_id, tutor_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $gender, $age, $created_by, $user_id, $tutor_id]);
    if ($executeQuery) {
        $attribute_id = $pdo->lastInsertId();
        insertAuditLog($pdo, $created_by, 'Insert', $attribute_id, 'Inserted in Pupil Table');
        return true;
    }
}

function getPupilById($pdo, $pupil_id) {
    $sql = "SELECT
                pupil_record.pupil_id AS pupil_id,
                pupil_record.first_name AS pupil_first_name,
                pupil_record.last_name AS pupil_last_name,
                pupil_record.gender AS pupil_gender,
                pupil_record.age AS pupil_age,
                pupil_record.date_added AS pupil_date_added
            FROM pupil_record
            JOIN tutor_record ON 
                pupil_record.tutor_id = tutor_record.tutor_id
            WHERE pupil_record.pupil_id = ?
            GROUP BY pupil_first_name;
            ";

    $stmt = $pdo->prepare($sql);
    $executeQuery= $stmt->execute([$pupil_id]);
    if ($executeQuery) {
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    } else {
        echo "Error executing query";
        return null;
    }
}

function updatePupil($pdo, $first_name, $last_name, $gender, $age, $pupil_id, $updated_by) {
    $sql = "UPDATE pupil_record
            SET first_name = ?,
                last_name = ?,
                gender = ?,
                age = ?,
                updated_by = ?
            WHERE pupil_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $gender, $age, $updated_by, $pupil_id]);

    if ($executeQuery) {
        insertAuditLog($pdo, $updated_by, 'Update', $pupil_id, 'Updated in Pupil Table');
        return true;
    }
}

function deletePupil($pdo, $pupil_id, $deleted_by){
    $sql = "DELETE FROM pupil_record WHERE pupil_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$pupil_id]);
    if ($executeQuery){
        insertAuditLog($pdo, $deleted_by, 'Delete', $pupil_id, 'Deleted in Tutor Table');
        return true;
    }
}

// User Acc
function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
    $checkUserSql = "SELECT * FROM user_acc
                    WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {
        $sql = "INSERT INTO user_acc (username, first_name, last_name, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $first_name, $last_name, $password]);

        if ($executeQuery) {
            $_SESSION['message'] = "User Successfully Inserted";
            return true;
        } else {
            $_SESSION['message'] = "An error occurred from the query"; 
        }
    } else {
        $_SESSION['message'] = "User already exists"; 
    }
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM user_acc WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username]);

    if ($executeQuery) {
        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['password'];

        if ($password == $passwordFromDB) {
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login is successful";
            return true;
        }
    }
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_acc";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $user_id) {
    $sql = "SELECT * FROM user_acc
            WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id]);
    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Audit Log
function insertAuditLog($pdo, $username, $action_made, $attribute_id, $details)
{
  $sql = "INSERT INTO audit_log (username, action_made, attribute_id, details) VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username, $action_made, $attribute_id, $details]);
}

function getAllAuditLog($pdo)
{
  $sql = "SELECT * FROM audit_log";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute();

  if ($executeQuery) {
    return $stmt->fetchAll();
  }

}

?>