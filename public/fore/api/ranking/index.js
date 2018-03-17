define(['api', 'F'], function (api, F) {
  const Rank = api.api.Rank || ''

  // 排行榜列表
  var getRankList = function (options, callback) {
    $.ajax({
      type: 'POST',
      url: Rank.getRankList,
      data: {
        token: options.token,
        uid: options.uid,
        sid: options.sid,
        page: options.page,
        limit: options.limit,
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

  // 我的排行
  var getMyRank = function (options, callback) {
    $.ajax({
      type: 'POST',
      url: Rank.getMyRank,
      data: {
        token: options.token,
        uid: options.uid,
        sid: options.sid,
        date: options.date
      },
      dataType: 'json',
      success: function (res) {
        console.log(res)
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

  // 点赞
  var rankZan = function (options, callback) {
    $.ajax({
      type: 'get',
      url: Rank.rankZan,
      data: {
        token: options.token,
        uId: options.uId,
        spoId: options.spoId
      },
      dataType: 'json',
      success: function (res) {
        console.log(res)
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
    getRankList: getRankList,
    getMyRank: getMyRank,
    rankZan: rankZan
  }
})