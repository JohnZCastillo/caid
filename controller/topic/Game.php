<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_FILES['files']['name'] as $i => $name) {


        if (strlen($_FILES['files']['name'][$i]) > 1) {

            // var_dump();

            // echo $_FILES['files']['tmp_name'][$i], "<br>";

            // echo $_FILES['tmp_name'], "<br>";

            // echo is_dir($_FILES['files']['tmp_name'][$i]), "<br>";

            // mkdir($_FILES['files']['full_path'][$i]);

            $folder = '/assets/game/game2/' . $_FILES['files']['full_path'][$i];

            if (!is_dir($folder)) mkdir($folder);

            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], '/assets/game/game2/' . $_FILES['files']['full_path'][$i])) {
                echo $name . "<br>";
            }
        }
    }
}
