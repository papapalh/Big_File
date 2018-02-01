<?php
    // 接收相关数据
    $post = $_POST;
    $file = $_FILES;
    $status = $post['status'];

    // 建立临时目录存放文件-以MD5为唯一标识
    $dir = "/var/www/" . $post['md5value'];

    // 断点上传
    if ($status == '0') {
        // 获取分片文件内容
        $block_info=scandir($dir);
        // 除去无用文件
        foreach ($block_info as $key => $block) {
            if ($block == '.' || $block == '..') unset($block_info[$key]);
        }
    }
    // 直接上传
    elseif($status == '1') {
        if (!file_exists($dir)) {
            mkdir ($dir,0777,true);
        }

        // 移入缓存文件保存
        move_uploaded_file($file["file"]["tmp_name"], $dir.'/'.$post["chunk"]);
    }
