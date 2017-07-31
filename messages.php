<?php
require 'connection.inc.php';
require 'functions.inc.php';
ob_start();
session_start();
if(!Helper::loggedin()) {
  header("Location: sign_in_up.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/message_main.css" media="screen" title="no title" charset="utf-8">
    <style media="screen">
    .send-message-part .input-field .forget-pass {
      background: #f77;
      margin: 10px;
      float: right;
      color: white;
      position: absolute;
      top: -70px;
      opacity: 0.5;
    }
    .send-message-part .input-field .forget-pass:hover {
      opacity: 1;
    }
    .form-box-forget {
      width: 100%;
      height: 200px;
    }
    .form-box-forget input[type=file] {
      margin-top: 20px;
      width: 100%;
      height: 45px;
      font-size: 1.3em;
      border: 0px;
      border-bottom: 2px solid #0ba;
    }
    .form-box-forget input[type=submit] {
      margin-top: 20px;
      width: 100px;
      height: 40px;
      font-size: 1.3em;
      border: 0px;
      background: #0ba;
      color: white;
    }
    </style>
    <title>Messages</title>
  </head>
  <body>
    <div id="cover"></div>
    <div class="message-menu">
      <div class="user-contact col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <span class=" glyphicon glyphicon-credit-card"></span>
      </div>
      <div class="user-chats active col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <span class="glyphicon glyphicon-comment"></span>
      </div>
      <div class="user-setting col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <span class="glyphicon glyphicon-cog"></span>
      </div>
    </div>
    <div class="main-body">
      <div class="user-contact-div">
        <?php // NOTE: content added here as list of users!! ?>
      </div>
      <div class="user-chats-div">
        <div class="user-chat-list">
          <ul>
            <li class="user-chat-open"><img src="no_pic.php?q=<?php echo base64_encode('daffy@gmail.com');?>" alt="" /> <input type="hidden" name="userId" value="<?php echo base64_encode('programmingjust@gmail.com')?>" /><?php echo 'Howdy bro'; ?></li>
          </ul>
        </div>
        <div class="user-person-chat">
          <div class="close-chat">
            <span class="glyphicon glyphicon-remove"></span>
          </div>
          <div class="menu-user-name-close">
            <div class="user-name">
            </div>
          </div>
          <div class="message-content">
            <input type="hidden" name="msgCount" value="1">
          </div>
          <div class="padding-bottom">
          </div>
          <div class="send-message-part">
            <div class="input-field">
              <textarea name="message" placeholder="message" ></textarea>
              <button type="button" name="sendMsg"><span class="glyphicon glyphicon-send"></span></button>
              <button type="button" class="forget-pass btn" data-toggle="modal" data-target=".bs-example-modal-sm"><span class="glyphicon glyphicon-duplicate"></span></button>
            </div>
          </div>
        </div>
      </div>
      <div class="user-setting-div">

      </div>
    </div>


    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Pleas select file</h4>
            <div class="form-box-forget">
                <input type="file" name="file" placeholder="Enter your Email.." required="true" />

                <div class="cds">
                    <div class="progress" STYLE="width: 100%; height: 10px; border-radius: 0px;">
                      <div id="pbar" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                      </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>



    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/messages_main.js" charset="utf-8"></script>
    <script type="text/javascript">
    $(window).load(function () {
      $('#cover').fadeOut();
    });
    $(document).ready(function () {
      var a = $('.user-person-chat').find('span');
      a.each(function(){
        var x = $(this).text().length;
        //alert(x);
        if( ((x*7)+15)< 280) {
            $(this).css('width',((x*7)+15)+'px');
         }else {
          $(this).css('width','280px');
        }
    });

    $.post("last_user_message.php",
    {
        for_user_id: '<?php echo base64_encode($_SESSION['session_user_id'])?>'
    },
    function(data, status){
      $('.user-chat-list').html(data);
    });

    setInterval(function () {
      $.post("last_user_message.php",
      {
          for_user_id: '<?php echo base64_encode($_SESSION['session_user_id'])?>'
      },
      function(data, status){
        $('.user-chat-list').html(data);
      });
    }, 10000);


    var closeChat = 1;
    $('body').on('click','.close-chat',function () {
      if(1 == 1) {
        $(this).parent().animate({width: '0%', opacity: '0'},250,'swing');
        $(this).parent().hide();
        userId = '';
      }
    });

    $('body').on('click','.user-chats',function () {
      $('.user-chats').toggleClass('active');
      $('.user-contact').toggleClass('active');
      $('.user-contact-div').animate({width: '30%', opacity: '0'}, 250,function () {
        $('.user-chats-div').show();
      });
      openContact = 0;
    });

    var openContact = 0;
    $('body').on('click','.user-contact',function () {
      if(openContact == 0) {
        $.post("get_binded_user.php",
        {
            for_user_id: '<?php echo base64_encode($_SESSION['session_user_id'])?>'
        },
        function(data, status){
          $('.user-contact').toggleClass('active');
          $('.user-chats').toggleClass('active');
          $('.user-contact-div').html(data);
        });

        $('.user-contact-div').animate({width: '100%', opacity: '1'});
        $('.user-chats-div').hide();
        openContact = 1;
        return 0;
      }
      else if(openContact == 1) {
        $('.user-contact-div').animate({width: '30%', opacity: '0'}, 250,function () {
          $('.user-chats-div').show();
        });
        openContact = 0;
        return 0;
      }
    });
    var userId='';
    $('body').on('click','.user-chat-open',function () {
      var dxs = $(this).text();
      hd = $(this).find('input[name=userId]').attr('for');
      if(hd && hd.length > 0)
      {
        dxs = hd;
      }
      userId = $(this).find('input[name=userId]').val();
      var xs = this;
      $.post("get_user_msg.php",
      {
          user_id: userId
      },
      function(data, status){
        $('.user-contact-div').animate({width: '30%', opacity: '0'}, 250,function () {
          $('.user-chats-div').show();
          $('.user-person-chat').scrollTop($('.user-person-chat')[0].scrollHeight);
        });
        openContact = 0;
        $('.menu-user-name-close').find('.user-name').text(dxs);
        $('.menu-user-name-close').show();
        $('.user-person-chat').show();
        $('.user-person-chat').animate({width: '100%', opacity: '1'},250,'swing');
        $('.user-person-chat').find('.message-content').html(data);
      });
    });



    function appendMessage() {
      if(userId.length > 10) {
        $.post("get_user_msg.php",
        {
            user_id_append: userId
        },
        function(data, status){
          //alert(data);
          if(data.length > 0)
          {
            $('.user-person-chat').find('.message-content').append(data);
            $('.user-person-chat').scrollTop($('.user-person-chat')[0].scrollHeight);
          }
        });
        //$('.user-person-chat').scrollTop($('.user-person-chat')[0].scrollHeight);
      }
    }

    setInterval(function () {
      appendMessage();
    }, 1000);

    $('.user-person-chat').scroll(function () {
      var s = $('.user-person-chat').scrollTop();
      // TODO: here code for append more message...
    });

    $('body').on('click','button[name=sendMsg]',function () {
      var dx =this;
      if(userId.length > 10) {
        var msgContent = $(this).parent().find('textarea[name=message]').val();
        if(msgContent.length > 0) {
          $(this).find('span').addClass('glyphicon-hourglass');
          $.post("send_user_message.php",{
            user_id: userId,
            message: msgContent
          },function (data,status) {
              $(dx).find('span').removeClass('glyphicon-hourglass');
              $(dx).parent().find('textarea[name=message]').val('');
              $('.user-person-chat').find('.message-content').append(data);
              $('.user-person-chat').scrollTop($('.user-person-chat')[0].scrollHeight);
          });
        }
      }
      return 0;
    });


    // Variable to store your files
    var files;
    // Add events
    $('input[name=file]').on('change', prepareUpload);
    // Grab the files and set them to our variable
    function prepareUpload(event)
    {
      file = event.target.files[0];
      var filsize = file.size;
      var typeimag = (file.type);
      if((typeimag.substring(0,5)!="image")&&(typeimag != "application/pdf")) {
        return;
      }
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = uploadImage;
      //reader.onloadstart = ...
      reader.onprogress = function (event) {
        var a = $(".cds").html();
        var t = event.total;
        $("#pbar").css("width",""+parseInt((event.loaded/t)*100)+"%");
      }
      reader.onabort = function (event) {
        alert("Abort");
      }
      reader.onerror = function (event) {
        alert("Error");
      }
      reader.onloadend = function (event) {
        $("#pbar").css("width","100%");
      }

      function uploadImage(event) {
          var result = event.target.result;
          var fileName = file.name;
          
          $.post('submit_file.php',
          { data: result, name: fileName,type: typeimag,size: filsize,user_id_for: userId },
           function (e) {

            var a = $(".cds").html();
            //$(".cds").html(a + '<br>' + e);
                $('.user-person-chat').find('.message-content').append(e);
                $('.user-person-chat').scrollTop($('.user-person-chat')[0].scrollHeight);

            //$('.bs-example-modal-sm').modal('hide');
            //alert(file.type);
          });
      }
    }
    });
    </script>
  </body>
</html>
