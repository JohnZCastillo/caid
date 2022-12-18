<?php

use db\MasteryDb;
use db\TopicDb;

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>DASHBOARD</title>
  <link rel="stylesheet" href="./resources/css/mastery.css">
</head>

<body>
  <style>
    .holder {
      display: flex;
      flex-wrap: wrap;
    }

    .circle-wrapper {
      width: 150px;
      height: 150px;
      background: #d9d7da;
      border-radius: 50%;
      transition: transform .5s;
      box-shadow: 0px 0px 0px 10px rgb(69 69 255), 0px 0px 5px 15px rgb(243 255 81);
    }
  </style>
  <div class="Header">
    <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
  </div>
  <div class="modules">
    <a href="./student" class="button">Back</a><br><br>
  </div>
  <div class="box">
    <div class="form">
      <div class="holder">

        <?php

        try {

          $topics = TopicDb::getAllTopics();

          foreach ($topics as $topic) {
            $title = $topic->getTitle();
            $id = $topic->getId();
            $percent = MasteryDb::getPercent($id);

            echo "<div class='data'>";
            echo "<div><p>$title</p></div>";
            echo "<div>$percent</div>";
            echo "</div>";
          }
        } catch (Exception  $e) {
          echo $e->getMessage();
        }
        ?>

      </div>
    </div>
  </div>
</body>

</html>