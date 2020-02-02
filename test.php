  <!doctype html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
  <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="css/load.css"  media="all">
    <script src="js/load-min.js" charset="utf-8"></script>
  <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
 <title> ^-^SQLITE3 OPENER~ </title>
  <style type="text/css">
ul{
      padding: 0px;

}
li{

      width:100px;
      float:left;
      line-height:29px;
      text-align:center;
      border:1px solid #000;
      box-sizing:border-box;
      white-space:nowrap;
      text-overflow:ellipsis;
      overflow:hidden;

}
.msg{
      width:100%;
      text-align:center;
      border:none;
}
#dialog-confirm{
      display:none;
      font-size:8px;

}
.left-btn{
  padding: 3%;
}
 </style>

  </head>

 <body style="margin: 1%; background: #F2F2F2;" >
<script type="text/javascript">

$.mask_fullscreen();
</script>
<div id="dialog-confirm" >
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
</div>

<div  >
  <div class="well col-md-3">
<div class="row">
  <div class="col-md-12">
<div class="panel panel-info">
  <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>    系统信息：</div>
  <div class="panel-body">
<?php
/*

                  copyright szl  2017.4.22

*/
$id = $_GET["id"];
$id_name = $_GET["id_name"];
$t_name = $_GET["t_name"];
$keyword = $_GET["keyword"];
$id_PRE;
$db = new PDO("sqlite:./test.db3"); //注意红字部分的路径格式，这样写会报错：new PDO('myDB.sqlite');
if ($db) {
    echo '<div class="alert alert-success" role="alert">
  <a href="#" class="alert-link">连接成功</a>
</div>';
    echo '<div class="alert alert-info" role="alert">
当前数据表:<strong>'.$t_name.'</strong>
</div>';
} else {
    echo '连接失败<br>';
}

if ($id != "") {
    $sql1 = <<<EOF
 delete from {$t_name} where {$id_name}={$id}
EOF;
    $ret = $db->exec($sql1);
    if (!$ret) {
        echo $sql1;
        echo $db->lastErrorMsg();
    } else {
        echo "<script> alert('删除成功'); </script>  ";
    }
}
$pkey = $db->query("select sql from sqlite_master where name='{$t_name}'");
foreach ($pkey as $row) {
    $sqll = $row['sql'];
}

if (preg_match('/.\n*(\w+).\s*INTEGER\s+PRIMARY\s+KEY|(?:PRIMARY\s+KEY\s*\s*).?\s*.?(\w+)/i', $sqll, $match)) { //正则匹配sql建表语句中的主键名
    $match[1] == "" ? $id_PRE = $match[2] : $id_PRE = $match[1];
    echo "<div class='alert alert-info' role='alert'>主键(PRIMARY KEY)：<strong>". $id_PRE."</strong>
</div>";
} else {
    echo '<div class="alert alert-danger" role="alert">
  检测不到该数据表的<strong>主键（INTEGER  PRIMARY KEY）</strong>,请设置主键，否则无法进行操作.如果已经设置主键,请检查该表的建表语句是否规范:'.$sqll.'
</div>';
}
$stmt = $db->query("select * from {$t_name}");
?>


</div>
</div>
</div>
<div class="col-md-9">
</div>
</div>



<div class="row">

<div class="container-fluid">
              <div class="input-group">
                    <input type="text"  id="keyword" class="form-control" placeholder="全局模糊搜索" value="<?php echo $keyword ?>">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" onclick="location.href='test.php?t_name=<?php echo $t_name ?>&keyword='+document.getElementById('keyword').value;">搜索</button>
                    </span>
                  </div><!-- /input-group -->
                    </div>
                    <div class="left-btn">
                    <div class="col-md-5">
                     <a class="btn btn-info btn-sm" href="add.php?t_name=<?php echo $t_name ?>"><span class='glyphicon glyphicon-plus'></span> Add(添加)</a><br>
                    </div>
<div class="col-md-5">
                                     <a class="btn btn-default btn-sm" href="index.php" ><span class='glyphicon glyphicon-home'></span> 返回首页</a>
  </div>
    </div>
      </div>
  </div>
  <div class="col-md-8 well">
<div class="panel panel-info ">
    <div class="panel-heading"><?php echo  $t_name; ?></div>
  <div class="panel-body">

<div class="container ">
     <ul  style="width:<?php echo($stmt->columnCount() + 1) * 100 + $stmt->columnCount() + 3; //40?>px;">
                <?php
$isk = 0;
$sqls = " where ";
for ($i = 0;$i < $stmt->columnCount();$i++) {
    $sqls.= $stmt->getColumnMeta($i) ['name'] . " like '%" . $keyword . "%' or ";
}
$sqls = substr($sqls, 0, -3);
try {
    if ($stmt->columnCount() == 0) {
        echo "<script>alert('没有数据!')</script><div class='alert alert-success' role='alert'>
      <a href='#' class='alert-link'> 没有数据</a>
    </div>";
    } else {
        $sql2 = "
PRAGMA table_info({$t_name})
";
    }
    $ret = $db->query($sql2);
    $i = 0;
    foreach ($ret as $row2) {
        echo "<li  style='background-color:#EFEFFF;'>" . $row2['name'] . "</li>"; //php5.4适使用，之前的版本需拆成两句
        $i++;
    }
    echo "  <li name='option' style='background-color:#EFEFFF;'>操作</li>";
} catch (PDOException $e) {
    die("Error!: -----" . $e->getMessage());
}
$stmt = $db->query("select * from {$t_name} {$sqls}");
$j = 1;
if (!$stmt) {
    echo "<script>alert('数据表为空!')</script><li class='msg'><p class='text-danger' > 数据表为空</p></li>";
} else {
    foreach ($stmt as $row) {
        for ($i = 0;$i < $stmt->columnCount();$i++) {
            echo "<li >" . strip_tags($row[$stmt->getColumnMeta($i) ['name']]). "</li>"; //php5.4适使用，之前的版本需拆成两句
            if ($i == $stmt->columnCount() - 1) {
                if ($id_PRE != "") {
                    echo "
                <li name='option' style='background-color:#ddd;'>
                <div class='btn-group btn-group-xs' role='group' aria-label='...'>
                  <a class='btn btn-default' href='update.php?id={$row[$stmt->getColumnMeta($id_idx) ['name']]}&t_name={$t_name}&id_name={$id_PRE}'><span class='glyphicon glyphicon-edit'></span>修改</a>
                  <a class='btn btn-danger' href='test.php?id={$row[$stmt->getColumnMeta($id_idx) ['name']]}&t_name={$t_name}&id_name={$id_PRE}'><span class='glyphicon glyphicon-remove'></span>删除</a>

                </div></li>";
                } else {
                    echo "<li name='option' class='text-danger' >无主键</li>";
                }
                $j++;
            }
        }
        /*
        ECHO "<li >".$row['ID']."</li>";
        ECHO "<li >".$row['NAME']."</li>";
        ECHO "<li >".$row['AGE']."</li>";
        ECHO "<li >".$row['ADDRESS']."</li>";
        ECHO "<li >".$row['SALARY']."</li>
        <li ><a href='update.php?id={$row['ID']}'>update</a>|<a href='test.php?id={$row['ID']}'>delete</a></li>";
        */
    }
}
echo "<li class='msg' name='option'>没有啦~</li>"
?>

         </ul>
         </div>
          </div>
  </div>
</div>
         </div>

 </body>

   <script>

    $("li[name!='option']").click(function(){

$("#dialog-confirm").text($(this).text());
    $( "#dialog-confirm" ).dialog({
      resizable: false,

      modal: true,

        open: function (event, ui) {
              //  $(".ui-dialog-titlebar-close").text('');
              $(".ui-button-text").remove();
          //    $(".ui-dialog-titlebar").hide();
           //   $(".ui-dialog-titlebar-close").show();

             $(".ui-dialog-title").text("");
             $(".ui-dialog").width("50%");
             $(".ui-dialog").css("position","fixed");
             $(".ui-dialog").css("left","26%");
             $(".ui-dialog").css("top","30%");
              $(".ui-dialog-titlebar").removeClass("ui-widget-header");
            },
    });
});
 window.onload=function(){
 $.mask_close_all();
}
  </script>
  </html>
