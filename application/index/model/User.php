<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/10
 * Time: 下午3:49
 */
namespace app\index\model;


use think\Db;
use think\Request;

class User extends Common {
    protected $pk = 'uId';

    public function addUser($param){
        if ($this->findUser($param) != null) {
            $this->error = '用户已存在！';
            return false;
        }

        $param['point']     = 0;     //积分
        $param['zan']       = 0;     //获赞
        $param['upZan']     = 0;     //点赞
        $param['isDeposit'] = 0;     //是否缴纳押金
        $param['balance']   = 0;     //余额
        $param['isOpenMes'] = 1;     //是否开启留言
        $param['state']     = 1;     //状态正常

        $data = $this->createData($param);

        return $data;
    }

    public function findUser($param) {
        if (isset($param['openId'])) {
            $result = $this->where('openId', $param['openId'])->find();
        } else if (isset($param['uid'])) {
            $sign = new Sign;
            if (!$sign->findDay($param['uid'], 'yesterday')) {
                $this->where('uId', $param['uid'])->update(['day' => 0]);
            }
            $result = $this->where('uId', $param['uid'])->find();
        } else if (isset($param['phone'])) {
            $result = $this->where('phone', $param['phone'])->find();
        } else {
            return false;
        }

        if (!empty($result)) {
            if (!empty($param['myid'])) {
                $data['hasFollow'] = Follow::where('uid', $param['uid'])->where('createUser', $param['myid'])->count();
            }
            $data = $this->getlevel($result);
            $data = array_merge($data, $result->toArray());
            $data['guanzhu'] = $this->table('follow')->where('createUser', $result->getAttr('uId'))->count();
            $data['fensi'] = $this->table('follow')->where('uid', $result->getAttr('uId'))->count();
            return $data;
        } else {
            return false;
        }

    }

    public function getlevel(User $user)
    {
        $data = [];

         $tmp = Db::table('point_rule_det')
            ->where('prId', 1)
            ->where('condition', '>', $user->getAttr('exper'))
            ->field('level,condition')
            ->limit(1)
            ->order('condition')
            ->select();
        if (empty($tmp)) {
            $data['dengji'][1] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['dengji'][1] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 1)
            ->where('condition', '<=', $user->getAttr('exper'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['dengji'][0] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['dengji'][0] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 2)
            ->where('condition', '<=', $user->getAttr('day'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['denglu'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['denglu'] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 3)
            ->where('condition', '<=', $user->getAttr('calorie'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['ranka'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['ranka'] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 4)
            ->where('condition', '<=', $user->getAttr('week'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['dabiao'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['dabiao'] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 5)
            ->where('condition', '<=', $user->getAttr('zan'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['huozan'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['huozan'] = $tmp;
        }


        $tmp = Db::table('point_rule_det')
            ->where('prId', 6)
            ->where('condition', '<=', $user->getAttr('upZan'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['dianzan'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['dianzan'] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 7)
            ->where('condition', '<=', $user->getAttr('share'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['fenxaing'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['fenxaing'] = $tmp;
        }

        $tmp = Db::table('point_rule_det')
            ->where('prId', 8)
            ->where('condition', '<=', $user->getAttr('invite'))
            ->field('level,condition')
            ->limit(1)
            ->order('\'condition\' desc')
            ->select();
        if (empty($tmp)) {
            $data['yaoqing'] = [
                [
                    'level' => 0,
                    'condition' => 0
                ]
            ];
        } else {
            $data['yaoqing'] = $tmp;
        }

        return $data;
    }


}