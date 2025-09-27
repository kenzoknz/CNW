<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test chương trình</title>
</head>
<body>
    Chao cac you!!!
    <?php
        echo "Hello World<br>";
        $a = "Xin chao";
        $b = " cac ban";
        $a.= " tat ca";
        echo $a.$b . "<br>";
        // foreach ($array as $value) câu lệnh;
        // foreach ($array as $key => $value) câu lệnh;
        $arr = array("PHP", "HTML", "CSS", "JS");
        foreach ($arr as $value) {
            echo "$value<br>";
        }
        $a = array (
            'a' => '1'
            , 'b' => '2'
            , 'c' => '3'
        );
        $count = count($a);
        $i = 0;
        foreach ($a as $key => $value) {
            echo "$key = $value";
            if (++$i < $count) {
            echo ", ";
            }
        }
    ?>
</body>
</html>