define(['api'], function (api) {
  const News = api.api.News || ''

  // 消息列表
  var getNewsList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: News.getNewsList,
      data: {
        token: options.token,
        uId: options.uid,
        type: options.type
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

  // 添加留言
  var addLeaveWord = function (options, callback) {
    $.ajax({
      type: 'POST',
      url: News.addLeaveWord,
      data: {
        token: options.token,
        uId: options.uid,
        muid: options.muid,
        body: options.body,
        title: options.title,
        type: options.type
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
    getNewsList: getNewsList,
    addLeaveWord: addLeaveWord
  }
})