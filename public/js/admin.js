$(function () {
    let translations = false;
    if ($('.show-message').length) {
        Swal.fire({
            icon: $('.show-message').data('success') ? 'success' : 'error',
            title: $('.show-message').data('success') ? 'Great' : 'Oops...',
            text: $('.show-message').data('message')
        }).then((res) => {
            // $('.show-message').remove();
        })
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('a.btn-remove').on('click', function (e) {
        e.preventDefault();
        let self = $(this);
        Swal.fire({
            title: 'Item will be deleted',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'Remove<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>',
            confirmButtonColor: '#F1416C',
            cancelButtonText: 'Cancel',
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    url: self.attr('href'),
                    method: 'post',
                    data: {
                        _method: 'delete'
                    },
                    success: function (res) {
                        if (res.success) {
                            location.href = location.href;
                        }
                    },
                });
            }
        })
    });

    if ($('input[name="langauge_check"]').length) {
        //     let showTranslation = getCookie('is_italian');
        //     showTranslation = parseInt(showTranslation);
        //     $('input[name="langauge_check"]').prop('checked', showTranslation);
        translations = JSON.parse($('input[name="translations"]').val());
        //     if(showTranslation){
        //         setTranslations(true);
        //     }
    }

    $('.file-upload').on('click', function () {
        $(this).next().trigger('click');
    });

    $('.file-upload').next().on('change', function () {
        const [file] = this.files;
        if (file) {
            let parent = $(this).prev();
            if (!$('img', parent).length) {
                $(parent).html('<img class="mw-100 mh-200px"/>');
            }
            let image = $('img', parent);
            var reader = new FileReader();

            reader.onload = function (e) {
                console.log(image);
                image.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    })

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        $.ajax({
            method: "GET",
            url: location.origin + '/admin/set-cookie',
            data: {
                name: cname,
                value: cvalue
            },
            success: function (res) {
                setTranslations(cvalue);
                // console.log(res);
            }
        })
        // d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        // let expires = "expires="+d.toUTCString();
        // document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    $('.uppend-table').on('click', function (){
        var self = $(this);
        let ids = $('.tables-content div[data-id]');
        console.log(ids);
        let id = 1;
        for(let i = 0; i < ids.length; i++){
            console.log(+$(ids[i]).attr('data-id'), id);
            if(+$(ids[i]).attr('data-id') !== id){
                break;
            }
            id++;
        }
        $.ajax({
            method: 'POST',
            data:{
                id: id
            },
            url: location.origin + location.pathname,
            success: function (res){
                if(res.success){
                    let str = '<div class="p-2 col-12 col-sm-3 col-xs-6" data-id="' + res.success.id + '">';
                    str += '<div class="position-relative py-12 rounded text-center bg-light">';
                    str += '<span>' + res.success.id + '</span>';
                    str += '</div></div>';
                    if(!$('.tables-content').length){
                        $('#tables-body').html('<div class="row tables-content flex-sm-row flex-xs-row flex-column"></div>');
                    }
                    $('#tables-body .tables-content').append(str);
                    let integer = +$(self).prev().text();
                    $(self).prev().text(++integer);
                }
            }
        })
    });
    $('.destroy-table').on('click', function (){
        let self = $(this);
        if(!$('.tables-content').length){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tables doesnt exists'
            }).then((res) => {
                // $('.show-message').remove();
            })
            return;
        }
        $.ajax({
            method: 'POST',
            data:{
                _method: 'DELETE'
            },
            url: location.origin + location.pathname + '/1',
            success: function (res){
                if(res.success){
                    console.log($('.tables-content div[data-id="' + res.id + '"]'));
                    $('.tables-content div[data-id="' + res.id + '"]').remove();
                    console.log($('.tables-content > div'));
                    if(!$('.tables-content > div').length){
                        $('#tables-body').html('<h2 class="my-7 py-5">Tables not exists, Create it with one click!</h2>');
                    }
                    let integer = +$(self).next().text();
                    $(self).next().text(--integer);
                }
            }
        })
    });
    if(window.location.pathname.match(/\/admin\/tables[\/]*/)){
        let products = [];
        $('#tables-body div[data-products]').map(function (item,value){
            if($(value).attr('data-products') != 0){
                products[$(value).attr('data-id')] = JSON.parse($(value).attr('data-products'));
            }
        });
        $('#tables-body div[data-products] div.cursor-pointer').on('click', function (){
            $('#orders-modal').modal('show');
            let str = '';
            let orders = products[+$(this).parents('div[data-id]').attr('data-id')];
            if(orders){
                $('#orders-modal').attr('data-table-id', +$(this).parents('div[data-id]').attr('data-id'))
                orders.map(function (order,i){
                    for(let k = 0; k < order.count; k++){
                        str += '<div class="row row-cols-3 align-items-center py-5" data-order-id="' + order.orderId + '" data-product-id="' + order.product.id + '" data-product-price="' + order.product.price + '">';
                        str += '<div><img src="' + location.origin + '/uploads/products/' + order.product.thumbnail + '" class="mw-100"/></div>';
                        str += '<div class="text-center"><span class="text-gray-500 order-price">' + order.product.price + ' <span class="ba ' + order.product.currency_short.icon + '"></span></span></div>';
                        str += '<div class="text-center"><button class="btn btn-sm bill-one">Bill</button><button class="btn btn-success btn-sm bill-row">Cancel</button></div>'
                        str += '</div>';
                    }
                });
            }
            if(str == ''){
                str = 'Order doesnt exists';
            }
            $('#orders-modal').attr('data-table-id', $(this).parent('div').attr('data-id'));
            $('#orders-modal .modal-body').html(str);
        });

        $(document).on('click', '.bill-one', function (){
            let parent = $(this).parents('div.row[data-order-id]');
            $.ajax({
                  url: location.href.replace(/\/$/, '' ) + '/bill',
                  method: 'POST',
                  data: {
                      one: true,
                      order: parent.attr('data-order-id'),
                      product: parent.attr('data-product-id')
                  },
                  success: function (res){
                    if(res.success){
                        parent.remove();
                    }
                  }  
            })
        });

        $(document).on('click', '.bill-row', function (){
            let parent = $(this).parents('div.row[data-order-id]');
            $.ajax({
                  url: location.href.replace(/\/$/, '' ) + '/bill',
                  method: 'POST',
                  data: {
                      delete: true,
                      order: parent.attr('data-order-id'),
                      product: parent.attr('data-product-id')
                  },
                  success: function (res){
                    if(res.success){
                        parent.remove();
                    }
                  }  
            })
        });

        $(document).on('click', '#orders-modal .btn-bill-order', function (){
            $(this).attr('disabled', 'disabled');
            let parent = $(this).parents('#orders-modal');
            bill({table_id: parent.attr('data-table-id')}, function (res){
                let price = 0;
                $('#orders-modal div[data-product-price]').map(function (index, item){
                    price += +$(item).attr('data-product-price');
                }); 
                Swal.fire({
                    icon: 'success',
                    title: 'Great',
                    html: '<span class="price d-inline text-center text-gray-500 fs-2 d-sm-block">Price ' + price + '<span class="ba bi-currency-euro"></span></span>',
                    content: $('#orders-modal')
                }).then((res) => {
                    location.reload();
                })
            });
        });

        $(document).on('click', '.remove-orders', function (){
            $(this).attr('disabled', 'disabled');
            let parent = $(this).parents('#orders-modal');
            bill({table_id: parent.attr('data-table-id'), close:true});
        });

        function bill(data, callback)
        {
            if(typeof callback === 'undefined'){
                callback = function (res){
                    if(res.success){
                        if(res.closeTable){
                            location.reload();
                        }
                    }else{
                        location.reload();
                    }
                  } 
            }

            $.ajax({
                url: location.href.replace(/\/$/, '' ) + '/bill',
                method: 'POST',
                data: data,
                success:  callback
          })
        }
    }

    if($('.tagify[selected]').length){
        $('.tagify-list').append('<span class="bg-success rounded my-2 py-2 px-4 ms-5" value="' + $('.tagify[selected]').eq(0).attr('value') + '">' + $('.tagify[selected]').eq(0).text() + '</span>');
        $('.tagify[selected]').eq(0).remove();
    }

    $('.tagify').on('click', function (){
        let parent = $(this).parents('.tagify-block');
        let list = $('.tagify-list', parent);
        if($('span', list).length){
            $('.tagify-all').append('<span class="px-2 py-4 bg-info text-white cursor-pointer rounded tagify" value="' + $('span:eq(0)', list).attr('value') + '">' + $('span:eq(0)', list).text() + '</span>');
            $(list).html('');
        }
        $('input', parent).attr('value', $(this).attr('value'));
        $(list).append('<span class="bg-success rounded my-2 py-2 px-4 ms-5" value="' + $(this).attr('value') + '">' + $(this).text() + '</span>');
        $(this).remove();
    });
})
