<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        $userType = $_GET['type'];

        switch ($userType) {
            case 'user':
                $deleteQuery = mysqli_query($bd, "DELETE FROM users WHERE id='$userId'");
                $redirectPage = 'manage-users.php';
                break;
            case 'judge':
                $deleteQuery = mysqli_query($bd, "DELETE FROM judge WHERE id='$userId'");
                $redirectPage = 'manage-judges.php';
                break;
            case 'president':
                $deleteQuery = mysqli_query($bd, "DELETE FROM president WHERE id='$userId'");
                $redirectPage = 'manage-president.php';
                break;
            case 'minister':
                $deleteQuery = mysqli_query($bd, "DELETE FROM minister WHERE id='$userId'");
                $redirectPage = 'manage-ministers.php';
                break;
            default:
                $_SESSION['delmsg'] = "Invalid user type";
                header('location:manage-users.php?del=error');
                exit();
        }

        if ($deleteQuery) {
            $_SESSION['delmsg'] = "User deleted successfully";
            header("location: $redirectPage?del=success");
        } else {
            $_SESSION['delmsg'] = "Error deleting user";
            header('location:manage-users.php?del=error');
        }
    }
}
?>
