<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Project Home Page Template</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	<style media="screen">     
      .forget-pass {
        background: #f77;
        margin: 10px;
        float: right;
        color: white;
      }
      .form-box-forget {
        width: 100%;
        height: 200px;
        padding: 15px;
      }
      .form-box-forget select {
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
      .modal-header {
      	background: #0ba;
      }
    </style>	
</head>
<body>
<button type="button" class="btn forget-pass" data-toggle="modal" data-target=".bs-example-modal-sm-1">Autologout</button>




	<div class="modal fade bs-example-modal-sm-1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pleas Enter time</h4>
                </div>
                <div class="form-box-forget">                  
                    <select name='timer'>
                    	<option value='5'>30 Seconds</option> 
                    	<option value='60'>1 Minute</option> 
                    	<option value='300'>5 Minute</option> 
                    	<option value='600'>10 Minute</option> 
                    	<option value='1800'>30 Minute</option> 
                    	<option value='180000000'>Stop</option> 
                    </select>
                    <input type="submit" name="email_submit" value="start">   
                    <input type="text" disabled ="true"/>
                </div>
              
            </div>
          </div>
        </div>
	<script src="js/jquery-3.0.0.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
	var Timer = 0;

	$('input[name=email_submit]').click(function () {
		var a = $(this).parent().find('select[name=timer]').val();		
			setCookie('timer',a,1);		
			startTimer();		
	});

	setInterval(function () {
		if(getCookie('timer') == '' && getCookie('timer_set') != '') {
			setCookie('timer_set',0,1);					
			location.href = 'logout.php' // yaha par logout.php open
		} else {
			setCookie('timer',getCookie('timer')-1,1);
			var time = getCookie('timer');
			if(time < 18000) {
				$('input[type=text]').val(time+' sec');				
			} else {
				$('input[type=text]').val('Stop');				
			}			
		}
	},1000);

	function startTimer() {
		setCookie('timer_set',24*60*60*1000,1);					
	}
		</script>
		<script>
function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (cvalue*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
} 
</script>
</body>
</html>