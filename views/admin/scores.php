<?php

use db\UserDb;
use db\QuizResult;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scores</title>
</head>

<body>


    <table>

        <?php

        $ids = QuizResult::getQuizIds();

        echo "<thead><tr>";
        foreach ($ids as $quizId) {
            echo "<th>$quizId</th>";
        }
        echo "</tr></thead>";


        foreach (UserDb::getUsers() as $user) {

            $userId = $user->getId();

            // exclue admin
            if ($user->getRole() === "ADMIN") {
                continue;
            }

            echo "<tr>";

            foreach ($ids as $quizId) {


                $stats = QuizResult::getResultByStudent($quizId, $userId);

                if ($stats !== NULL) {

                    $score = (int) $stats['score'];
                    $perfect = (int)$stats['perfect'];

                    $percent = 0;

                    if ($score > 0) {
                        $percent = ($score / $perfect) * 100;
                    }

                    echo "<td>$percent</td>";
                } else {
                    echo "<td>0</td>";
                }
            }

            echo "<tr>";
        }


        ?>
    </table>

</body>

</html>