<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Projectstyle.css">
  <title>SecondForm</title>

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
    input[type="number"] {
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

    button:hover {
      background-color: #3e8e41;
    }

    .button {
      text-decoration: none;
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .button:hover {
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

  <script>
    function updateForm() {
      var questionType = document.getElementById('QuestionType').value;
      var answerOptions = document.getElementById('answerOptions');
      var answerOptions1 = document.getElementById('answerOptions1');
      var answerOptions2 = document.getElementById('answerOptions2');

      if (questionType === 'multiple_choice') {
        answerOptions.style.display = 'block';
        answerOptions1.style.display = 'none';
        answerOptions2.style.display = 'none';
      } else if (questionType === 'fill_in_blank') {
        answerOptions.style.display = 'none';
        answerOptions1.style.display = 'block';
        answerOptions2.style.display = 'none';
      } else if (questionType === 'true_false') {
        answerOptions.style.display = 'none';
        answerOptions1.style.display = 'none';
        answerOptions2.style.display = 'block';
      }
    }

    function validateForm() {
      var question = document.getElementById('Question').value;
      var questionType = document.getElementById('QuestionType').value;

      var isValid = true;

      // Validate question
      if (question.trim() === '') {
        document.getElementById('question-error').innerHTML = 'Please enter a question.';
        isValid = false;
      } else {
        document.getElementById('question-error').innerHTML = '';
      }

      // Validate options based on question type
      if (questionType === 'multiple_choice') {
        var opt1 = document.getElementById('opt1').value;
        var opt2 = document.getElementById('opt2').value;
        var opt3 = document.getElementById('opt3').value;
        var opt4 = document.getElementById('opt4').value;

        if (opt1.trim() === '' || opt2.trim() === '' || opt3.trim() === '' || opt4.trim() === '') {
          document.getElementById('options-error').innerHTML = 'Please enter all options.';
          isValid = false;
        } else {
          document.getElementById('options-error').innerHTML = '';
        }
      } else if (questionType === 'fill_in_blank') {
        var opt1F = document.getElementById('opt1F').value;

        if (opt1F.trim() === '') {
          document.getElementById('options-error').innerHTML = 'Please enter an answer.';
          isValid = false;
        } else {
          document.getElementById('options-error').innerHTML = '';
        }
      }

      return isValid;
    }
  </script>

</head>

<body>
<header>
    <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
    <div class="headert"></div>
  </header>
  <main>
    <?php
      $quizID = $_GET['quizID'];
    ?>
     <form class="main" action="generate_quiz.php?quizID=<?php echo $quizID; ?>" method="post" onsubmit="return validateForm();">
      <h2>Quiz Questions</h2>
      <label for="Question">Question:</label>
      <input type="text" id="Question" name="Question">
      <span class="error" id="question-error"></span>

      <label for="QuestionType">Question Type:</label>
      <select name="QuestionType" id="QuestionType" onchange="updateForm();">
        <option value="multiple_choice">Multiple Choice</option>
        <option value="fill_in_blank">Fill in the Blank</option>
        <option value="true_false">True/False</option>
      </select>

      <div id="answerOptions">
        <label for="opt1">Option 1:</label>
        <input type="text" id="opt1" name="opt1" placeholder="Option 1">

        <label for="opt2">Option 2:</label>
        <input type="text" id="opt2" name="opt2" placeholder="Option 2">

        <label for="opt3">Option 3:</label>
        <input type="text" id="opt3" name="opt3" placeholder="Option 3">

        <label for="opt4">Option 4:</label>
        <input type="text" id="opt4" name="opt4" placeholder="Option 4">

        <label for="Answer">Answer:</label>
        <input type="text" id="Answer" name="Answer">
      </div>

      <div id="answerOptions1" style="display: none;">
        <label for="opt1F">Answer:</label>
        <input type="text" id="opt1F" name="opt1F" placeholder="Answer">

        <label for="AnswerF">Answer Confirmation:</label>
        <input type="text" id="AnswerF" name="AnswerF" placeholder="Confirm Answer">
      </div>

      <div id="answerOptions2" style="display: none;">
        <label for="opt1T">Option 1:</label>
        <select id="opt1T" name="opt1T">
          <option value="T">T</option>
          <option value="F">F</option>
        </select>

        <label for="opt2T">Option 2:</label>
        <select id="opt2T" name="opt2T">
          <option value="T">T</option>
          <option value="F">F</option>
        </select>

        <label for="AnswerT">Answer:</label>
        <select name="AnswerT" id="AnswerT">
          <option value="T">T</option>
          <option value="F">F</option>
        </select>
      </div>
 
      <button type="submit" name="submit">Add Question</button>
      <a class="button" href="home.php">Done</a>
    </form>
   
  </main>
  <?php require("footer.php"); ?>
</body>

</html>
