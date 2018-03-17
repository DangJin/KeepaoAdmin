define(['api'], function (api) {
  const Coupon = api.api.Coupon || ''

  // 优惠券列表
  var getCouponList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Coupon.getCouponList,
      data: {
        token: options.token,
        uId: options.uid,
        date: options.date
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res.data.list)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }


  return {
    getCouponList: getCouponList
  }
})