<?php
require("connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Projectstyle.css">
  <title>FirstForm</title>

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
    h2 {
      margin-bottom: 20px;
    }
    .error {
      color: red;
      margin-top: 5px;
    }
  </style>

  <script>
    // Function to validate the form inputs
    function validateForm() {
      // Retrieve the form inputs
      var title = document.getElementById('quiz-title').value;
      var category = document.getElementById('quiz-category').value;
      var description = document.getElementById('quiz-description').value;
      var displayQuestions = document.getElementById('quiz-display-questions').value;
      var age = document.getElementById('quiz-age').value;

      // Regular expressions for validation
      var titleRegex = /^[a-zA-Z0-9\s]+$/;
      var displayQuestionsRegex = /^\d+$/;
      var ageRegex = /^[1-9][0-9]?$|^100$/;

      // Flag to track validation status
      var isValid = true;

      // Validate title
      if (!titleRegex.test(title)) {
        document.getElementById('title-error').innerHTML = 'Please enter a valid title.';
        isValid = false;
      } else {
        document.getElementById('title-error').innerHTML = '';
      }

      // Validate category
      if (category === '') {
        document.getElementById('category-error').innerHTML = 'Please select a category.';
        isValid = false;
      } else {
        document.getElementById('category-error').innerHTML = '';
      }

      // Validate description
      if (description === '') {
        document.getElementById('description-error').innerHTML = 'Please enter a description.';
        isValid = false;
      } else {
        document.getElementById('description-error').innerHTML = '';
      }

      // Validate display questions
      if (!displayQuestionsRegex.test(displayQuestions)) {
        document.getElementById('display-questions-error').innerHTML = 'Please enter a valid number of display questions.';
        isValid = false;
      } else {
        document.getElementById('display-questions-error').innerHTML = '';
      }


      // Validate age
      if (!ageRegex.test(age)) {
        document.getElementById('age-error').innerHTML = 'Please enter a valid age.';
        isValid = false;
      } else {
        document.getElementById('age-error').innerHTML = '';
      }

      // Return the validation status
      return isValid;
    }
  </script>

</head>
<body>
  <header>
    <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
    <div class="headert">
    </div>
  </header>

  <main>
    <form class="main" action="quiz_generator.php" method="post" onsubmit="return validateForm();">
      <h2>Math Quiz Form</h2>
      <label for="quiz-title">Title:</label>
      <input type="text" id="quiz-title" name="quiz-title" placeholder="Quiz Title">
      <span class="error" id="title-error"></span>

      <label for="quiz-category">Category:</label>
      <select id="quiz-category" name="quiz-category">
        <option value="">Select a category</option>
        <option value="+">Addition</option>
        <option value="-">Subtraction</option>
        <option value="*">Multiplication</option>
        <option value="/">Division</option>
      </select>
      <span class="error" id="category-error"></span>

      <label for="quiz-description">Description:</label>
      <textarea id="quiz-description" name="quiz-description" placeholder="Quiz Description"></textarea>
      <span class="error" id="description-error"></span>

      <label for="quiz-display-questions">Number of Display Questions:</label>
      <input type="number" id="quiz-display-questions" name="quiz-display-questions" placeholder="Display Questions">
      <span class="error" id="display-questions-error"></span>

      <label for="quiz-age">Minimum Age:</label>
      <input type="number" id="quiz-age" name="quiz-age" placeholder="Minimum Age">
      <span class="error" id="age-error"></span>

      <label for="quiz-prerequisites">Pre_Requisites:</label>
      <input type="text" id="quiz-prerequisites" name="quiz-prerequisites" placeholder="PreRequisites">

      <button type="submit">Next</button>
    </form>
  </main>

  <?php require("footer.php"); ?>
</body>
</html>
