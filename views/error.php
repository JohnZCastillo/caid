<?php

use db\ContentDb;
use model\module\Content;
echo " File not found !";

$content = new Content();
$content->setTopics(25);

foreach(ContentDb::getContent(25) as $con){
   echo $con->getName();
   echo "<br>";
}