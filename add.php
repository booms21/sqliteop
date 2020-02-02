<?php
/*

                 copyright szl  2017.4.22

*/
$t_name = $_GET['t_name'];
$status = $_POST['status'];
$name = $_POST['name'];
$age = $_POST['age'];
$address = $_POST['address'];
$salary = $_POST['salary'];
$db = new PDO("sqlite:./test.db3");
if ($db) {
   echo '<div class="alert alert-success" >数据库连接成功！</div>';
} else {
   echo '<div class="alert alert-danger" >数据库连接失败！</div>';
}
$sql2 = "
PRAGMA table_info({$t_name})
";
try {
   $ret = $db->query($sql2);
   /////////////
   $i = 0;

?>

   <!DOCTYPE html>
   <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
 <title> ^-^SQLITE3 OPENER~ </title>
  </head>
    <body  style="background: #F2F2F2;">
      <div class="container">
<blockquote class="lead"><h3>Add INFO 添加信息 </h3></blockquote>
    <form action="" method="post" >
      <div class="panel panel-info">
        <div class="panel-heading">添加信息</div>
        <div class="panel-body">
<?php
    foreach ($ret as $row) {
        // for($i=0; $i<$ret2->columnCount(); $i++) {
        //}
        /////////////////////////
        $array[$ret->columnCount() - 1];
        $array[$i] = $row['name'];
        $i++;
        if ($row['name'] != "ID") {
            echo "<div class='form-group'><strong>".$row['name'] . "</strong>: <textarea class='form-control'  name='" . $row['name'] . "' ></textarea></div>";
        }
    }
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage());
}
if ($status != null) {
    $sql1 = " insert INTO {$t_name}  values(";
    for ($i = 0;$i < count($array);$i++) {
        if ($array[$i] == 'ID' || $array[$i] == 'id') {
            //     $sql1.="null,";
            $sql1.= "?,";
            $vle[$i] = null;
        } else {
            // $sql1.="'".$_POST[$array[$i]]."',";
            $vle[$i] = $_POST[$array[$i]];
            $sql1.= "?,";
        }
    }
    $stmt = $db->prepare(substr($sql1, 0, -1) . ")");
    $stmt->execute($vle);
    //   $ret = $db->exec(substr($sql1,0,-1).")");
    if (!$ret) {
        echo substr($sql1, 0, -1) . ")";
        echo $db->lastErrorMsg();
    } else {
        echo "<script> alert('添加成功',location.href='test.php?t_name={$t_name}'); </script>  ";
    }
    $db->close();
}
?>


         <input type="hidden" value="1" name="status"/>
         <div style="float:right;">
     <button type="submit" class="btn btn-primary">提交</button>
     <button type="reset" class="btn btn-danger">重置</button>
   </div>
    </form>
  </div>
  </div>
</div>
</body></html>
