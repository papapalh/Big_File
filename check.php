<?php
    // 接收相关数据
    $post = $_POST;

    // 通过MD5唯一标识找到缓存文件
    $file_path = __DIR__ . '/upload/' .$post['md5'];

    // 有断点
    if (file_exists($file_path)) {

        // 遍历成功的文件
        $block_info = scandir($file_path);

        // 除去无用文件
        foreach ($block_info as $key => $block) {
            if ($block == '.' || $block == '..') unset($block_info[$key]);
        }

        echo json_encode(['block_info' => $block_info]);
    }
    // 无断点
    else {
        echo json_encode([]);
    }