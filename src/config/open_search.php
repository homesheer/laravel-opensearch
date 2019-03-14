<?php

return [
    /*
    |--------------------------------------------------------------------------
    | url查询字符串名
    |--------------------------------------------------------------------------
    |
    | 通过下面配置的查询字符串名指定要获取的字段，如指定字符串名为fields，
    | 要获取user上的id，name和值对象address的province, city字段，url格式如下：
    | http://localhots/user?fields={id,name,address{province,city}}
    */

    // 指定您的accessKeyId，在 https://ak-console.aliyun.com/#/accesskey 中可以创建
    'access_key_id' => '',

    // 指定您的secret
    'secret'        => '',

    // 指定您要访问的区域的endPoint，在控制台应用详情页中有指定
    'end_point'     => '',
    'app_name'      => '',
    'suggest_name'  => '',
    'options'       => [
        'debug' => false,    // 是否开启debug模式（默认不开启)
        'gzip' => false,    // 是否开启gzip压缩（默认开启）
        'timeout' => 10,    // 超时时间，seconds（默认10秒）
        'connectTimeout' => 1,  // 连接超时时间，seconds(默认1秒)
    ],

];
