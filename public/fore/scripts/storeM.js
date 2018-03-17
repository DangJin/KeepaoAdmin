require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'F': '../js/function',
    'template': '../js/template-web',
    'swiper': '../js/swiper.min',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'store': '../api/store/index'
  }
})

require(['jquery', 'F', 'store', 'swiper'], function ($, F, store, Swiper) {

  /**
   * 监听页面加载完成
   *
   * initDom 初始化对于原始Dom的操作
   *
   * F.display("容器","渲染数据","Dom操作")
   *
   */
  $(function () {
    // 全局存储用户id
    var options = {
      token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtc2twIiwiYXVkIjoibG9jYWxob3N0Ojg4ODgiLCJhSWQiOiJvc0ZqRnVIeWd3elNDdUlZRlV1SEk5MnFNTjhNIiwiaWF0IjoxNTE2ODEyNTUxLCJleHAiOjE1MTc0MTczNTEsInBzZCI6IiJ9.-GjpocYuDUcYnekrn0LL-t7XPq84FWWpQvJBJcEdZTU',
      id: ''
    }

    initDom()

    // 门店详情
    store.getStoreMessage(options, function (res) {
      console.log(res, 'StoreMessage')
      F.display('storeM', res, function () {
        // 轮播图
        var swiper = new Swiper('.swiper-container', {
          slidesPerView: 1,
          spaceBetween: 30,
          loop: true,
          pagination: {
            el: '.swiper-pagination',
            clickable: true
          }
        })

        // 关闭营业提示
        $('.top_news>img').on('click', function () {
          $('.top_news').css('display', 'none')
        })

        setTimeout(function () {
          $('.top_news').css('display', 'none')
        },3000)

        // 器材使用说明
        $('.storeM_product').find('a').click(function () {
          var equid = $(this).data('equid')
          location.href = 'shiyongsm.html?equid=' + equid
        })
      })
    })

    function initDom () {
      options.id = F.getUrlParams('stoid')

    }

  })
})