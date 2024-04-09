<?php
session_start();
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Retrieve form data
        $question = $_POST['Question'];
        $questionType = $_POST['QuestionType'];
        $quizID = $_GET['quizID'];

        // Regular expression patterns for validation
        $textPattern = "/^[a-zA-Z0-9\s.,+=\/!?-]*$/";
        $answerPattern = "/^[a-zA-Z0-9\s]*$/";
        $booleanPattern = "/^(T|F)$/";

        // Validate the form data based on question type
        $isValid = true;
        $errorMessage = "";

        if (empty($question)) {
            $isValid = false;
            $errorMessage .= "Question is required. ";
        } elseif (!preg_match($textPattern, $question)) {
            $isValid = false;
            $errorMessage .= "Invalid question format. ";
        }

        if ($questionType === 'multiple_choice') {
            $questionopt1 = $_POST['opt1'];
            $questionopt2 = $_POST['opt2'];
            $questionopt3 = $_POST['opt3'];
            $questionopt4 = $_POST['opt4'];
            $answer = $_POST['Answer'];

            if (empty($questionopt1) || empty($questionopt2) || empty($questionopt3) || empty($questionopt4) || empty($answer)) {
                $isValid = false;
                $errorMessage .= "All options and answer are required. ";
            } elseif (!preg_match($textPattern, $questionopt1) || !preg_match($textPattern, $questionopt2) || !preg_match($textPattern, $questionopt3) || !preg_match($textPattern, $questionopt4) || !preg_match($answerPattern, $answer)) {
                $isValid = false;
                $errorMessage .= "Invalid option or answer format. ";
            }
        } elseif ($questionType === 'fill_in_blank') {
            $questionopt1F = $_POST['opt1F'];
            $answerF = $_POST['AnswerF'];

            if (empty($questionopt1F) || empty($answerF)) {
                $isValid = false;
                $errorMessage .= "answer and comfirmation answer are required. ";
            } elseif (!preg_match($textPattern, $questionopt1F) || !preg_match($answerPattern, $answerF)) {
                $isValid = false;
                $errorMessage .= "Invalid option or answer format. ";
            }
        } elseif ($questionType === 'true_false') {
            $answerT = $_POST['AnswerT'];
            $questionopt1T = $_POST['opt1T'];
            $questionopt2T = $_POST['opt2T'];

            if (empty($answerT) || empty($questionopt1T) || empty($questionopt2T)) {
                $isValid = false;
                $errorMessage .= "All options and answer are required. ";
            } elseif (!preg_match($booleanPattern, $answerT) || !preg_match($booleanPattern, $questionopt1T) || !preg_match($booleanPattern, $questionopt2T)) {
                $isValid = false;
                $errorMessage .= "Invalid option or answer format. ";
            }
        }

        if (!$isValid) {
            // Display error message and terminate the script
            die("Error: " . $errorMessage);
        }

        // Prepare and execute the database insert statement based on question type
        if ($questionType === 'multiple_choice') {
            $sqlMultipleChoice = "INSERT INTO questions1 (quizid, question, opt1, opt2, opt3, opt4, answer) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtMultipleChoice = $db->prepare($sqlMultipleChoice);
            $stmtMultipleChoice->execute([$quizID, $question, $questionopt1, $questionopt2, $questionopt3, $questionopt4, $answer]);
        } elseif ($questionType === 'fill_in_blank') {
            $sqlFillInBlank = "INSERT INTO questions2 (quizid, question, opt1, answer) VALUES (?, ?, ?, ?)";
            $stmtFillInBlank = $db->prepare($sqlFillInBlank);
            $stmtFillInBlank->execute([$quizID, $question, $questionopt1F, $answerF]);
        } elseif ($questionType === 'true_false') {
            $sqlTrueFalse = "INSERT INTO questions3 (quizid, question, op1, op2, answer) VALUES (?, ?, ?, ?, ?)";
            $stmtTrueFalse = $db->prepare($sqlTrueFalse);
            $stmtTrueFalse->execute([$quizID, $question, $questionopt1T, $questionopt2T, $answerT]);
        }

        // Close the statements and connection
        $stmtMultipleChoice = null;
        $stmtFillInBlank = null;
        $stmtTrueFalse = null;
        $db = null;

        // Display success message and redirect the user to the next step
        echo "<script>alert('Question has been added successfully!'); window.location.href='secondform.php?quizID=$quizID';</script>";
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
