$(document).ready(function(){
    $(".cart-trigger").click(function(){
        $(".cart-panel").toggle("fast");
        $(this).toggleClass("active");
        return false;
    });
});