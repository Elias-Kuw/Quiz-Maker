<?php
session_start();
require("connection.php");
if(isset($_SESSION['Active'])){
?>

<?php
try {
  require("connection.php");
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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
    <title>CheckAnswers</title>

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
    main {
      margin: 20px 20px 20px 5px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      
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

    .btn {
      text-decoration: none;
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn:hover {
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
        <h2>Welcome, <?php echo isset($_SESSION['Active']) ? $_SESSION['Active'] : ''; ?></h2> 
        <a href="sessionDes.php">Logout</a>
        <a href="firstform.php">Create Quiz</a>
        <a href="editProfile.php">Edit profile</a>
        </div>
    </header>
    <main>
    <?php

    // Retrieve the submitted answers
    $mcqAnswers = $_POST['mcq_answers'] ?? [];
    $fillAnswers = $_POST['fill_answers'] ?? [];
    $tfAnswers = $_POST['tf_answers'] ?? [];

    // Process MCQ answers
    $mcqQuestionIds = $_POST['mcq_question_ids'] ?? [];
    $mcqScore = 0;

    foreach ($mcqQuestionIds as $questionId) {
        $selectedOptionKey = $mcqAnswers[$questionId] ?? '';

        // Retrieve the selected option value for the question from the database
        $query = $db->prepare("SELECT {$selectedOptionKey} FROM questions1 WHERE ID = :questionId");
        $query->bindValue(':questionId', $questionId, PDO::PARAM_INT);
        $query->execute();
        $selectedOptionValue = $query->fetchColumn();

        // Retrieve the correct option key for the question from the database
        $query = $db->prepare("SELECT answer FROM questions1 WHERE ID = :questionId");
        $query->bindValue(':questionId', $questionId, PDO::PARAM_INT);
        $query->execute();
        $correctOptionKey = $query->fetchColumn();

        // Retrieve the correct option value for the question from the database
        $query = $db->prepare("SELECT {$correctOptionKey} FROM questions1 WHERE ID = :questionId");
        $query->bindValue(':questionId', $questionId, PDO::PARAM_INT);
        $query->execute();
        $correctOptionValue = $query->fetchColumn();

        // Compare the selected option value with the correct option value
        if ($selectedOptionValue == $correctOptionValue) {
            $mcqScore++;
        }
    }

    // Process Fill in the Blank answers
    $fillQuestionIds = $_POST['fill_question_ids'] ?? [];
    $fillScore = 0;

    foreach ($fillQuestionIds as $questionId) {
        $submittedAnswer = $fillAnswers[$questionId] ?? '';

        // Retrieve the correct answer for the question from the database
        $query = $db->prepare("SELECT answer FROM questions2 WHERE ID = :questionId");
        $query->bindValue(':questionId', $questionId, PDO::PARAM_INT);
        $query->execute();
        $correctAnswer = $query->fetchColumn();

        // Compare the submitted answer with the correct answer
        if (strcasecmp($submittedAnswer, $correctAnswer) === 0) {
            $fillScore++;
        }
    }

    // Process True/False answers
    $tfQuestionIds = $_POST['tf_question_ids'] ?? [];
    $tfScore = 0;

    foreach ($tfQuestionIds as $questionId) {
        $selectedOption = $tfAnswers[$questionId] ?? '';

        // Retrieve the correct option for the question from the database
        $query = $db->prepare("SELECT answer FROM questions3 WHERE ID = :questionId");
        $query->bindValue(':questionId', $questionId, PDO::PARAM_INT);
        $query->execute();
        $correctOption = $query->fetchColumn();

        // Convert the selected option to uppercase for consistency
        $selectedOption = strtoupper($selectedOption);

        // Compare the selected option with the correct option
        if ($selectedOption === $correctOption) {
            $tfScore++;
        }
    }

    // Calculate the total score
    $totalScore = $mcqScore + $fillScore + $tfScore;

    // Display the results
    echo "<h2>Quiz Results:</h2>";
    echo "<p>Multiple Choice Questions Score: $mcqScore / " . count($mcqQuestionIds) . "</p>";
    echo "<p>Fill in the Blank Questions Score: $fillScore / " . count($fillQuestionIds) . "</p>";
    echo "<p>True/False Questions Score: $tfScore / " . count($tfQuestionIds) . "</p>";
    echo "<p>Total Score: $totalScore / " . (count($mcqQuestionIds) + count($fillQuestionIds) + count($tfQuestionIds)) . "</p>";
    echo "<a Class='btn' href=Home.php>Ok</a>";

    try {
        $db->beginTransaction();
        
        $userN = $_SESSION['Active'];
        $stmt1 = $db->prepare("SELECT UserID FROM users WHERE Username = :username");
        $stmt1->bindParam(":username", $userN);
        $stmt1->execute();
        $userID = $stmt1->fetchColumn();
        
        $quId = $_SESSION['qId'];
        
        $stmt2 = $db->prepare("INSERT INTO scores (QuizID, UserID, Score) VALUES (:quId, :userID, :totalScore)");
        $stmt2->bindParam(":quId", $quId);
        $stmt2->bindParam(":userID", $userID);
        $stmt2->bindParam(":totalScore", $totalScore);
        $stmt2->execute();
        
        $db->commit();
        $db = null;
    } catch (PDOException $e) {
        $db->rollBack();
        die($e->getMessage());
    }
    
    
   

?>
    </main>
    <?php
    require('footer.php');
    ?>
</body>
</html>
<?php
}
?>
