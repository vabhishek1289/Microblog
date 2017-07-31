<?php
session_start();
    if (isset($_SESSION['session_user_id'])) {
      if (isset($_POST['data'])&&isset($_POST['name'])&&isset($_POST['type'])&&isset($_POST['size'])&&isset($_POST['user_id_for'])) {
      $data = $_POST['data'];
      $fileName = $_POST['name'];
      $type = $_POST['type'];
      $size = $_POST['size'];
      $_POST['user_id'] = trim(base64_decode($_POST['user_id_for']));
      $uid = $_POST['user_id'];
      $len =  strlen('data:'.$type.';base64,');
      $data = substr($data,$len,strlen($data));
      $data = base64_decode($data);


      $dir = 'files';
      $today = getdate();
      if(is_dir($dir)) {
        $dir = $dir.'/'.$today['year'];
        if(!is_dir($dir)) {
          mkdir($dir);
        }
        $dir = $dir.'/'.$today['mon'];
        if(!is_dir($dir)) {
          mkdir($dir);
        }
        $dir = $dir.'/'.$today['mday'];
        if(!is_dir($dir)) {
          mkdir($dir);
        }
        $path_main = $dir.'/'.time().'_'.$fileName;
        $h = fopen($path_main,'w');
        fwrite($h,$data);
        fclose($h);
        $disp = '';
        if(substr($type,0,5) == 'image') {
          $disp = '<img width="100" src="'.$dir.'/'.time().'_'.$fileName.'"/>';
          $type_m = 'image';
        }
        else if($type == 'application/pdf') {
          $disp = '<img width="100" src="https://cdn3.iconfinder.com/data/icons/lexter-flat-colorfull-file-formats/56/pdf-128.png" />';
          $type_m = 'pdf';
        }


        $from_user = $_SESSION['session_user_id'];
        $for_user =trim($_POST['user_id']);
        require 'connection.inc.php';
        echo $msg = mysqli_real_escape_string($con,$path_main);
        if(!empty($msg)&&!empty($for_user)&&!empty($from_user)) {
          $query = "insert into messages values ('$from_user','$for_user','$msg',now(),'$type_m',0)";
          if($con->query($query)) {
          ?><div class="sent" >
              <a href="<?php echo $path_main;?>"><span><?php echo $disp;?><i><?php echo date('h:i A',time()+(60*60*3+30*60));?></i></span></a>
            </div><?php
          }
        }
      }
    }
}
