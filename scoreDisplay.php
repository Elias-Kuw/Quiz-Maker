
<?php
require('connection.php');
// session_start();

// Retrieve the data
try {
    $qID = $_GET['quizID'];
    $scores = $db->query("SELECT UserID, MAX(Score) AS MaxScore FROM scores WHERE QuizID = $qID GROUP BY UserID ORDER BY MaxScore DESC LIMIT 10")->fetchAll();    $usernames = array();
    
    $sql = $db->prepare("SELECT Username FROM users WHERE UserID = :usid");
    foreach ($scores as $score) {
        $sql->bindParam(":usid", $score[0]);
        $sql->execute();
        $un = $sql->fetchColumn();
        $usernames[] = $un;
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

// Print the table
function printScoresTable($scores, $usernames) {
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th> Ranking </th>";
    echo "<th> Username </th>";
    echo "<th> Score </th>";
    echo "</tr>";
    for ($i = 0; $i < count($scores); $i++) {
        echo "<tr>";
        echo"<td>" .($i+1). "</td>";
        echo "<td>" . $usernames[$i] . "</td>";
        echo "<td>" . $scores[$i][1] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

printScoresTable($scores, $usernames);

$db = null;
?>
<style>
    table {
  border-collapse: collapse;
  width: 100%;
  max-width: 800px;
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
</style>