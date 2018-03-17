require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'F': '../js/function',
    'template': '../js/template-web',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'news': '../api/news/index'
  }
})

require(['jquery', 'news', 'F'], function ($, news, F) {

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
      uid: '',
      type: '1'
    }

    initDom()

    F.wxLogin(function (data) {
      options.uid = data.uid
      getSystemNews()
    })
    // 系统消息列表
    function getSystemNews () {
      news.getNewsList(options, function (res) {
        console.log(res, 'NewsList')
        F.display('news_list', res, function () {
          $('.news_list>ul>li').click(function () {
            $(this).siblings().removeClass('active')
            $(this).addClass('active')
          })
        })
      })
    }

    function initDom () {
      options.uid = F.getUrlParams('uid')
    }

  })

})