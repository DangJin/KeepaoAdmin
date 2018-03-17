require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'echarts': '../js/echarts.common.min',
    'F': '../js/function',
    'template': '../js/template-web',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'mine': '../api/mine/index'
  }
})

require(['jquery', 'F', 'mine', 'echarts'], function ($, F, mine, echarts) {

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
      date: ''
    }

    initDom()

    F.wxLogin(function (data) {
      options.uid = data.uid
      mine.getMyMessage(options, function (res) {
        console.log(res)
        F.display('myMessage', res, function () {
          $('#myBadgeM').click(function () {
            var MyBadge = {
              uid: res.uId,
              headimg: res.heading,
              name: res.name,
              dabiao: res.dabiao[0].level,
              denglu: res.denglu[0].level,
              ranka: res.ranka[0].level,
              dianzan: res.dianzan[0].level,
              huozan: res.huozan[0].level,
              fenxiang: res.fenxaing[0].level,
              yaoqing: res.yaoqing[0].level
            }
            sessionStorage.setItem('ToMyBadge', JSON.stringify(MyBadge))
            location.href = 'myBadge.html'
          })
          AddEcharts()
        })
      })
    })

    // 渲染图表
    function AddEcharts () {
      // 基于准备好的dom，初始化echarts实例
      var myChart = echarts.init(document.getElementById('main'))

      // 指定图表的配置项和数据
      var option = {
        xAxis: {
          type: 'category',
          boundaryGap: false,
          data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: [80, 92, 91, 94, 124, 134, 120],
          type: 'line',
          color: 'rgb(70,184,124)',
          areaStyle: {}
        }]
      }

      // 使用刚指定的配置项和数据显示图表。
      myChart.setOption(option)
    }

    function initDom () {
    }

  })
})