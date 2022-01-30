"use strict"

require('./bootstrap');

$('#pin-modal').modal('show');

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


let basket = [];
let orders = [];

if($('.orders[data-orders]').length){
  orders = JSON.parse($('.orders[data-orders]').attr('data-orders'));
}


if(location.pathname === "/"){
  sessionStorage.clear();
}

if(sessionStorage.getItem('basket')){
  basket = JSON.parse(sessionStorage.getItem('basket'));
}

if(sessionStorage.getItem('orders')){
  orders = JSON.parse(sessionStorage.getItem('orders'));
}
if(orders.length){
  if($('div[data-table-id]').length){
    $.ajax({
      url: location.origin + '/orders',
      data: {
        table_id: $('div[data-table-id]').attr('data-table-id')
      },
      success: function (res){
        if(res.success){
          console.log(orders);
          orders = res.orders.map(function (item,index){
            return {id:item.product_id,count:item.count};
          });  
          console.log(orders);
          sessionStorage.setItem('orders', JSON.stringify(orders));
        }else{
          location.href = '/';
        }
      },
      error: function (err){
        location.href = '/';
      }
    });
  }
}

// basket.map(function (item){
//   let parent = $('.product[data-id="' + item.id + '"]');
//   $('.count-in-basket', parent).text(item.count);
//   $('.add-to-basket', parent).removeClass('bg-hover-success text-hover-white').addClass('bg-success').attr('data-count', item.count);
//   $('.add-to-basket i', parent).addClass('text-white');
//   $('.add-to-basket span', parent).text(item.count);
// });

if(basket.length){
  $('.products-basket').append('<i class="bi bi-check-circle-fill position-absolute text-success top-right-absolute"></i>');
}

$('#pin-modal button[type="submit"]').on('click', function (e){
    e.preventDefault();
    sendPinCode($('form', $(this).parents('.modal-content')));
});

$('#pin-modal form').on('submit', function (e){
  e.preventDefault();
  sendPinCode($('form', $(this).parents('.modal-content')));
});

$('#pin-modal').on('hidden.bs.modal', function (e,res) {
  $('.modal-backdrop').remove();
  $('.container-fluid').html(res.success);
});

$(document).on('click', '.order-table', function (){
    if($(this).hasClass('closed')){
      location.href = $(this).attr('data-path');
      return;
    }
    $('.modal-body').html('<div class="text-center"></div>');
    $('.modal-body div.text-center').append($('.d-none svg', this).clone());
    $('#table-close a').attr('href', $(this).attr('data-path'));
    $('#table-close').modal('show');
});

$('.product[data-id] .uppend').on('click', function (){
  let count = +$(this).prev().text();
  $(this).prev().text(++count);
  $('button.add-to-basket', $(this).parents('.product')).attr('data-count', count);
  $('button.add-to-basket span', $(this).parents('.product')).text(count);
});

$('.product[data-id] .depend').on('click', function (){
  let count = +$(this).next().text();
  count -= 1;
  count = count > 0 ? count : 1;
  $(this).next().text(count);
  $('.product button.add-to-basket').attr('data-count', count);
  $('button.add-to-basket span', $(this).parents('.product')).text(count);
});

$(document).on('slide.bs.carousel', '#carousel-products', function (){
  $('button.add-to-basket').removeAttr('disabled');
});

$(document).on('click', 'button.add-to-basket', function (){
   let productId = +$(this).attr('data-id');
   let index = basket.findIndex(function (item){
     return item.id == productId
   });
   let count = 1;
   if(index > -1){
      basket[index].count += 1;
      count = basket[index].count;
    }else{
      basket.push({id: productId, count});
   }
   sessionStorage.setItem('basket', JSON.stringify(basket));
   $(this).attr('disabled', 'disabled');
   $(this).prev().text('Count: ' + count);
   if(basket.length && !$('.products-basket .bi-check-circle-fill').length){
    $('.products-basket').append('<i class="bi bi-check-circle-fill position-absolute text-success top-right-absolute"></i>');
   }
});

$(document).on('click', '.product', function (){
  let self = $(this);
  let categoryName = self.parents('.tab-pane').attr('id');
  $('#products-slider .modal-body').html('');
  if($('#products-slider').attr('data-active') === categoryName){
    if(!$('#products-slider #carousel-products').length){
      addSliderContent(categoryName,self);
    }
  }else{
    addSliderContent(categoryName,self);
  }

  $('#carousel-products .carousel-inner .carousel-item').removeClass('active');
  $.each($('#carousel-products .carousel-inner .carousel-item'),function (i,v){
    if($('img',v).attr('src') === $('img', self).attr('src')){
      $(v).addClass('active');
    }
  });
 
  $('#products-slider .add-to-basket').removeAttr('disabled');
  $('#products-slider').attr('data-id', self.attr('data-id'))
  $('#products-slider').modal('show')
});

$('#products-basket').on('show.bs.modal', function (){
  generateOrdersContent();
});

$('#products-basket a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
  let target = $(e.target).attr("href") // activated tab
  if(target.match(/orders/)){
    $('.modal-footer button.order').addClass('invisible');
    $('.modal-footer .price-all').addClass('invisible');
  }else{
    if(basket.length){
      $('.modal-footer button.order').removeClass('invisible');
      $('.modal-footer .price-all').removeClass('invisible');
    }
  }
});

function generateOrdersContent()
{
  let str = {basket: '', orders: ''};
  let allPrice = 0;
  let priceCurrency = '';
  basket.map(function (item){
    for(let i = 0; i < item.count; i++){
      let product = $('.product[data-id="' + item.id + '"]');
      str.basket += '<div class="d-flex flex-column flex-sm-row text-center align-items-sm-center border rounded my-1" data-product="' + item.id + '">';
      str.basket += '<div class="col"><img src="' + $('img', product).attr('src') + '" alt="" class="mw-100 mh-sm-90px"></div>';
      str.basket += '<div class="col-sm-7"><h3>' + $('.product-title a', product).text() + '</h3></div>';
      str.basket += '<div class="col d-flex align-items-center justify-content-center">';
      let productPrice = +$('.product-price', product).attr('data-price');
      allPrice += productPrice;
      priceCurrency = '<span class="' + $('.product-price span', product).attr('class') + '"></span>';
      str.basket += '<span class="price d-inline text-center text-gray-500 fs-2 d-sm-block">' + productPrice + '<span class="' + $('.product-price span', product).attr('class') + '"></span></span>';
      str.basket += '<button class="btn bg-hover-danger btn-sm remove-order-basket text-hover-white"><i class="bi bi-trash fs-1"></i></button>';
      str.basket += '</div>';
      str.basket += '</div>';
    }
  });
  if(str.basket === ""){
    str.basket = '<h4 class="text-center my-8">Basket is empty</h4>';
  }
  if(allPrice){
    $('#products-basket .modal-footer .price-all').html(allPrice + priceCurrency).removeClass('invisible');
  }else{
    $('#products-basket .modal-footer .price-all').addClass('invisible')
  }
  $('#products-basket .modal-body .tab-content #basket').html(str.basket);
  allPrice = 0;
  priceCurrency = '';
  orders.map(function (item){
    for(let i = 0; i < item.count; i++){
      let product = $('.product[data-id="' + item.id + '"]');
      str.orders += '<div class="d-flex flex-column flex-sm-row text-center align-items-sm-center border rounded my-1">';
      str.orders += '<div class="col"><img src="' + $('img', product).attr('src') + '" alt="" class="mw-100 mh-sm-90px"></div>';
      str.orders += '<div class="col-sm-7"><h3>' + $('.product-title a', product).text() + '</h3></div>';
      str.orders += '<div class="col d-flex align-items-center justify-content-center">';
      let productPrice = +$('.product-price', product).attr('data-price');
      allPrice += productPrice;
      priceCurrency = '<span class="' + $('.product-price span', product).attr('class') + '"></span>';
      str.orders += '<span class="price d-inline text-center text-gray-500 fs-2 d-sm-block">' + productPrice + '<span class="' + $('.product-price span', product).attr('class') + '"></span></span>';
      str.orders += '</div>';
      str.orders += '</div>';
    }
  });
  if($('#products-basket #orders.active').length){
    $('#products-basket .modal-footer .price-all').addClass('invisible')
  }
  $('#products-basket .modal-body .tab-content #orders').html(str.orders);
}

$(document).on('click', '.remove-order-basket', function (){
  let parent = $(this).parents('div[data-product]');
  let k = basket.findIndex(function (item){
    return item.id === +parent.attr('data-product');
  });
  if(k > -1){
    basket[k].count--;
    $('#products-basket .price-all').html($('#products-basket .price-all').html().replace(/\d+/, (+$('#products-basket .price-all').text() - +$('.price',parent).text())))
    $(parent).remove();
    if(basket[k].count === 0){
      basket.splice(k,1);
      if(!basket.length){
        $('.modal-body .tab-content #basket').html('<h4 class="text-center my-8">Basket is empty</h2>');
        $('.products-basket .bi-check-circle-fill').remove();
        $('#products-basket .price-all').addClass('invisible');
      }
    }
    sessionStorage.setItem('basket',JSON.stringify(basket));
  }
});


function sendPinCode(parent){
    $.ajax({
      url: $(parent).attr('action'),
      method: 'POST',
      data:{pin: $('input[name="pin"]',parent).val()},
      success: function (res){
        if(res.success){
            $('#pin-modal').trigger('hidden.bs.modal', [res]);
        }else{
            $('input[name="pin"]',parent).addClass('is-invalid');
        }
      }  
    });
}

$('#products-basket button.order').on('click', function (){
  if(basket.length){
    order();
  }else{
    $('.modal-body h4', $(this).parents('#products-basket')).addClass('text-danger');
  }

});

function addSliderContent(categoryName, self){
  var str = '<div id="carousel-products"  class="carousel slide" data-ride="carousel" data-interval="false"><div class="carousel-inner">';
      $.each($('#' + categoryName + ' .product'), function (index,v){
        let isActive = $('img',v).attr('src') === $('img', self).attr('src');
        let id = +$(v).attr('data-id');
        let count = basket.filter(function (item){
          return item.id == id;
        });
        str += '<div class="carousel-item ' + (isActive ? 'active' : '') + '"><div class="w-80 m-auto d-flex justify-content-between text-center flex-sm-row flex-column align-items-sm-center">';
        str += '<img class="d-block col-sm-7" src="' + $('img',v).attr('src') + '" alt="">';
        str += '<div class="d-flex flex-column order-content col-sm-4">';
        str += '<h4>' + $('.product-title a',v).text() + '</h4>';
        str += '<span class="fw-boldest text-gray-600 my-1 fs-3 product-price" data-price="' + $('.product-title span[data-price]',v).attr('data-price') + '">Price: ' + $('.product-title span[data-price]',v).attr('data-price') + ' <span class="' + $('.product-title span[data-price] span',v).attr('class') + '"></span></span>';
        str += '<span class="fw-boldest text-gray-600 my-1 fs-3 product-count">Count: ' + (typeof count[0] != 'undefined' ? count[0].count : 0) + '</span>';
        str += '<button class="add-to-basket btn btn-success btn-sm" data-id="' + id + '"><i class="bi bi-basket fs-1"></i></button>';
        str += '</div>'; 
        str += '</div></div>';
      });
      // Buttons
      str += '</div>';
      str += '<a class="carousel-control-prev" href="#carousel-products" role="button" data-slide="prev"> <i class="bi bi-arrow-left-circle fs-1 text-info"></i> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carousel-products" role="button" data-slide="next"> <i class="bi bi-arrow-right-circle fs-1 text-info"></i> <span class="sr-only">Next</span> </a>';
      str += '</div>';
      $('#products-slider .modal-body').append(str);
      $('#products-slider').attr('data-active', categoryName);
}

function order()
{
  $.ajax({
    url:  location.origin + '/order',
    method: 'POST',
    data: {
      orders: basket,
      table: +$('div[data-table-id]').attr('data-table-id')
    },
    success: function (res){
      if(res.success){
        basket.map(function (item){
          let exists = orders.findIndex(function (order){
            return order.id === item.id;
          })
          if(exists > -1){
            orders[exists].count++;
          }else{
            orders.push(item);
          }
        });
        basket = [];
        $('.products-basket .bi-check-circle-fill').remove();
        sessionStorage.setItem('orders', JSON.stringify(orders));
        sessionStorage.setItem('basket', JSON.stringify(basket));
        Swal.fire({
          title: 'Thanks for order',
        }).then(function (res){
            $('#products-basket').modal('hide');
            generateOrdersContent()
        })
        // ;
      }else{
        $.ajax({
          url: location.origin + '/remove-pin',
          method: 'POST',
          success: function (res){
            location.href = '/';
          }
        });
      }
    },
    error: function (err){
      sessionStorage.clear();
      $.ajax({
        url: location.origin + '/remove-pin',
        method: 'POST',
        success: function (res){
          location.href = '/';
        }
      });
    }
  });
}