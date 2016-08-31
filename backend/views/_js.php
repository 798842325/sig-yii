<script>
    $('.ajax-form').submit(function(){

        url = $(this).attr('action');

        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $(this).serialize(),
            success: function(data){

                if(data.status){
                    swal({
                        title: data['title'],
                        text: data['info'],
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "返回列表",
                        cancelButtonText:'继续',
                        closeOnConfirm: true
                    }, function (isConfirm) {
                        if(isConfirm){
                            window.location.href = data.url;
                        }else{
                            window.location.reload();
                        }
                    });
                }else{
                    swal(data['title'], data['info'], "error");
                }
            }
        });

        return false;
    });

</script>