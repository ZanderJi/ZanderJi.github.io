<html>
<header>
    <title>腕上微聊</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="public/layui/css/layui.css">
    <link rel="stylesheet" href="public/css/css.css">
</header>
<script type="text/javascript" src="public/js/jquery.min.js"></script>
<script type="text/javascript" src="public/layui/layui.js"></script>
<body>
<div class="mian">
    <div class="header">
        <h3>注册房间</h3>
    </div>
    <div class="form" style="margin-top: 10px;padding: 10px;">
        <input type="text" maxlength="15" name="title" required lay-verify="required" placeholder="请输入房间名称 [最多15字]" autocomplete="off" class="layui-input">
        <input input type="text"  maxlength="10" oninput="value=value.replace(/[^\d]/g,'')" name="id" required lay-verify="required" placeholder="请输入房间ID [5-10位]" autocomplete="off" class="layui-input">
        <button class="layui-btn layui-btn-fluid add">生成</button>
    </div>
</div>
<div class="info" style="padding: 10px;">
    <div class="layui-collapse" >
        <div class="layui-colla-item">
            <h2 class="layui-colla-title" style="background: #FFFFFF;border-radius: 5px;">关于</h2>
            <div class="layui-colla-content">腕上微聊<br>授权 @台风眼 使用<br>原开发者：浮沉<br>有任何问题请联系QQ498978473(台风眼)</div>
        </div>
    </div>
</div>
<script>
    layui.use('element', function(){
        var element = layui.element;
    });
</script>
<script type="text/javascript" src="public/layer/layer.js"></script>
<script>
    $(document).ready(function() {
        $(".add").click(function () {
            var title=$("input[name='title']").val();
            var pass=123456
            var id=$("input[name='id']").val();
            $.ajax({
                type: 'post',
                url: "class/api.php?type=make",
                data: "title="+title+"&id="+id+"&pass="+pass,
                success: function (data) {
                    layer.alert(data);
                }
            })
        });
        $(".del").click(function () {
            var mid=$("input[name='id2']").val();
            var pass=$("input[name='password2']").val();
            $.ajax({
                type: 'post',
                url: "class/api.php?type=del",
                data: "id="+mid+"&pass="+pass,
                success: function (data) {
                    if (data=="true"){
                        layer.msg("删除成功");
                    }else{
                        layer.msg(data);
                    }
                }
            })
        });
    });
    loadq(true);
</script>
</body>
</html>