<?php
//定义画布
$width=300;
$height=50;
$image=imagecreatetruecolor($width,$height);
//随机颜色方法
function getRandColor($image){
    return imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
}
//填充画布颜色为白色
$white=imagecolorallocate($image,255,255,255);
imagefilledrectangle($image,0,0,400,50,$white);
//创建出验证码库：0-9 a-z A-Z
$string=join('',array_merge(range(0,9),range('a','z'),range('A','Z')));
$length=strlen($string)-1;
//得出4位随机验证码
for($i=0;$i<4;$i++){
    $randColor=getRandColor($image);
    $size=mt_rand(20,28);
    $angle=mt_rand(-15,15);
    $x=20+60*$i;  $y=30;
    $fontFile='D:\PHPSTUDY\liuyan\fonts\arial.ttf';
    $start=mt_rand(0,$length);
    $text=substr($string,$start,1);

    imagettftext($image,$size,$angle,$x,$y,$randColor,$fontFile,$text);}
//添加干扰元素
//50个随机像素点
for($i=1;$i<=50;$i++){
    imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),getRandColor($image));
}
//绘制线段作于干扰元素
for($i=1;$i<=3;$i++){
    imageline($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),getRandColor($image));
}
//表现在画布上
header('content-type:image/png');
imagepng($image);
imagedestroy($image);
