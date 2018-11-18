/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};

/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
$().ready(function(){
//validate register form keyup and submit
$("#registerForm").validate({
      rules: {
        name:{
          required:true,
          minlength:2,
          lettersonly:true
        },
       password:{
         required:true,
         minlength:6
      },
        email:{
        required:true,
        email:true,
        remote:"/check-email"
    }
  },
    messages:{
      name:"Lutfen isminizi Girin",
      password:{
        required:"Lutfen Sifrenizi Girin",
        minlength:"Şifreniz en az 6 karakter içermelidir"
      },
      email:{
        required:"Lutfen Email Adresinizi Girin",
        email:"lutfen onaylı bir mail adresi girin",
        remote:"Bu mal adresi kullanımda exist"
      }
    }
    });

//check current new_pwd
$("#current_pwd").keyup(function(){
  var current_pwd = $(this).val();
  $.ajax({
    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'post',
        url:'/check-user-pwd',
        data:{current_pwd:current_pwd},
        success:function(resp){
        
          if (resp=="false") {
            $("#chkPwd").html("<font color='red'>Current Password is wrong</font>");
          }else if(resp=="true"){
              $("#chkPwd").html("<font color='green'>Current Password is true</font>");
          }
        },error:function(){
          alert("Error");
        }
    });
});
//validate login form keyup and submit
$("#loginForm").validate({
          rules: {
            email:{
            required:true,
            email:true
        },
           password:{
             required:true
          }

      },
        messages:{
           email:{
            required:"Lutfen Email Adresinizi Girin",
            email:"lutfen onaylı bir mail adresi girin"
          },
          password:{
            required:"Lutfen Şifrenizi Girin"
          }
        }
        });
});
