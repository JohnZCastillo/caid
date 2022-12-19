<?php

use db\QuizResult;

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="./resources/css/topics.css">
</head>

<body>
    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="./student" class="button">Back</a><br><br>
    </div>
    <div class="box">
        <div class="form">
            <div class="chart">
                <ul class="numbers">
                    <li><span>100%</span></li>
                    <li><span>50%</span></li>
                    <li><span>0%</span></li>
                </ul>


                <ul class="bars">
                    <?php

                    $ids = QuizResult::getQuizIds();

                    foreach ($ids as $id) {
                        $stats = QuizResult::getResult($id);

                        if ($stats !== NULL) {

                            $score = (int) $stats['score'];
                            $perfect = (int)$stats['perfect'];

                            $percent = 0;

                            if ($score > 0) {
                                $percent = ($score / $perfect) * 100;
                            }

                            echo "<li>
                                    <div class='bar' style='height:$percent' data-percentage='$percent'></div>
                                </li>";
                        }
                    }

                    ?>
                </ul>
            </div>
        </div>
    </div>


</body>

</html>