<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/18
 * Time: 上午2:52
 */

namespace app\index\model;


use think\Db;

class PointRuleDet extends Common {
    public $arr = [
        '1',
        '2',
        'day',
        'calorie',
        'week',
        'zan',
        'upZan',
        'share',
        'invite'
    ];
    public function findRule($prid,$condition){
        try{
            $data = $this->field('prdId,prId,condition,reward')->where('prId',$prid)->where('condition',$condition)->find();
            return $data;
        }catch (\Exception $e){
            $this->error = "查询规则失败！";
            return false;
        }
    }

    public function getsport($id)
    {
        $user = User::get($id);
        $data = ['data' => []];
        $data['data']['denglu'] = $this->where('prId', 2)->field('prdId id,level,condition')->select();
        $data['data']['ranka'] = $this->where('prId', 3)->field('prdId id,level,condition')->select();
        $data['data']['dabiao'] = $this->where('prId', 4)->field('prdId id,level,condition')->select();
        $data['data']['code'] = 200;
        $data['count'] = 0;
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 2)
            ->where('condition', '<=', $user->getAttr('day'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 3)
            ->where('condition', '<=', $user->getAttr('calorie'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 4)
            ->where('condition', '<=', $user->getAttr('week'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 5)
            ->where('condition', '<=', $user->getAttr('zan'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 6)
            ->where('condition', '<=', $user->getAttr('upZan'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 7)
            ->where('condition', '<=', $user->getAttr('share'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 8)
            ->where('condition', '<=', $user->getAttr('invite'))
            ->count();
        return $data;
    }

    public function getcharm($id)
    {
        $user = User::get($id);
        $data = ['data' => []];
        $data['data']['huozan'] = $this->where('prId', 5)->field('prdId id,level,condition')->select();
        $data['data']['dianzan'] = $this->where('prId', 6)->field('prdId id,level,condition')->select();
        $data['data']['fenxiang'] = $this->where('prId', 7)->field('prdId id,level,condition')->select();
        $data['data']['yaoqing'] = $this->where('prId', 8)->field('prdId id,level,condition')->select();
        $data['code'] = 200;
        $data['count'] = 0;
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 2)
            ->where('condition', '<=', $user->getAttr('day'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 3)
            ->where('condition', '<=', $user->getAttr('calorie'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 4)
            ->where('condition', '<=', $user->getAttr('week'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 5)
            ->where('condition', '<=', $user->getAttr('zan'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 6)
            ->where('condition', '<=', $user->getAttr('upZan'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 7)
            ->where('condition', '<=', $user->getAttr('share'))
            ->count();
        $data['count'] += Db::table('point_rule_det')
            ->where('prId', 8)
            ->where('condition', '<=', $user->getAttr('invite'))
            ->count();
        return $data;
    }

    public function getdetails($id)
    {
        $data = [];
        $result = $this->alias('a')->where('a.prdId', $id)
            ->join('point_rule pr', 'pr.prId=a.prId', 'LEFT')
            ->field('a.*')->field('pr.name')
            ->find();

        if (is_null($result)) {
            return [
                'code' => 400,
                'error' => '没有此数据'
            ];
        }
        $data['name'] = $result->getAttr('name');
        $data['condition'] = $result->getAttr('condition');
        $data['count'] = $this->table('user')
            ->where($this->arr[$result->getAttr('prId')], '>=', $result->getAttr('condition'))
            ->count();

        return [
            'code' => 200,
            'data' => $data
        ];
    }

    public function level($data)
    {
        if (empty($data['id'])) {
            return [
                'code' => 400,
                'error' => '缺少id'
            ];
        }
        $user = User::get($data['id']);
        if (is_null($user)) {
            return [
                'code' => 400,
                'error' => '没有此用户'
            ];
        }
        $result = $this->where('prId', 1)->select();
        $level = [];
        foreach ($result as $item) {
            $tmp = $item->toArray();
            $tmp['num'] = $this->table('user')->where('exper', '>=', $item->getAttr('condition'))->count();
            array_push($level, $tmp);
        }

        return [
            'code' => 200,
            'data' => $level,
            'name' => $user->getAttr('name'),
            'exper' => $user->getAttr('exper')
        ];
    }
}