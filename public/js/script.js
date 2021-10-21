$(function (){
    if($('form.material input[type!=hidden]').length){
        $('form.material input[type!=hidden]').each(function (i,v){
            if($(v).val()){
                $(v).addClass('label-top');
            }else{
                $(v).removeClass('label-top');
            }
        });
        console.log($('form.material input[type!=hidden]').val());
    }

    $('form.material input[type!=hidden]').on('blur', function (){
        if($(this).val()){
            $(this).addClass('label-top');
        }else{
            $(this).removeClass('label-top');
        }
    });
});