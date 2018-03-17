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
      limit: 10,
      type: '',
      quxiao: {
        myid: '',
        gid: ''
      }
    }

    initDom()

    F.wxLogin(function (data) {
      options.id = data.uid
      mine.getGuanzhuList(options, function (res) {
        console.log(res)
        F.display('guanzhuList', res, function () {
          $('.quxiao').click(function () {
            var that = $(this)
            options.quxiao.gid = $(this).data('gid')
            mine.quxiaoGuanzhu(options.quxiao, function (res) {
              that.parent().remove()
              console.log(res)
            })
          })
        })
      })
    })

    function initDom () {
      options.type = F.getUrlParams('type')
      options.id = F.getUrlParams('uid')
      options.quxiao.myid = F.getUrlParams('uid')
    }

  })

})