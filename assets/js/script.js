;(function ($) {
    $(document).ready(function () {
        $("#login").on('click', function () {
            $("#form01 h3").html("Login");
            $("#action").val("login");
        });

        $("#register").on('click', function () {
            $("#form01 h3").html("Register");  // form er h3 change hoye jabe
            $("#action").val("register");  //action er input value register hoye jabe
        });

        $(".menu-item").on('click', function () {
            $(".helement").hide();
            var target = "#"+ $(this).data("target");
            $(target).show();
        });

         $("#alphabets").on('change',function(){
            //var char = $(this).val().toLowerCase();
            var char = $(this).val();

            if('all'==char){
                $(".words tr").show();
                return true;
            }
            $(".words tr:gt(0)").hide();

            $(".words td").filter(function(){
                return $(this).text().indexOf(char)==0;
            }).parent().show();
        });

    })
})(jQuery);

$("#input-field").keyup(function(e) {
  var regex = /^[a-zA-Z0-9@]+$/;
  if (regex.test(this.value) !== true)
  this.value = this.value.replace(/[^a-zA-Z0-9@]+/, '');
});