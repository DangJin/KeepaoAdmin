define(function () {

  var root = 'http://kp.codwiki.cn'

  var api = {

    //  个人信息接口
    Mine: {
      getMyVipCard: root + '/index/getvips',
      getMyMessage: root + '/index/user/find',
      getJfHistory: root + '/index/pdetails/select',
      getMyWallet: root + '/index/getMoneydet',
      getGuanzhuList: root + '/index/follow/select',
      addGuanzhu: root + '/index/follow/follow',
      quxiaoGuanzhu: root + '/index/follow/unfollow',
      SignIn: root + '/index/sign',
      getBadgeListFirst: root + '/index/rule/getsport',
      getBadgeListLast: root + '/index/rule/getchram',
      getBadgeM: root + '/index/rule/getdetails'
    },

    // 排行榜接口
    Rank: {
      getRankList: root + '/index/chart/select',
      getMyRank: root + '/index/chart/user',
      rankZan: root + '/index/zan/up'
    },

    // 消息接口
    News: {
      getNewsList: root + '/index/message/select',
      addLeaveWord: root + '/index/message/add'
    },

    // 优惠券接口
    Coupon: {
      getCouponList: root + '/index/coupon/useselect'
    },

    // 常见问题接口
    Question: {
      getQuestionList: root + '/index/getproblem'
    },

    //  门店接口
    Store: {
      getStoreList: root + '/index/store/select',
      getStoreMessage: root + '/index/store/details',
      // 设备信息
      getEquMessage: root + '/index/equipment/select',
      getVipList: root + '/index/getcard',
      getCityList: root + '/index/store/getCityList'
    }

  }
  return {
    api: api
  }
})