/**
 * Created by Administrator on 2017/7/27.
 */

$(function(){
    $(".submenu").css("display","none");
    $(".item2 .dropdown-toggle").click(function(event){
        event.preventDefault();
        $(this).siblings(".productList").toggle();
    });
    $(".item4 .dropdown-toggle").click(function(event){
        event.preventDefault();
        $(this).siblings(".productList").toggle();
    });
    $(".item5  .dropdown-toggle").click(function(event){
        event.preventDefault();
        $(this).siblings(".submenu").toggle();
    });
    $(".item7 .dropdown-toggle").click(function(event){
        event.preventDefault();
        $(this).siblings(".submenu").toggle();
    });
    $(".item8 .dropdown-toggle").click(function(event){
        event.preventDefault();
        $(this).siblings(".submenu").toggle();
    });
    $(".item9 .dropdown-toggle").click(function(event){
        event.preventDefault();
        $(this).siblings(".submenu").toggle();
    });

    //��ֹ��תҳ��
    $(".erji a").click(function(event){
        event.preventDefault();
    });
    $(".productList").siblings("a").click(function(event){
        event.preventDefault();
    });
    //��ȡÿһ��li
    $(".productList li").each(function(){
        $(".erji").click(function(){
            $(this).siblings(".productL").toggle();
        })
    });
});
