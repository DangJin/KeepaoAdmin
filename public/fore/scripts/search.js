require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'F': '../js/function',
    'template': '../js/template-web',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'store': '../api/store/index'
  }
})

require(['jquery', 'F', 'store'], function ($, F, store) {

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
      keywords: '',
      lng: '106.55096',
      lat: '29.555424',
      page: '1',
      limit: '10'
    }

    initDom()

    // 门店列表
    function getStoreList () {
      store.getStoreList(options, function (res) {
        console.log(res, 'StoreList')
        F.display('search_list', res, function () {
          $('.search_list>.item>a').click(function () {
            var stoid = $(this).data('stoid')
            location.href = 'storeM.html?stoid=' + stoid
          })
        })
      })
    }

    function initDom () {

      $('.search_topSearch>a').on('click', function () {
        options.keywords = $('.search_input>input').val()
        getStoreList()
      })

    }
  })
})