<?php

session_start();
require("connection.php");
if(isset($_SESSION['Active'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Projectstyle.css">
    <title>Profile</title>

    <style>
        
        table {
    border-collapse: collapse;
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
    }

    th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    }

    th {
    background-color: #f2f2f2;
    font-weight: bold;
    }

    tr:nth-child(even) {
    background-color: #f2f2f2;
    }

    tr:hover {
    background-color: #ddd;
    }

    td:first-child {
    font-weight: bold;
    }

    td:last-child {
    text-align: right;
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
      font-style: Serif;
    }

    .error {
      color: red;
      margin-top: 5px;
    }

    
.profileMain{
  display: flex;
  padding-left:30px;
  border: 0.063rem solid #ccc;
  border-radius: 0.313rem;
  margin: 20px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.Bdiv{
  flex: 1;
}
.editProB{
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  background-color:cadetblue;
  color: #FFFFFF;
  border-radius: 5px;
  border: none;
  cursor: pointer;
}
.editProB:hover {
  background-color:darkcyan;
}

.Tdiv{
  flex: 2;
}


  </style>
</head>
<body>
    <header>
        <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
        <div class="headert">
        <h2>Welcome, <?php echo isset($_SESSION['Active']) ? $_SESSION['Active'] : ''; ?></h2> 
        <a href="firstform.php">Create Quiz</a>
        <a href="Profile.php">Profile</a>
        <a href="sessionDes.php">Logout</a>
        </div>
    </header>

    <nav>
        <a href="addition.php">Addition( + )</a>
        <a href="sub.php">Subtraction( - )</a>
        <a href="mul.php">Multiplication( * )</a>
        <a href="div.php">Division( / )</a>
       
    </nav>
    <main class="profileMain">
        <div class="Bdiv">
        <h3>Username : <?php echo $_SESSION['Active']; ?></h3>
        <?php
            try {
                $usrN = $_SESSION['Active'];
                $sql1= ("SELECT Email FROM users WHERE Username = :UN");
                $stat= $db->prepare($sql1);
                $stat->bindParam(':UN', $usrN);
                $stat->execute();
                $result = $stat->fetch(PDO::FETCH_ASSOC);
                $UEmail = $result['Email'];
                $db = null;
            } 
            catch (PDOException $e) {
                die($e->getMessage());
            }
        ?>
        <h3>Email : <?php echo $UEmail ?> </h3>
        <a href="editProfile.php" class="editProB">Edit profile</a>
        </div>
        <div calss="Tdiv">
        <?php
        // session_start();

        // Retrieve the data
        try {
            require('connection.php');
            $userN = $_SESSION['Active'];
            $uID = $db->query("SELECT UserID FROM users WHERE Username = '$usrN'");
            $userID= $uID->fetch(PDO::FETCH_ASSOC)['UserID'];
            $rec = $db->prepare("SELECT QuizID, Score FROM scores WHERE UserID = :usid");
            $rec->bindParam(':usid', $userID, PDO::PARAM_INT);
            $rec->execute();
        
            // Fetch the results and print the table
            $scores = $rec->fetchAll(PDO::FETCH_ASSOC);
            echo "<table border='1' calss='HTable'>";
            echo "<tr>";
            echo "<th> Index </th>";
            echo "<th> QuizNo. </th>";
            echo "<th> Score </th>";
            echo "</tr>";
            for ($i = 0; $i < count($scores); $i++) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . $scores[$i]['QuizID'] . "</td>";
                echo "<td>" . $scores[$i]['Score'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        $db = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
        ?>
</div>
    </main>
    <?php
    require('footer.php');
    ?>
</body>
</html>

<?php
}
?>