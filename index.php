<?php

// 接收相关数据
$post = $_POST;
$file = $_FILES;

// 建立临时目录存放文件-以MD5为唯一标识
$dir = __DIR__ . '/upload/' . $post['md5value'];

if (!file_exists($dir)) mkdir ($dir,0777,true);

// 移入缓存文件保存
move_uploaded_file($file["file"]["tmp_name"], $dir.'/'.$post["chunk"]);
