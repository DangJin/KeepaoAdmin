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

require(['jquery', 'F', 'news'], function ($, F, news) {

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
      uid: '1',
      muid: '2',
      body: '',
      title: '',
      type: 2
    }

    initDom()

    F.wxLogin(function (data) {
      options.uid = data.uid
      $('textarea').on('keyup', function () {
        $('.content>p>span').text(140 - $('textarea').val().length)
        if ($('.content>p>span').text() < 0) {
          $('.content>p>span').text(0)
        }
      })

      $('.yuepao>a').click(function () {
        if ($('.content>textarea').val() === '') {
          alert('内容不能为空！')
        } else {
          options.body = $('.content>textarea').val()
          addLeaveWord()
        }
      })
    })

    // 优惠券列表
    function addLeaveWord () {
      news.addLeaveWord(options, function (res) {
        console.log(res)
        alert('约跑成功！')
        history.back()
      })
    }

    function initDom () {

    }

  })

})