$(document).ready(function(){
    $('.header__search-history').mousedown(function(e){
        e.preventDefault();
    });
    $('.header__search-input').keyup(function(){
        
        var txt=$('.header__search-input').val();
        if(txt ==''){
            $('.header__search-history').html('');
        }else{

           var token = $("input[name='_token']").val();

            var search_value= $(".header__search-input").val();

            var data_js ={search_value:search_value, "_token":token }

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url:'http://localhost/Laravelpro/ismart/cart/search_ajax',
                method:'POST',
                data:data_js,
                dataType:'text',
                success:function($output){
                    $('.header__search-history').html($output);       
                },
                error:function(xhr,ajaxOptions,thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    });
});