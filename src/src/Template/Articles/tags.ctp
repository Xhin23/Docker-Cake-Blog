<?php
$this->assign('title','Articles tagged with "'.$tag.'"');
$this->extend('/Articles/index',["articles" => $articles]);
