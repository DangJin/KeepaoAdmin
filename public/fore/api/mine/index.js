define(['api'], function (api) {
  const Mine = api.api.Mine || ''

  // 我的会员
  var getMyVipCard = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getMyVipCard,
      data: {
        token: options.token,
        uid: options.uid,
        page: options.page,
        limit: options.limit
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

  // 个人中心
  var getMyMessage = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getMyMessage,
      data: {
        token: options.token,
        uid: options.uid
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

  // 我的关注/粉丝
  var getGuanzhuList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getGuanzhuList,
      data: {
        token: options.token,
        id: options.id,
        type: options.type,
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

  // 关注
  var addGuanzhu = function (options, callback) {
    $.ajax({
      type: 'POST',
      url: Mine.addGuanzhu,
      data: {
        token: options.token,
        myid: options.myid,
        gid: options.gid
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

  // 取消关注
  var quxiaoGuanzhu = function (options, callback) {
    $.ajax({
      type: 'POST',
      url: Mine.quxiaoGuanzhu,
      data: {
        token: options.token,
        myid: options.myid,
        gid: options.gid
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

  // 积分明细
  var getJfHistory = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getJfHistory,
      data: {
        token: options.token,
        id: options.id,
        page: options.page,
        limit: options.limit
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  // 零钱明细
  var getMyWallet = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getMyWallet,
      data: {
        token: options.token,
        id: options.id,
        page: options.page,
        limit: options.limit
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  // 签到
  var SignIn = function (options, callback) {
    $.ajax({
      type: 'POST',
      url: Mine.SignIn,
      data: {
        token: options.token,
        uId: options.id
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

  // 成就勋章列表1
  var getBadgeListFirst = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getBadgeListFirst,
      data: {
        id: options.uid
      },
      dataType: 'json',
      success: function (res) {
        if (res.data.code === 200) {
          callback.call(this, res)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  // 成就勋章列表2
  var getBadgeListLast = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getBadgeListLast,
      data: {
        id: options.uid
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === 200) {
          callback.call(this, res)
        } else {
          callback.call(this, res.message)
        }
      }, error: function (res) {
        throw new Error(res)
      }
    })
  }

  // 成就勋章详情
  var getBadgeM = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Mine.getBadgeM,
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

  return {
    getMyVipCard: getMyVipCard,
    getMyMessage: getMyMessage,
    getGuanzhuList: getGuanzhuList,
    addGuanzhu: addGuanzhu,
    quxiaoGuanzhu: quxiaoGuanzhu,
    getJfHistory: getJfHistory,
    getMyWallet: getMyWallet,
    SignIn: SignIn,
    getBadgeListFirst: getBadgeListFirst,
    getBadgeListLast: getBadgeListLast,
    getBadgeM: getBadgeM
  }
})