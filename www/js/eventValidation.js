$(function () {
    $('input[type="password"]').live(function () {
        var len = $(this).get(0).value.length;
        if (len < 6){
        	$(this).addClass('short');
        }else{
        	$(this).removeClass('short');
        }
    });
});