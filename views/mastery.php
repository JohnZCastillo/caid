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

<body onload="load()">
  <style>
    .holder {
      background-color: white;
      background-image: none;
      height: 100%;

      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
    }

    .border {
      height: 200px;
      width: 200px;
      border-radius: 50%;
      border: 10px solid rgb(46, 151, 255);
      box-shadow: 0 0 10px 0.5em rgba(255, 247, 86, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .main {
      background-color: rgb(8, 8, 116);
      border-radius: 50%;
      height: 90%;
      width: 90%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .main label {
      font-size: 2rem;
      font-weight: bold;
      font-family: "poppins";
      color: white;
    }

    .progress {
      width: max-content;
      text-align: center;
      padding: 10px;
    }

    .progress-title {
      display: inline-block;
      padding: 10px;
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

            //format decimal when percent is not whole number eg 33.3333
            if (str_contains($percent, ".")) {
              $percent = number_format($percent, 2);
            }

            echo "<div class='progress'> 
               <span class='progress-title'>$title</span>
                <div class='border'>
                    <div class='main'>
                    <label class='value'>$percent</label>
                    </div>
                </div>
            </div>";
          }
        } catch (Exception  $e) {
          echo $e->getMessage();
        }
        ?>


      </div>
    </div>
  </div>
  <script>
    function load() {

      let value = document.querySelector(".value");
      let border = document.querySelector(".border");

      value.textContent = value.textContent + "%";

      border.style.background = `conic-gradient(
        rgba(255, 247, 86, 0.5) ${parseInt(value.textContent) * 3.6}deg,
        grey  ${parseInt(value.textContent) * 3.6}deg
        )`;
    }
  </script>
</body>

</html>