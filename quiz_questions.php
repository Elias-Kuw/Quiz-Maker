<?php
require('connection.php');

session_start();
$quizId = $_GET['quizID'];

$_SESSION['qId'] = $quizId;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Projectstyle.css">
  <title>QuizQuestions</title>

  <style>
    .main {
      margin: 20px 20px 20px 5px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="submit"] {
      display: block;
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    select {
      width: 100%;
      padding: 5px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    textarea {
      width: 100%;
      height: 100px;
      padding: 5px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #3e8e41;
    }

    button:hover {
      background-color: #3e8e41;
    }

    h2 {
      margin-bottom: 20px;
    }

    .error {
      color: red;
      margin-top: 5px;
    }
  </style>

</head>

<body>
  <header>
    <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
    <div class="headert">
    </div>
  </header>


  <main>
    <?php

    // Fetch the number of questions to display
    $quizQuery = $db->prepare("SELECT display_questions FROM quizzes WHERE quizID = :quizId");
    $quizQuery->bindParam(':quizId', $quizId, PDO::PARAM_INT);
    $quizQuery->execute();
    $displayQuestions = $quizQuery->fetchColumn();

    // Function to display random questions of a specific type
    function displayRandomQuestions($db, $table, $quizId, $type, $numQuestions)
    {
      $sql = "SELECT * FROM $table WHERE quizid = :quizId ORDER BY RAND() LIMIT :numQuestions";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':quizId', $quizId, PDO::PARAM_INT);
      $stmt->bindParam(':numQuestions', $numQuestions, PDO::PARAM_INT);
      $stmt->execute();
      $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($questions as $row) {
        echo "<p>Question: {$row['question']}</p>";
        echo "<input type='hidden' name='{$type}_question_ids[]' value='{$row['ID']}' />";
        if ($type === 'mcq') {
          // Display multiple choice options
          echo "<input type='radio' name='mcq_answers[{$row['ID']}]' value='opt1'  /> a) {$row['opt1']}<br>";
          echo "<input type='radio' name='mcq_answers[{$row['ID']}]' value='opt2'  /> b) {$row['opt2']}<br>";
          echo "<input type='radio' name='mcq_answers[{$row['ID']}]' value='opt3'  /> c) {$row['opt3']}<br>";
          echo "<input type='radio' name='mcq_answers[{$row['ID']}]' value='opt4'  /> d) {$row['opt4']}<br>";
        } elseif ($type === 'fill') {
          // Display fill in the blank input field
          echo "<input type='text' name='fill_answers[{$row['ID']}]' /><br>";
        } elseif ($type === 'tf') {
          // Display true/false options
          echo "<input type='radio' name='tf_answers[{$row['ID']}]' value='T'  /> True<br>";
          echo "<input type='radio' name='tf_answers[{$row['ID']}]' value='F'  /> False<br>";
        }
        echo "<hr>";
      }
    }

    // Display quiz form
    echo "<form id='quizForm' action='check_answers.php' method='post'>";

    // Display random questions based on the number to display
    $questionsToDisplay = min($displayQuestions, 3); // Limit the total number of questions to 3

    $questionTypes = ['mcq', 'fill', 'tf'];
    shuffle($questionTypes); // Randomize the order of question types

    $questionTypeCount = count($questionTypes);

    for ($i = 0; $i < $questionsToDisplay; $i++) {
      $questionType = $questionTypes[$i % $questionTypeCount];

      if ($questionType === 'mcq') {
        displayRandomQuestions($db, "questions1", $quizId, "mcq", 1);
      } elseif ($questionType === 'fill') {
        displayRandomQuestions($db, "questions2", $quizId, "fill", 1);
      } elseif ($questionType === 'tf') {
        displayRandomQuestions($db, "questions3", $quizId, "tf", 1);
      }
    }

    // Submit button
    echo "<input type='submit' value='Submit Answers' />";
    echo "</form>";

    $db = null; // Close the PDO connection
    ?>
  </main>

  <?php require("footer.php"); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('quizForm').addEventListener('submit', function(event) {
        var mcqQuestions = document.querySelectorAll('input[name^="mcq_answers"]');
        var fillQuestions = document.querySelectorAll('input[name^="fill_answers"]');
        var tfQuestions = document.querySelectorAll('input[name^="tf_answers"]');

        var unansweredQuestions = [];

        mcqQuestions.forEach(function(question) {
          var questionId = question.getAttribute('name').match(/\[(\d+)\]/)[1];
          if (!document.querySelector('input[name="mcq_answers[' + questionId + ']"]:checked')) {
            unansweredQuestions.push('unanswered');
          }
        });

        fillQuestions.forEach(function(question) {
          var questionId = question.getAttribute('name').match(/\[(\d+)\]/)[1];
          if (question.value.trim() === '') {
            unansweredQuestions.push('unanswered');
          }
        });

        tfQuestions.forEach(function(question) {
          var questionId = question.getAttribute('name').match(/\[(\d+)\]/)[1];
          if (!document.querySelector('input[name="tf_answers[' + questionId + ']"]:checked')) {
            unansweredQuestions.push('unanswered');
          }
        });

        if (unansweredQuestions.length > 0) {
          event.preventDefault();
          alert('Please answer all the questions.');
        }
      });
    });
  </script>
</body>

</html>
