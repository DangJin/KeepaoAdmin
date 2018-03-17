<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/3
 * Time: 下午9:00
 */

namespace app\index\model;


use think\Model;

class Follow extends Model
{
    protected $updateTime = 'modifyTime';

    protected $createTime = 'createTime';

    public function follow($data)
    {
        if (session('uid') == $data['createUser']) {
            return [
                'code' => 400,
                'error' => '不能关注自己'
            ];
        }

        $follow = $this->where('uid', $data['uid'])->where('createUser', $data['createUser'])->select();
        if (!empty($follow)) {
            return [
                'code' => 400,
                'error' => '已关注'
            ];
        }
        $result = $this->allowField(true)->validate(true)->save($data);

        if (false == $result) {
            return [
                'code' => 400,
                'error' => $this->getError()
            ];
        }

        return [
            'code' => 200,
            'data' => '关注成功'
        ];
    }

    public function select($id, $type, $page , $limit)
    {
        $follow = new Follow;
        $follow = $follow->alias('f');
        if ($type == 1) {
            $follow = $follow
                ->join('user u', 'u.uid=f.uid', 'LEFT')
                ->field('f.createUser myid, f.uid gid')
                ->where('f.createUser', $id);
        }

        if ($type == 2) {
            $follow = $follow
                ->join('user u', 'u.uid=f.createUser', 'LEFT')
                ->field('f.createUser gid, f.uid myid')
                ->where('f.uid', $id);
        }

        $follow = $follow
            ->field('u.heading,u.name,u.level')
            ->paginate($limit, false, ['page' => $page]);

        return [
            'code' => 200,
            'data' => $follow
        ];
    }

    public function unfollow($myid, $gid) {
        $follow = $this->where('createUser', $myid)->where('uid', $gid)->find();
        $follow->delete();
        return [
            'code' => 200,
            'data' => '取关成功'
        ];
    }

}