<?php
    // 接收相关数据
    $post = $_POST;

    // 找出分片文件
    $dir = __DIR__ . '/upload/'.$post['md5'];

    // 获取分片文件内容
    $block_info = scandir($dir);

    // 除去无用文件
    foreach ($block_info as $key => $block) {
        if ($block == '.' || $block == '..') unset($block_info[$key]);
    }

    // 数组按照正常规则排序
    natsort($block_info);

    // 定义保存文件
    $save_file = __DIR__ . '/upload/' . $post['fileName'];

    // 没有？建立
    if (!file_exists($save_file)) fopen($post['fileName'], "w");

    // 开始写入
    $out = @fopen($save_file, "wb");

    // 增加文件锁
    if (flock($out, LOCK_EX)) {
        foreach ($block_info as $b) {
            // 读取文件
            if (!$in = @fopen($dir.'/'.$b, "rb")) {
                break;
            }

            // 写入文件
            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($in);
            @unlink($dir.'/'.$b);
        }
        flock($out, LOCK_UN);
    }
    @fclose($out);
    @rmdir($dir);

    echo json_encode(["code"=>"0"]);//随便返回个值，实际中根据需要返回