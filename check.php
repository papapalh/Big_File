<?php
    // 接收相关数据
    $post = $_POST;

    // 找出分片文件
    $dir = '/var/www/'.$post['md5'];

    // 有断点
    if (file_exists($dir)) {
        // 找出上传成功的所有文件
        $block_info=scandir($dir);

        // 除去无用文件
        foreach ($block_info as $key => $block) {
            if ($block == '.' || $block == '..') unset($block_info[$key]);
        }

        echo json_encode(["code"=>"0" , 'block_info' => $block_info]);
    }
    // 无断点
    else {
        echo json_encode(["code"=>"1"]);
    }