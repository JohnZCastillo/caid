<?php

use db\FileDb;
use model\module\Content;

// echo " File not found !";

$content = new Content();
$content->setTopics(25);
$content->setId(74);
$content->setType(3);
$content->appendData(FileDb::getFile($content));
var_dump($content->getData());
