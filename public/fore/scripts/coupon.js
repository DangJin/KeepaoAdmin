require.config({
  paths: {
    'jquery': '../js/jquery.2.1.1min',
    'F': '../js/function',
    'template': '../js/template-web',
    'api': '../api/index',
    'wx': '../js/jweixin',
    'Coupon': '../api/Coupon/index'
  }
});

require(["jquery", "F",'Coupon'], function ($, F, Coupon) {

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
      uid: '',
      date: ''
    };

    initDom()

    F.wxLogin(function (data) {
      options.uid = data.uid
      getCouponList()
    })


    // 优惠券列表
    function getCouponList () {
      Coupon.getCouponList(options, function (res) {
        console.log(res)
        F.display('content', res)
      })
    }


    function initDom () {
      var myDate = new Date()
      var ThisDate = myDate.getFullYear() + '-' + (myDate.getMonth() + 1) + '-' + myDate.getDate()
      ThisDate = '2018-1-11'
      options.date = ThisDate
      options.uid = F.getUrlParams('uid')
    }

  });


});