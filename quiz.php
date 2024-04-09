<?php
session_start();
require("connection.php");

// Check if the quiz ID is provided in the URL
if (isset($_GET['quizID'])) {
    $quizID = $_GET['quizID'];

    // Retrieve the quiz information
    $quizQuery = "SELECT QuizID, Title, Description, Category, Prerequisites, display_questions, Age FROM quizzes WHERE QuizID = :quizID";
    $quizStatement = $db->prepare($quizQuery);
    $quizStatement->bindParam(':quizID', $quizID);
    $quizStatement->execute();
    $quizRow = $quizStatement->fetch(PDO::FETCH_ASSOC);

    if ($quizRow) {
        $title = $quizRow['Title'];
        $description = $quizRow['Description'];
        $category = $quizRow['Category'];
        $age = $quizRow['Age'];
        $Display = $quizRow['display_questions'];
        $pre = $quizRow['Prerequisites'];
    } else {
        // Quiz not found
        echo "Quiz not found.";
        exit;
    }
} else {
    // Quiz ID not provided
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Projectstyle.css">
    <title>Quiz - <?php echo $title; ?></title>

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

    main {
      margin: 20px 20px 20px 5px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      display: flex;
    }

    .QuizInfo{
      flex :2;
    }
    .ScoreInfo{
      flex:1;
    }

    .QuizInfo h2 {
      margin-bottom: 20px;
    }

    .QuizInfo p {
      margin-bottom: 20px;
    }

    .QuizInfo span {
      font-weight: bold;
    }

    .StartButton {
      display: inline-block;
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
    }

    .StartButton:hover {
      background-color: #3e8e41;
    }
  </style>

    <script>
    function fetchData() {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "scoreDisplay.php?quizID=<?php echo $quizID; ?>", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById("scoreContainer").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    // Fetch the score initially when the page loads
    window.onload = function() {
      fetchData();
    };
    </script>
</head>
<body>
    <header>
        <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
        <div class="headert">
          <h2>Welcome, <?php echo $_SESSION['Active']; ?></h2>
          <a href="sessionDes.php">Logout</a>
          <a href="firstform.php">Create Quiz</a>
        </div>
    </header>

    <main>
        <div class="QuizInfo">
            <h2><span>Title: </span><?php echo $title; ?></h2>
            <p><span>Description: </span><?php echo $description; ?></p>
            <p><span>Category: </span> <?php echo $category; ?></p>
            <p><span>Minimum Age: </span> <?php echo $age; ?></p>
            <p><span>Pre-requisites: </span> <?php echo $pre; ?></p>
            <p><span>Number of Questions:</span> <?php echo $Display; ?></p>
            <a href="quiz_questions.php?quizID=<?php echo $quizID; ?>" class="StartButton">Start Quiz</a>
        </div>
        
        <div class="ScoreInfo">
            <div id="scoreContainer"></div>
        </div>
    </main>

    <?php require('footer.php'); ?>
</body>
</html>
