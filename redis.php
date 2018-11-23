<?php
$redis = new Redis();  
$redis->connect('10.200.10.1', 6379);
$cache_name = 'redisList';

$id = $_GET['user_id'];
$redis_time = intval($redis->lindex($id,-1));

if($redis->llen($id) >= 5){

    if( time() - $redis_time <= 3600 ){
        echo "用户ID：".$id."，超过最大请求数";
    }else{
        //删除第一行并新增一个时间
        $redis->lpop($id);
        $redis->rpush($id, time());
        echo "请求成功2";
    }

}else{
    $redis->rpush($id, time());
    echo "请求成功1";
}