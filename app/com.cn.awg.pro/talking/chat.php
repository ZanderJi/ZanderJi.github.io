<?php
include_once "class/api.php";
$data=@$c->show(@$_GET["id"]);
if(!is_array($data)){
    $data=array();
}

$title=@$data["room"];

$data=@array_reverse($data['data']);
?>

<html>
<header>
    <title><?php echo $title;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="public/layui/css/layui.css">
    <link rel="stylesheet" href="public/css/css.css">
</header>
<body>
<div class="mian">
    <div class="header">
        <h3><?php echo $title;?></h3>
    </div>


        <div class="form">
            <textarea name="value" required lay-verify="required" placeholder="请输入" class="layui-textarea" id="value"></textarea>
            <input type="text" name="name" required lay-verify="required" placeholder="昵称" autocomplete="off" class="layui-input" style="margin-top: 5px;margin-bottom: 0px">
            <button class="layui-btn layui-btn-fluid add">发布</button>
        </div>
    </div>

<div class="list">

<?php
if (!$data){
    $data=array();
}
foreach (@$data as $v) {
    if (!$v)continue;
?>
    <div class="layui-card">
        <div class="layui-card-header">
            <?php echo @$v['name'];?>说：
            <p><?php echo @$v['date'];?></p>
        </div>
        <div class="layui-card-body">
            <?php echo @$v['data'];?>
        </div>
    </div>
<?php
}
?>

</div>

<script type="text/javascript" src="public/js/jquery.min.js"></script>
<script type="text/javascript" src="public/layer/layer.js"></script>

<?php
if (!$title){
    die("
    
    <script>
    $(document).ready(function() {
    
        
        layer.open({
                        content: '房间不存在',
                        btn: ['确认'],
                        yes: function(index, layero) {
                            window.location.href='make.php';
                        },
                        
                        
                    });
        
        
        });
    </script>
    ");
}
?>

<script>
    $(document).ready(function() {


       $(".add").click(function () {
           var name=$("input[name='name']").val();
           var value=$("#value").val();



           $.ajax({
               type: 'post',
               url: "class/api.php?type=release&id=<?php echo $_GET['id'];?>",
               data: "name="+name+"&value="+value,
               success: function (data) {

                   if (data=="true"){
                       layer.msg("发布成功");
                       window.location="chat.php?id=<?php echo $_GET['id'];?>";
                   }else{
                       layer.msg(data);
                   }
               }
           })
       });




    });


</script>

</body>
</html>