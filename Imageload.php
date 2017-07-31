<?php 
//include 'index.php';
require 'connect.inc.php';
require 'core.inc.php';

//echo "Note is made<br><br><br>";
$conn=mysql_connect($mysql_host,$mysql_user,$mysql_pass);
$query="SELECT `note_id`,length(note_text),`note_title`,`note_text`,`deadline`,`priority`,`task_completed`,`note_image_name`,`note_image_path` FROM `bug_notes` WHERE `username`='".getuserfield('username')."' AND `note_id` like '".getuserfield('username')."%' ORDER BY `note_id`;";
$result=mysql_query($query);
if(mysql_num_rows($result)>0){
?>


<html>
<head>
    <meta charset="utf-8">
        <link href="layout.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style>
      .modal-header,.close {
      background-color: #FF7F50;
      color:white;
      text-align: center;
      font-size: 20px;
  }
</style>
 </head>       


<body>
<div class="container-fluid">

<span id="home"> <button type="button" class="btn btn-sm btn-primary pull-right " onclick="location.href='note1.php';">Add Another Notes</button></span><br><br>
<?php
  while($row=mysql_fetch_assoc($result)){
  $note_id=$row['note_id'];
  $length=$row['length(note_text)'];
  $note_text=$row['note_text'];   
  $note_title=$row['note_title'];
  $deadline=$row['deadline'];
  $priority=$row['priority'];
  $note_image_name=$row['note_image_name'];
  $task_completed=$row['task_completed'];
  $note_image_path=$row['note_image_path'];
  ?>

    <div class="row">

        <div class="col-sm-3 col-md-3">
        
            <div class="post">
<?php 
if($priority=="very important"){
    echo '<div class="modal-header" style="background-color:#ff2a00">';
  }
  else if($priority=="important"){
   echo '<div class="modal-header" style="background-color:#ff8c00">'; 
  }
  else if($priority=="normal"){
    echo '<div class="modal-header" style="background-color:#32e025">';
  }
  else if($priority=="least"){
    echo '<div class="modal-header" style="background-color:#2983ff">';
  }
  ?>
            <div class="closeButton" padding="2%">
            <button type="button" id="close" class="close" style="color:black" value="<?php echo $note_id; ?>">&times;</button>
            <input class="note-id1" type="hidden" value="<?php echo $note_id;?>" />
            

            <?php
             
             ?>


            </div>
                <div class="modal-title"><?php echo $note_title;?></div>
            </div>



                <div class="post-img-content">
                    <?php echo '<img src="'.$note_image_path.'" class="img-responsive" />'; ?>
                </div>
                <div class="Image-Name" style="font:bold 20px Segoe Print;text-align:center">
                <?php echo $note_image_name; ?></div>
                   <div class="content">
                        <?php echo  $note_text; ?>
                    </div>

              <?php if($task_completed=="1"){
    echo '<div class="checkbox_hidden" padding="2%"><input type="checkbox" class="checkbox_1" checked="checked"/> Done';
    echo '<input class="note-id" type="hidden" value="'.$note_id.'"/></div>';
  }
  else{
    echo '<div class="checkbox_hidden" style="padding:5%"><input type="checkbox" class="checkbox_1"/> Done';
    echo '<input class="note-id" type="hidden" value="'.$note_id.'"/></div>';
  }

  if(isset($_POST['checked_note_id'])){
    $checked_note_id=$_POST['checked_note_id'];
    $checkbox_query="UPDATE bug_notes SET `task_completed`=1 WHERE `note_id`='$checked_note_id';";
    mysql_query($checkbox_query);
  }
  
  if(isset($_POST['unchecked_note_id'])) {
    $unchecked_note_id=$_POST['unchecked_note_id'];
    $checkbox_query="UPDATE bug_notes SET `task_completed`=0 WHERE `note_id`='$unchecked_note_id';";
    mysql_query($checkbox_query);
  }
  ?>
                    <div class="modal-footer">
                        <a  class="btn btn-info btn-sm pull-right"><?php echo $deadline; ?></a>
                    </div>
                </div>

            </div>
             

  <?php
   /*$priority_red="Vred.png";
  $priority_orange="Iorange.png";
  $priority_yellow="Nyellow.png";
  $priority_green="Lgreen.png";
  $priority_image=$priority_red;
  
 
  echo '<div class="notemade_r">';  
  echo '<div class="heading_title_deadline_r"><div class="deadline_r">'.$deadline.'</div>';
  echo '<div class="title_close"><div class="note_title_r">'.$note_title.'</div><a href="delete_note.php"><img src="close.png" id="close"/></a></div></div>';
  //echo '<div class="u_line_r"><hr></div>';
  //echo '<div class="note_image_name_r">'.$note_image_name.'</div>';
  echo '<p class="text__"><img src="'.$note_image_path.'" id="img__" align="left"/>';
  if($length<41){echo  $note_text.'<br><br><br></p>';}
  else{ echo  $note_text.'</p>';}
  echo  '<div class="foot_priority_taskdone"><div class="checkbOx">';
  if($task_completed=="1"){
    echo '<div class="checkbox_hidden">Done<input type="checkbox" class="checkbox_1" checked="checked"/>';
    echo '<input class="note-id" type="hidden" value="'.$note_id.'"/></div>';
  }
  else{
    echo '<div class="checkbox_hidden">Done<input type="checkbox" class="checkbox_1"/>';
    echo '<input class="note-id" type="hidden" value="'.$note_id.'"/></div>';
  }

  if(isset($_POST['checked_note_id'])){
    $checked_note_id=$_POST['checked_note_id'];
    $checkbox_query="UPDATE bug_notes SET `task_completed`=1 WHERE `note_id`='$checked_note_id';";
    mysql_query($checkbox_query);
  }
  
  if(isset($_POST['unchecked_note_id'])) {
    $unchecked_note_id=$_POST['unchecked_note_id'];
    $checkbox_query="UPDATE bug_notes SET `task_completed`=0 WHERE `note_id`='$unchecked_note_id';";
    mysql_query($checkbox_query);
  }
  
  
  
  echo  '</div><img src="'.$priority_image.'" id="Vred"/></div>';
  /*echo '<div id="priority_r">'.$priority.'</div>';
  echo '<div id="note_image_name_r">'.$note_image_name.'</div>';
  echo '<div id="task_completed_r">'.$task_completed.'</div>';
  //echo '<div id="note_image_path_r">'.$note_image_path.'</div>';
  echo '<div id="note_image_r"><img src="'.$note_image_path.'"/></div>';
  //echo "<br><br><br>";
  
  */
  /*echo "</div>";
  echo "<br><br>";*/
  }//while loop ends here
  
}else {
  //echo "zero results";
}

//header('Location:index.php');
?>

 
   <script src="jquery.1.11.3.js"></script>
    <script>    
    $('.checkbox_1').click(function (argument) {
      var x = $(this).is(':checked');   
      y = $(this).parent().find('.note-id').val();    
      if(x) {
        $.post("Imageload.php",{
          checked_note_id: y
        },
        function(data, status){         
          if(data=='done')
            alert(data);
        });
      }else {
        $.post("Imageload.php",{
          unchecked_note_id: y
        },
        function(data, status){         
          if(data=='done')
            alert(data);
        });
      }     
    });



$('.close').click(function (argument) {
      //var x = $(this).is(':checked');   
      y = $(this).parent().find('.note-id1').val();    
      if(y != '') {
        $.post("delete_note.php",{
          delete_note_id: y
        },
        function(data, status){         
          location.href = 'Imageload.php';
        });
      }

    });

    
    
    </script>


</body>
</html>