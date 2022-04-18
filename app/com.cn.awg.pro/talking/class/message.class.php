<?php
header("Content-type: text/html;charset=utf-8");
class message{
    public $chat_deposit="chat/";//聊天数据存放
    public $active_set=true;//自动生成目录
    protected $room_initial="欢迎进入“[room]”房间.请自觉遵守法律法规,共建和谐网络环境.";//聊天室默认
    protected $room_pass="123456";//创建密码
    protected $room_del_pass="123456";//删除密码
    function __construct()
    {
        if ($this->active_set){

            if (!is_dir("../".$this->chat_deposit)){
                mkdir("../".$this->chat_deposit,0777);
            }
            if (!is_writable("../".$this->chat_deposit)){
                exit($this->chat_deposit."没有写入权限");
            }
        }

    }


    //遍历所有房间
    protected function allRoom(){
        $arr=array();
        if (is_dir("../".$this->chat_deposit)){
            if ($dh = opendir("../".$this->chat_deposit)){
                while (($file = readdir($dh)) !== false){
                    if ($file=="."||$file=="..")continue;
                    //替换后缀
                    $s=substr(strrchr($file, '.'), 1);
                    $file=strtr($file,array(".".$s=>""));
                    $arr[]=$file;
                }
                closedir($dh);
            }
        }else{
            exit("请检查数据文件");
        }
        return $arr;
    }


    //创建房间
    public function add(){
        //房间id
        $id=@(int)$_POST['id'];
        //房间名称
        $name=@$_POST['title'];

        if ($this->room_pass!=@$_POST['pass'])exit("密码错误");
        if (!$name)exit("请填写房间名称");
        if (strlen((string)$id)<5)exit("房间id长度不能小于5位");
        $allRoom=$this->allRoom();
        if (in_array($id,$allRoom)){
            exit("房间号已存在");
        }

        //房间初始化信息
        $initial=strtr($this->room_initial,array("[room]"=>$name));

        $data=array();
        $data['room']=$name;
        $data["data"][]=array(
            "name"=>"系统消息",
            "data"=>$initial,
            'date'=>date("Y-m-d H:i")
        );
        $data=json_encode($data);


        $roomDir="../".$this->chat_deposit."/".$id.".json";//聊天数据
        if (@file_put_contents($roomDir,$data)){
            //$a="<a href='article.php?id={$id}' target='_blank'>点击进入</a>";
            exit("房间创建成功！<br>房间id：{$id}");
        }

    }

    //房间展示
    public function show($id){
        $id=(int)$id;
        $data=@file_get_contents($this->chat_deposit."/".$id.".json");
        $data=json_decode($data,true);
        return $data;
    }

    //评论
    public function release(){
        $id=(int)$_GET['id'];
        $name=trim(@$_POST['name']);
        $data=trim(@$_POST['value']);
        $name2=str_replace(' ', '',trim(@$_POST['name']));
        if ($name2=="系统消息"||$name2=="台风眼")$name=str_replace(' ', '',trim(@$_POST['name']));

        $allRoom=$this->allRoom();
        if (!in_array($id,$allRoom)){
            exit("房间不存在");
        }

        if (!$name)exit("昵称不能为空");
        if (!$data)exit("消息不能为空");
        if (strlen((string)$name)>15)exit("昵称太长,超出15字了");
        if (strlen((string)$data)>150)exit("消息太长,超出150字了");
        if ($name=="系统消息"||$name=="台风眼")exit("很抱歉,您无法使用特殊昵称");
        $room_data=@file_get_contents("../".$this->chat_deposit."/".$id.".json");
        $room_data=json_decode($room_data,true);

        $room_data['data'][]=array(
            "name"=>$name,
            "data"=>$data,
            "date"=>date("Y-m-d H:i")
        );

        $room_data=json_encode($room_data);
        if (@file_put_contents("../".$this->chat_deposit."/".$id.".json",$room_data)){
            exit("true");
        }else{
            exit("发布失败");
        }
    }


    //房间删除
    public function del(){
        $id=@(int)$_POST['id'];
        if (@$_POST['pass']!=$this->room_del_pass){
            exit("密码错误");
        }

        $allRoom=$this->allRoom();
        if (!in_array($id,$allRoom)){
            exit("房间不存在");
        }


        $dir="../".$this->chat_deposit."/".$id.".json";
        if (@unlink($dir)){
            exit("true");
        }else{
            exit("删除失败");
        }
    }

}
?>