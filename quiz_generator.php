<?php
require("connection.php");
session_start();
if (isset($_SESSION['Active'])) {
    try {
        require("connection.php");

        // Retrieve form data
        $quizTitle = $_POST['quiz-title'];
        $quizCategory = $_POST['quiz-category'];
        $quizDescription = $_POST['quiz-description'];
        $quizDisplayQuestions = $_POST['quiz-display-questions'];
        $age = $_POST['quiz-age'];

        // Regular expression patterns
        $titleRegex = '/^[a-zA-Z0-9\s]+$/';
        $descriptionRegex = '/^[a-zA-Z0-9\s.,!?]+$/';
        $numericRegex = '/^\d+$/';

        // Validate inputs using regular expressions
        if (!preg_match($titleRegex, $quizTitle)) {
            die("Error: Invalid quiz title. Only alphanumeric characters and spaces are allowed.");
        }
        if (!preg_match($descriptionRegex, $quizDescription)) {
            die("Error: Invalid quiz description. Only alphanumeric characters, spaces, commas, periods, exclamation marks, and question marks are allowed.");
        }
        if (!preg_match($numericRegex, $quizDisplayQuestions) || $quizDisplayQuestions < 1) {
            die("Error: Invalid number of questions to display. Please enter a positive integer value.");
        }
        if (!preg_match($numericRegex, $age) || $age < 1) {
            die("Error: Invalid age. Please enter a positive integer value.");
        }

        $userName = $_SESSION['Active'];

        // Check if the user exists
        $sqlUser = "SELECT UserID FROM users WHERE Username = ?";
        $stmtUser = $db->prepare($sqlUser);
        $stmtUser->execute([$userName]);
        $user = $stmtUser->fetch();

        if (!$user) {
            // User does not exist, display an error or handle the case as needed
            echo "User does not exist.";
        } else {
            $userID = $user['UserID'];

            // Prepare and execute the database insert statement
            $sqlQuiz = "INSERT INTO quizzes (UserID, Title, Category, Description, Display_Questions, Age) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtQuiz = $db->prepare($sqlQuiz);
            $stmtQuiz->execute([$userID, $quizTitle, $quizCategory, $quizDescription, $quizDisplayQuestions, $age]);

            $quizID = $db->lastInsertId();
            // Close the statement and connection
            $stmtQuiz = null;
            $stmtUser = null;
            $db = null;

            // Redirect the user to the next step or display a success message
            header("Location: secondform.php?quizID=$quizID");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>