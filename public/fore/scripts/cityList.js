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

require(['jquery', 'F', 'store', 'wx'], function ($, F, store, wx) {

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
      city: '',
      data: ''
    }

    initDom()


    //城市列表
    function getCityList () {
      store.getCityList(options, function (res) {
        options.data = res
        F.display('cityList', options, function () {
          $('.list>ul>li').click(function () {
            var Content = $(this).text()
            sessionStorage.setItem('City', Content)
            location.href = 'storeList.html'
          })
        })
      })
    }

    function initDom () {
      options.city = sessionStorage.getItem('ThisCity')
      getCityList()
    }
  })
})