
$(document).ready(function(){
    $(".num_order").change(function(){
        var token = $("input[name='_token']").val();

        var id = $(this).attr('data-id');
        var price = $("#price-"+id).text();
        var num_order = $("#num_order-"+id).val();

        var data_js = {num_order: num_order,price:price, id:id,"_token":token }
        
        $.ajax({ 
            url:'ajax',
            method: 'POST',
            data: data_js,
            dataType:'json',
            success:function(data_php){
                $(".total-"+id).text(data_php.total+"đ");
                $("#cart_total").text(data_php.total_all+"đ");
                $(".notification_count").text("hiện tại có "+data_php.count+" trong giỏ hàng");
                $(".header__cart-notice").text(data_php.count)
            },
            error:function(xhr,ajaxOptions,thrownError){
                alert(xhr.status);
                alert(thrownError);
            }

        });
    });
});