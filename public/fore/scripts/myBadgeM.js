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
      type: '',
      image: '',
      name: '',
      num: ''
    }

    initDom()

    mine.getBadgeM(options, function (res) {
      console.log(res)
      options.num = res.count
      F.display('myBadgeM', options)
    })

    function initDom () {
      options.id = F.getUrlParams('id')
      options.type = F.getUrlParams('type')
      options.image = decodeURI(F.getUrlParams('image'))
      options.name = sessionStorage.getItem('params')
    }

  })

})