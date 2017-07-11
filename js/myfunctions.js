  $(document).ready(function () {
    $(document).on("click",".grpinfo",function(){
      $(this).siblings().slideToggle("slow");
    });
  });