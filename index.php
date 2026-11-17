<?php
include "db.php";
include "header.php";
include "auth.php";

//student_grading adalah database (bapak kepada table)
//results & user adalah table (anak kepada database student_grading)
//id, student_name, matric_no. adalah column (anak kepada table results & user dan cucu kepada database student_grading)
$search = $_GET['search'] ?? "";

$like = "%$search%";

$sql = $conn->prepare("SELECT * FROM result WHERE student_name LIKE? OR matric_no LIKE? OR subject_name LIKE ? OR subject_code LIKE?");

$sql->bind_param("ssss", $like, $like, $like, $like);

$sql->execute();

$result = $sql->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Assessment</title>
</head>

<body>

    <h2>Student Records</h2>

    <a href="add.php">+ Add Result</a>
    <br><br>

    <form method="GET">
    <input type="text" name="search" style="width: 430px;"
        placeholder="Search by student name, matric number, subject name, test1, test2, final, total, grade"
        value="<?php echo $search ?>">
    <button type="submit">Search</button>
    <a href="index.php">Show all</a>
    </form>
    <br><br>

    <table border="1">
        <tr>
            <th>No.</th>
            <th>Student Name</th>
            <th>Matric No.</th>
            <th>Subject</th>
            <th>Test 1 (20%)</th>
            <th>Test 2 (30%)</th>
            <th>Final (50%)</th>
            <th>Total</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>

        <?php

        $no = 1;
        //if else, while, for switch case
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $row['student_name'] . "</td>";
            echo "<td>" . $row['matric_no'] . "</td>";
            echo "<td>" . $row['subject_name'] . " (" . $row['subject_code'] . ")" . "</td>";
            echo "<td>" . $row['test1'] . "</td>";
            echo "<td>" . $row['test2'] . "</td>";
            echo "<td>" . $row['final'] . "</td>";
            echo "<td>" . $row['total'] . "</td>";
            echo "<td>" . $row['grade'] . "</td>";
            echo "<td>
                 <button><a href='edit.php?id=" . $row['id'] . "'>Edit</a></button>
                 <form method='POST' action='delete.php' onsubmit='return confirm(\"Delete This Record?\")'>
                 <input type='hidden' name='delete' value='" . $row['id'] . "'>
                 <input type='submit' value='Delete'>
                 </form>
            </td>";
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>

<?php
include "footer.php";
?>