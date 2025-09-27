<?php
$a="xin chao cac ban va tat ca cac ban than men";
$vitri= strpos($a,"chao");
$chuoi1= str_replace("ban","em",$a);
$chuoi2=substr_replace($chuoi1,"ban",13,3);
echo "chuoi 1 : ".$chuoi1."<br>";
echo "chuoi 2 ".$chuoi2."<br>";
?>