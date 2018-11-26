<html>
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head/>
<body>
  <?php
    $name = $_POST["username"];
    $pwd = $_POST["pwd"];
    $fp = fopen("./data.txt", "a");
    $str = "user:".$name."&password:".$pwd."\r\n";
    fwrite($fp,$str);
    fclose($fp);
    echo "<h1>welcome back!".$name."!</h1>";
  ?>
</body>
</html>

