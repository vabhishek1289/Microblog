$(document).ready(function () {


  var temp=0;
  $('body').on('click','#location_set',function () {
    if(temp==0) {
      getLocation();
      temp = 1;
      return;
    }
    else if(temp == 1) {
      $(this).find('.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-remove');
      temp = 0;
      $('.location_input').val('');
      return;
    }
  });
  function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
      } else {
          alert("Geolocation is not supported by this browser.");
      }
  }
  function showPosition(position) {
    var latlon = position.coords.longitude+ ","+ position.coords.latitude ;
    //alert(latlon);
    $('.location_input').val(latlon);
    $('.checked_btn').find('.glyphicon-remove').removeClass('glyphicon-remove').addClass('glyphicon-ok');
  }

	document.onscroll = function() {myFunction()};
	function myFunction() {
			if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
				document.getElementsByClassName("scroll-up-button")[0].className = "scroll-up-button-on";
			} else {
				document.getElementsByClassName("scroll-up-button-on")[0].className = "scroll-up-button";
			}
	}
	$(".scroll-up-button").on("click",function (){
		$(".scroll-up-button-on").addClass("scroll-up-button-off");
		$("html, body").animate({ scrollTop: 0 }, "slow");
  	return false;
	});

  $("#demo02").animatedModal({
      modalTarget:'modal-02',
      animatedIn:'lightSpeedIn',
      animatedOut:'bounceOutDown',
      color:'rgba(0,0,0,0.8)',
      // Callbacks
      beforeOpen: function() {
          console.log("The animation was called");
      },
      afterOpen: function() {
          console.log("The animation is completed");
      },
      beforeClose: function() {
          console.log("The animation was called");
      },
      afterClose: function() {
          console.log("The animation is completed");
          $('body').css('overflow','hidden');
      }
  });
  var files;
  $('input[type=file]').on('change', prepareUpload);
  function prepareUpload(event) {
    var file_data = '<br>';
    for (var i = 0; i < event.target.files.length; i++) {
      files = event.target.files[i];
      file_data = file_data+''+files.name+'('+files.size/1000+' Kb)<br>';
    }
    $('.file_inf').html(file_data);
  }
  window.onbeforeunload = function () {
      // TODO: Add code to logout user online to offline (Heartbeat design pattern)
  };
});
