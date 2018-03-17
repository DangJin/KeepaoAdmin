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
      uid: '',
      headimg: '',
      name: '',
      dabiao: '',
      denglu: '',
      ranka: '',
      dianzan: '',
      fenxiang: '',
      huozan: '',
      yaoqing: '',
      type: 1,
      data: []
    }

    initDom()

    F.wxLogin(function (data) {
      options.uid = data.uid
      getBadgeListFirst()
    })

    function getBadgeListFirst () {
      mine.getBadgeListFirst(options, function (res) {
        console.log(res)
        options.data = res
        options.type = 1
        F.display('myBadge', options, function () {
          $('.list_select>ul>li').eq(1).removeClass('active')
          $('.list_select>ul>li').eq(0).addClass('active')
          $('.list_select>ul>li').eq(1).click(function () {
            getBadgeListLast()
          })
          $('.content>ul>li>a').click(function () {
            var Id = $(this).data('id')
            var Type = $(this).data('type')
            var Image = $(this).find('img').attr('src')
            var Name = $(this).find('span').text().toString() + '勋章'
            sessionStorage.setItem('params', Name)
            location.href = 'myBadgeM.html?id=' + Id + '&type=' + Type + '&image=' + Image
          })
        })
      })
    }

    function getBadgeListLast () {
      mine.getBadgeListLast(options, function (res) {
        console.log(res)
        options.data = res
        options.type = 2
        F.display('myBadge', options, function () {
          $('.list_select>ul>li').eq(0).removeClass('active')
          $('.list_select>ul>li').eq(1).addClass('active')
          $('.list_select>ul>li').eq(0).click(function () {
            getBadgeListFirst()
          })
          $('.content>ul>li>a').click(function () {
            var Id = $(this).data('id')
            var Type = $(this).data('type')
            var Image = $(this).find('img').attr('src')
            var Name = $(this).find('span').text().toString() + '勋章'
            sessionStorage.setItem('params', Name)
            location.href = 'myBadgeM.html?id=' + Id + '&type=' + Type + '&image=' + Image
          })
        })
      })
    }

    function initDom () {
      var Options = JSON.parse(sessionStorage.getItem('ToMyBadge'))
      options.uid = Options.uid
      options.headimg = Options.headimg
      options.name = Options.name
      options.dabiao = Options.dabiao
      options.denglu = Options.denglu
      options.ranka = Options.ranka
      options.dianzan = Options.dianzan
      options.huozan = Options.huozan
      options.fenxiang = Options.fenxiang
      options.yaoqing = Options.yaoqing
    }

  })

})