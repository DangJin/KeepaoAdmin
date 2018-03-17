require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'F': '../js/function',
    'template': '../js/template-web',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'rank': '../api/ranking/index'
  }
})

require(['jquery', 'rank', 'F'], function ($, rank, F) {

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
      sid: '1',
      page: '1',
      limit: '10',
      date: '',
      isLike: {
        token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtc2twIiwiYXVkIjoibG9jYWxob3N0Ojg4ODgiLCJhSWQiOiJvc0ZqRnVIeWd3elNDdUlZRlV1SEk5MnFNTjhNIiwiaWF0IjoxNTE2ODEyNTUxLCJleHAiOjE1MTc0MTczNTEsInBzZCI6IiJ9.-GjpocYuDUcYnekrn0LL-t7XPq84FWWpQvJBJcEdZTU',
        uId: '1',
        spoId: ''
      }
    }

    initDom()

    // 我的排名
    rank.getMyRank(options, function (res) {
      console.log(res, 'myRank')
      F.display('ranking_content_title', res)
    })

    // 排行榜列表
    rank.getRankList(options, function (res) {
      console.log(res, 'rankList')
      F.display('ranking_content_list', res, function () {
        $('.like').click(function () {
          if ($(this).find('img').attr('src') === 'image/like2.png') {
            options.isLike.spoId = '' + $(this).data('spoid')
            var that = $(this)
            console.log(options.isLike)
            rank.rankZan(options.isLike, function (res) {
              that.find('img').attr('src', 'image/like1.png')
              that.find('span').text(parseInt(that.find('span').text()) + 1)
            })
          }
        })
      })
    })

    $('.ranking_select>ul>li').click(function () {
      var that = $(this)
      if ($(this).attr('class') !== 'active') {
        $('.ranking_select>ul>li').last().css({
          'width': '0',
          'height': '0',
          'top': '13px',
          'left': '90px'
        })
        setTimeout(function () {
          that.siblings().removeClass('active')
          that.addClass('active')
          $('.ranking_select>ul>li').last().css({
            'width': '105px',
            'height': '26px',
            'top': '0',
            'left': that.css('left')
          })
        }, 50)
      }
    })

    function initDom () {
      var myDate = new Date()
      var ThisDate = myDate.getFullYear() + '-' + (myDate.getMonth() + 1) + '-' + myDate.getDate()
      ThisDate = '2018-1-11'
      options.date = ThisDate
    }

  })

})