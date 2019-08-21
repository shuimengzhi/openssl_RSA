<?php
  //echo 2;die;
require("rsa.php");

$private_key_file = __DIR__ . "/cert/private_key.pem";
$public_key_file = __DIR__ . "/cert/public_key.pem";

$rsa = new RSA();

// 没有就生成一对
if (!file_exists($private_key_file) || !file_exists($public_key_file)) {
    $key = $rsa->generate();

    file_put_contents($private_key_file, $key['private_key'], LOCK_EX);
    file_put_contents($public_key_file, $key['public_key'], LOCK_EX);
} else {
    $key = [
        "private_key" => file_get_contents($private_key_file),
        "public_key" => file_get_contents($public_key_file)
    ];
}

//显示数据
//echo "private_key:\n" . $key['private_key'] . "\n\r";
//echo "public_key:\n" . $key['public_key'] . "\n\r";

//要加密的数据
$data = "7654321";
echo '加密的数据：' . $data, "\n-------------------------------\n";

$rsa->init($public_key_file, $private_key_file);


//加密
$encrypt = $rsa->encrypt($data);
echo "公钥加密后的数据: " . $encrypt . "\n";

//解密
$decrypt = $rsa->decrypt($encrypt);
echo "私钥解密后的数据: " . $decrypt, "\n-------------------------------\n";

//签名
//私钥签名
$sign = $rsa->sign($data);
echo "签名的数据: " . $sign . "\n";

//验证
//公钥验证
$verify = $rsa->verify($data, $sign);
echo "验证的数据: " . $verify . "\n", "\n-------------------------------\n";
