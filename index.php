          <!--
                         code by szl  2017.4.22
          在php环境下地址栏运行此文件（主页）进行使用。
          -->
    <!DOCTYPE html>
    <head>
      <title>SQLite3 在线工具</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


   <style type="text/css">
.jumbotron{
  margin-top:2%;
border-radius:5px;
   padding:2%;
}
   </style>
  <body >

 <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="jumbotron">
      <h1>SQLite3 在线工具</h1>
      <p>请打开sqlite文件（只能选择上传一个sqlite文件，支持类型有：db3、db、sqlite）</p>
      <div class="well">



        <form action="" method="post"
        enctype="multipart/form-data" >
         <div class="form-group">
        <div class="input-group input-group-sm"  >
  <input type="file" class="form-control" style=" padding:3px;" name="file" id="file">
  <span class="input-group-addon" id="basic-addon2">.db3    .db   .sqlite</span>
  </div>
        <div class="btn-group" role="group">


          <button  class="btn btn-primary" type="submit" name="submit" style="margin-top:10%;">打开</button>

        </div>

        </div>
        <div class="panel panel-danger">
          <div class="panel-heading"><span class="glyphicon glyphicon-warning-sign"></span>    注意：</div>
          <div class="panel-body">
           <p style="font-size: 14px; font-weight: bold;">仅支持sqlite格式数据库文件的上传<br>上传的数据库文件不能超过30M  <br>  如要对数据进行操作(CURD)请确保数据表中已创建主键（INTEGER  PRIMARY KEY）<br>数据库文件名不能为中文</p>
          </div>
        </div>
        </form>

    </div>
    </div>
<div class="well">
    <div class="panel panel-info">
      <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>    系统信息：</div>
      <div class="panel-body">
     <?php
  if ($_FILES["file"]["error"] > 0) {
      switch ($_FILES["file"]["error"]) {
          case 1:
              echo "打开失败---Return Code: " . $_FILES["file"]["error"] . " 上传的文件过大<br />";
          break;
          case 2:
              echo "打开失败---Return Code: " . $_FILES["file"]["error"] . " 上传的文件过大<br />";
          break;
          case 3:
              echo "打开失败---Return Code: " . $_FILES["file"]["error"] . " 文件上传中断<br />";
          break;
          case 4:
              echo "打开失败---Return Code: " . $_FILES["file"]["error"] . " 没有文件被上传，请选择文件重新选择文件<br />";
          break;
          case 5:
              echo "打开失败---Return Code: " . $_FILES["file"]["error"] . " 上传文件大小为0.<br />";
          break;
      }
  } else
  //打开成功
  {
      //echo "<p style='color:#008000; '>数据库文件成功</p><br>" ;
      echo "<div class='alert alert-info' role='alert'>Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<p>";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<p></div>";
      if (isset($_FILES["file"]["name"])) {
          $fileSuffix = substr(strrchr($_FILES["file"]["name"], '.'), 1);
          if ((strnatcasecmp($fileSuffix, "DB3") == 0) || (strnatcasecmp($fileSuffix, "DB") == 0) || (strnatcasecmp($fileSuffix, "SQLITE") == 0) || (strnatcasecmp($fileSuffix, "SQLITE3") == 0)) {
              echo "<div class='alert alert-success' role='alert'>正确的文件</div>";
              move_uploaded_file($_FILES["file"]["tmp_name"], "test.db3");
  ?>

  <script>
   var obj=[];
  obj=JSON.parse(localStorage.getItem("record"));
  if(obj==null){

   obj=[];

  }

  obj[obj.length]={"fn":'<?php echo $_FILES["file"]["name"]; ?>',"time":Date()};

     obj = JSON.stringify(obj);

   localStorage.setItem("record", obj);


  </script>

  <?php
          } else {
              echo "<div class='alert alert-danger' role='alert'>请上传正确的文件</div>";
          }
      }
  }
  ?>
  </div>
  </div>



  <?php

$db = new PDO("sqlite:./test.db3"); //注意红字部分的路径格式，这样写会报错：new PDO('myDB.sqlite');
$isk = 0;
$stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
echo "  <div class='panel panel-primary'><div class='panel-heading'><span class='glyphicon glyphicon-duplicate'></span>  " . $_FILES["file"]["name"] . "SQLite文件下的数据表（请选择）：</div>  <div class='panel-body' role='button'  tabindex='0'   data-placement='left' title='点击进去查看！'>";
foreach ($stmt as $row) {
   $isk = 1;
   echo "<br><a href='test.php?t_name={$row[0]}'>" . $row[0] . "</a>";
}
if ($isk == 0) {
   echo "<div class='alert alert-danger' role='alert'>没有数据，数据库的内容为空或服务器上没有找到可用sqlite</div>  ";
} else echo "<div style='float:right; '><a href='test.db3'  tabindex='0'  class='tt' data-placement='top'  role='button' title='在这里可以下载sqlite文件哦！'>下载</a></div></div>  </div>";

?>


<div class="panel panel-default">
  <div class="panel-heading"><span class="glyphicon glyphicon-time"></span>    本机上传历史记录：</div>
  <div class="panel-body">
<ul id="myList" style="height: 150px; overflow:scroll; overflow-x:hidden;margin:0px;"></ul>
<div style='float:right;font-weight: bold;'><a href='javascript:clearHistory();'>清除历史记录</a></div>
</div>
</div>




  </div>
   <div class="col-md-2"></div>


</div>
  <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
  <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>

  var item=JSON.parse(localStorage.getItem("record"));

  for(var i=item.length-1;i>=0;i--){
  var node=document.createElement("LI");
    //document.getElementById("record").appendChild(item[child].fn+"----"+item[child].time);
  var textnode=document.createTextNode("数据库文件:"+item[i].fn+"=======时间:"+item[i].time);
  node.appendChild(textnode);
  document.getElementById("myList").appendChild(node);
  }
   function clearHistory(){



  var list=document.getElementById("myList");
    var r=confirm("确定要清空所有历史记录吗？");
  if (r==true)
    {
   for (var i=0;i<=list.childNodes.length+1;i++){
  list.removeChild(list.childNodes[0]);
  }
   localStorage.removeItem('record');
    }
  else{
  }

  }
     $('.panel-primary>.panel-body').tooltip();
   $('.tt').tooltip("show");
$('.panel-primary>.panel-body').tooltip("show");
  </script>
</body>
</html>
