define(['api'], function (api) {
  const Store = api.api.Store || ''

  // 城市列表
  var getCityList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Store.getCityList,
      data: {
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res.data)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  // 门店详情
  var getStoreMessage = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Store.getStoreMessage,
      data: {
        token: options.token,
        id: options.id
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res.data)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  // 门店列表
  var getStoreList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Store.getStoreList,
      data: {
        token: options.token,
        keywords: options.keywords,
        lng: options.lng,
        lat: options.lat,
        city: options.city,
        page: options.page,
        limit: options.limit
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

  // 设备信息
  var getEquMessage = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Store.getEquMessage,
      data: {
        token: options.token,
        type: options.type,
        equId: options.equid
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

  // 会员卡列表
  var getVipList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Store.getVipList,
      data: {
        token: options.token,
        stoId: options.stoid,
        page: options.page,
        limit: options.limit
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res.data.data)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  return {
    getStoreMessage: getStoreMessage,
    getStoreList: getStoreList,
    getEquMessage: getEquMessage,
    getVipList: getVipList,
    getCityList: getCityList
  }
})