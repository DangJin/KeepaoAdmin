require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'F': '../js/function',
    'template': '../js/template-web',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'mine': '../api/mine/index'
  }
})

require(['jquery', 'F', 'mine'], function ($, F, mine) {

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
      id: '',
      page: 1,
      limit: 10
    }

    initDom()
    F.wxLogin(function (data) {
      options.id = data.uid
      mine.getJfHistory(options, function (res) {
        F.display('jfHistory', res, function () {
          $('.qiandao>a').click(function () {
            if ($(this).text() === '签到') {
              mine.SignIn(options, function (res) {
                $('.qiandao>a').text('已签到')
              })
            } else {
              console.log(333)
            }
          })
        })
        console.log(res)
      })
    })

    function initDom () {

      options.id = F.getUrlParams('uid')
    }

  })

})