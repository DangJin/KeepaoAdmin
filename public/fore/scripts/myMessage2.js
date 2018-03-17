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
      myid: '1',
      gid: '1'
    }

    initDom()

    F.wxLogin(function (data) {

      $('#guanzhu').click(function () {
        if ($(this).find('span').text() == '关注') {
          mine.addGuanzhu(options, function (res) {
            $('#guanzhu').find('span').text('已关注')
            console.log(res)
          })
        }
      })
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
    })

    function initDom () {
    }

  })

})