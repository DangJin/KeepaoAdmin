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

require(['jquery', 'F', 'store'], function ($, F, store) {

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
      city: '廊坊市',
      lng: '116.80515',
      lat: '39.962444',
      page: '1',
      limit: '10',
      positions: []
    }

    initDom()

    // 门店列表
    function getStoreList () {
      store.getStoreList(options, function (res) {
        console.log(res, 'StoreList')
        options.positions = []
        for (var i = 0; i < res.length; i++) {
          options.positions[i] = {
            x: res[i].longitude,
            y: res[i].latitude,
            stoId: res[i].stoId,
            stoname: res[i].stoname,
            address: res[i].address
          }
        }
        storeMapList(options.positions)
      })
    }

    // 绘制门店列表
    function storeMapList (positions) {

      var map, geolocation
      //    地图初始化
      map = new AMap.Map('container', {
        resizeEnable: true,
        zoom: 12,
        center: [116.481181, 39.989792]
      })

      //    加载地图，调用浏览器定位服务
      map.plugin('AMap.Geolocation', function () {
        geolocation = new AMap.Geolocation({
          enableHighAccuracy: true,//是否使用高精度定位，默认:true
          timeout: 10000,          //超过10秒后停止定位，默认：无穷大
          buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
          zoomToAccuracy: true,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
          buttonPosition: 'RB'
        })
        map.addControl(geolocation)
        geolocation.getCurrentPosition()
        AMap.event.addListener(geolocation, 'complete', onComplete)//返回定位信息
        AMap.event.addListener(geolocation, 'error', onError)      //返回定位出错信息
      })

      //添加marker标记
      map.clearMap()
      var markers = new Array
      for (var i = 0; i < positions.length; i++) {
        markers[i] = new AMap.Marker({
          id: i,
          map: map,
          position: [positions[i].x, positions[i].y]
        })

//        //鼠标点击marker弹出自定义的信息窗体
        AMap.event.addListener(markers[i], 'click', function (e) {
          console.log(e.target.F.id)
          // $('.InfoWindow>.headImg').attr('href', positions[e.target.F.id].img)
          $('.InfoWindow>.content>h5').text(positions[e.target.F.id].stoname)
          $('.InfoWindow>.content>p').text('地址：' + positions[e.target.F.id].address)
          $('.InfoWindow>.content>a').attr('href', 'storeM.html?stoid=' + positions[e.target.F.id].stoId)
          $('.InfoWindow').css('display', 'block')
        })
      }

      //关闭信息窗体
      $('.InfoWindow>.back').click(function () {
        $('.InfoWindow').css('display', 'none')
      })
    }

    //解析定位结果
    function onComplete (data) {
      var str = ['定位成功']
      str.push('经度：' + data.position.getLng())
      str.push('纬度：' + data.position.getLat())
      if (data.accuracy) {
        str.push('精度：' + data.accuracy + ' 米')
      }//如为IP精确定位结果则没有精度信息
      str.push('是否经过偏移：' + (data.isConverted ? '是' : '否'))
      document.getElementById('tip').innerHTML = str.join('<br>')
    }

    //解析定位错误信息
    function onError (data) {
      document.getElementById('tip').innerHTML = '定位失败'
    }

    function initDom () {
      getStoreList()
    }
  })
})