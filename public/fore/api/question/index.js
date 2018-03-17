define(['api'], function (api) {
  const Question = api.api.Question || ''

  // 获取常见问题
  var getQuestionList = function (options, callback) {
    $.ajax({
      type: 'GET',
      url: Question.getQuestionList,
      data: {
        token: options.token,
        id: options.id,
        name: options.name,
        page: options.page,
        limit: options.limit
      },
      dataType: 'json',
      success: function (res) {
        if (res.code === '200') {
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
    getQuestionList: getQuestionList
  }
})