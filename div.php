<?php
session_start();
require("connection.php");
if (isset($_SESSION['Active'])) {
?>

<?php
try {

} catch (PDOException $e) {
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
    <title>Home</title>

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
</head>

<body>
<header>
        <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
        <div class="headert">
        <h2>Welcome, <?php echo isset($_SESSION['Active']) ? $_SESSION['Active'] : ''; ?></h2> 
        <a href="firstform.php">Create Quiz</a>
        <a href="profile.php">Profile</a>
        <a href="sessionDes.php">Logout</a>
        </div>
    </header>


    <nav>
        <a href="addition.php">Addition( + )</a>
        <a href="sub.php">Subtraction( - )</a>
        <a href="mul.php">Multiplication( * )</a>
        <a href="div.php">Division( / )</a>

    </nav>
    <main>
        <?php
        // Fetch quizzes from the database
        $query = "SELECT QuizID, Title, Description, display_questions, Age FROM quizzes";
    $result = $db->query($query);

        // Check if any quizzes are returned
        if ($result->rowCount() > 0) {
            // Iterate over each quiz
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $quizID = $row['QuizID'];
                $title = $row['Title'];
                $description = $row['Description'];
                $Age = $row['Age'];
                $Display = $row['display_questions'];

                // Fetch questions from all the tables based on the quizID
                $questionsQuery = "SELECT * FROM quizzes WHERE category = '/' AND quizid = " . $quizID . "; " .
                    "SELECT question FROM questions1 WHERE quizid = " . $quizID . " UNION ALL " .
                    "SELECT question FROM questions2 WHERE quizid = " . $quizID . " UNION ALL " .
                    "SELECT question FROM questions3 WHERE quizid = " . $quizID;

                // Execute the query and fetch the result
                $questionsStmt = $db->query($questionsQuery);
                $questionsResult = $questionsStmt->fetchAll(PDO::FETCH_ASSOC);

                // Close the previous result set
                $questionsStmt->closeCursor();

                $questionCount = count($questionsResult);

                // Check if the quiz has any questions
                if ($questionCount > 0) {
        ?>
                    <!-- Display the quiz card -->
                    <div class="Cards">
                    <div class="QCard">
                    <img src="image\operations.jpg" alt="quiz image">
                      <hr/>
                      <h4><?php echo $title; ?></h4>
                      <p><span>Description:</span><?php echo Substr($description,0,30); ?></p>
                      <p>Minimum Age: <?php echo $Age; ?></p>
                      <p>Number of questions: <?php echo $Display; ?></p>
                      <a href="quiz.php?quizID=<?php echo $quizID; ?>">Enter</a>
                  </div>
                    </div>
        <?php
                }
            }
        } else {
            // No quizzes found
            echo "No quizzes available.";
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
    