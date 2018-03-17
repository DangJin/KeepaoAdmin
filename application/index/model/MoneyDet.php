<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/5
 * Time: 上午10:24
 */

namespace app\index\model;


use think\Model;

class MoneyDet extends Model
{
    protected $pk = 'id';

    protected $createTime = 'createTime';

    protected $updateTime = 'modifyTime';

    public function select($id, $page = 1, $limit = 10)
    {
        $result = $this->table('account_det')->where('useId', $id)->paginate($limit, false, ['page' => $page]);
        $change = $this->table('user')->where('uId', $id)->field('balance')->select();
        return [
            'code' => 200,
            'data' => $result,
            'change' => $change
        ];
    }
}