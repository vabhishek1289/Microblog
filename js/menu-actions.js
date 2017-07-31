$(document).ready(function () {
  var  gl = 1;
  $(".menu-open-tag").click(function () {
    if( gl == 1) {
        //$(".main-menu").attr("style","display: block;");
        $(".main-menu").fadeIn();
        gl=0;
    }
    else if(gl == 0) {
        //$(".main-menu").attr("style","display: none;");
        //$(".main-menu").animate({opacity: "0",transformX: '-400px'},"slow");
        $(".main-menu").fadeOut();
        gl = 1;
        //$(".menu-text").hide();
        //$(".item").attr("style","width: auto;");
    }
  });
/*  $(".item").mouseover(function () {
    $(".item").attr("style","width: 300px;");
    $(".menu-text").fadeIn();
  });
  */
  var flag = 'a';
  var count = 0;
  var acount = 0;
  $('html').click(function (e) {
    if(gl !=1)
    {
      acount++;
    }
    if(acount > 1)
    {
      if($(e.target).closest('.main-menu').length>0)
      {
        return ;
      }
      //code to close menu here this will only execute when click event occur on body apart from  menu
      $(".main-menu").hide();
      gl = 1;
      //$(".menu-text").hide();
      //$(".item").attr("style","width: auto;");
      acount = 0;
    }

  });
  $(".dropdown").click(function (e) {
    //a=$(this).attr("class");
    //alert(a);
    if(flag=='a' && count ==0) {
      a = $(this).attr("id");
      //a="modal1"
      //alert(a);
      $("."+a).attr("style","width:300px;");
      $("."+a).slideDown();
      flag='.'+a;
      count++;
    }
    else if(count>0) {
      //alert(x);
      a = $(this).attr("id");
      //a = $(e.target).find("a").attr("id");
      //a = $(e.target).parent().attr("id");
      if(flag == '.'+a) {
        $("."+a).attr("style","display: none;");
        $("."+a).slideUp();
        flag='a';
        count-- ;
      }
      else {
        $(flag).attr("style","display: none;");
        $(flag).slideUp();
        flag='a';
        count-- ;
        a = $(this).attr("id");
        //a = $(e.target).find("a").attr("id");
        //a = $(e.target).parent().attr("id");
        $("."+a).attr("style","width:300px;");
        $("."+a).slideDown();
        flag='.'+a;
        count++;
      }
    }
  });
});
