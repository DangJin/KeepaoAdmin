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

require(['jquery', 'F', 'store', 'wx'], function ($, F, store, wx) {

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
      city: '',
      lng: '',
      lat: '',
      page: '1',
      limit: '10',
      data: ''
    }

    initDom()

    function getThisCity () {
      F.initJssdk(function (status) {
        if (status) {
          wx.ready(function () {
            wx.getLocation({
              type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
              success: function (res) {
                options.lng = res.longitude
                options.lat = res.latitude
                MapNiShow(res.longitude, res.latitude)
                // var latitude = res.latitude // 纬度，浮点数，范围为90 ~ -90
                // var longitude = res.longitude // 经度，浮点数，范围为180 ~ -180。
                // var speed = res.speed // 速度，以米/每秒计
                // var accuracy = res.accuracy // 位置精度
              }
            })
          })
        }
      })
    }

    function MapNiShow (x, y) {
      AMap.service('AMap.Geocoder', function () {//回调函数
        //实例化Geocoder
        geocoder = new AMap.Geocoder({
          city: '010'//城市，默认：“全国”
        })
        //逆地理编码
        var lnglatXY = [x, y]//地图上所标点的坐标
        geocoder.getAddress(lnglatXY, function (status, result) {
          if (status === 'complete' && result.info === 'OK') {
            console.log(result)
            console.log(result.regeocode.addressComponent.district)
            sessionStorage.setItem('ThisCity', result.regeocode.addressComponent.district)
            options.city = sessionStorage.getItem('ThisCity')
            $('.storeList_topSearch>label>a').text(sessionStorage.getItem('ThisCity'))
            getStoreList()
            //获得了有效的地址信息:
            //即，result.regeocode.formattedAddress
          } else {
            //获取地址失败
          }
        })
        //TODO: 使用geocoder 对象完成相关功能
      })
    }

    // 门店列表
    function getStoreList () {
      store.getStoreList(options, function (res) {
        console.log(res, 'StoreList')
        options.data = res
        F.display('storeList_list', options.data, function () {
          $('.storeList_list>.item>a').click(function () {
            var stoid = $(this).data('stoid')
            location.href = 'storeM.html?stoid=' + stoid
          })
        })
      })
    }

    function initDom () {

      // 查询城市信息，渲染界面
      if (sessionStorage.getItem('City') == null) {
        getThisCity()
      } else {
        options.city = sessionStorage.getItem('City')
        $('.storeList_topSearch>label>a').text(sessionStorage.getItem('City'))
        getStoreList()
      }
    }
  })
})