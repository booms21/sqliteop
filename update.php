<?php
$id = $_GET['id'];
$t_name = $_GET["t_name"];
$id_name = $_GET["id_name"];
$name = $_POST['name'];
$age = $_POST['age'];
$address = $_POST['address'];
$salary = $_POST['salary'];
$status = $_POST['status'];
//接收本页面的post
$db = new PDO("sqlite:./test.db3");
if ($db) {
    echo '<div class="alert alert-success" >数据库连接成功！</div>';
} else {
    echo '<div class="alert alert-danger" >数据库连接失败！</div>';
}
$sql = <<<EOF
select * from {$t_name} where {$id_name}={$id}
EOF;
$ret = $db->query($sql);
$array[$ret->columnCount() ];
foreach ($ret as $row);
?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<title> ^-^SQLITE3 OPENER~ </title>
</head>
<body style="background: #F2F2F2;">
      <div class="container">
<blockquote class="lead"><H3>Update INFO 修改信息</h3></blockquote>

    <form action="" method="post" >
      <div class="panel panel-info">
        <div class="panel-heading">添加信息</div>
        <div class="panel-body">
<?php
try {
    $sql2 = "
PRAGMA table_info({$t_name})
";
    $ret = $db->query($sql2);
    $i = 0;
    foreach ($ret as $row2) {
        echo "<div class='form-group'><strong>".$row2['name'] . "</strong>: <textarea  name='" . $row2['name'] . "'  class='form-control'>" . $row[$row2['name']] . "</textarea></div>";
        $array[$i] = $row2['name'];
        $i++;
    }
}
catch(PDOException $e) {
    die("Error!: " . $e->getMessage());
}
if ($status != "") {
    $sql1 = "update  {$t_name} set ";
    for ($i = 0;$i < count($array);$i++) {
        $sql1.= $array[$i] . "=?,";
        //   $sql1.=$array[$i]."='".$_POST[$array[$i]]."',";
        $vle[$i] = $_POST[$array[$i]];
    }
    // $ret = $db->exec(substr($sql1,0,-1)." where {$id_name}={$id}");
    $stmt = $db->prepare(substr($sql1, 0, -1) . " where {$id_name}={$id}");
    $stmt->execute($vle);
    if (!$ret) {
        echo "error--" . substr($sql1, 0, -1);
        echo $db->lastErrorMsg();
    } else {
        echo "<script> alert('修改成功',location.href='test.php?t_name={$t_name}'); </script>  ";
    }
}
?>

         <input type="hidden" value="1" name="status"/>
           <div style="float:right;">
                  <button type="submit"  class="btn btn-primary">提交</button>
                  <button type="reset" class="btn btn-danger">重置</button>
  </div>
    </form>

  </div>
  </div>
</div>
</body>
 </html>
