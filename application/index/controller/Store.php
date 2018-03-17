<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/9
 * Time: 上午10:40
 */

namespace app\index\controller;

use app\index\model;
use think\Db;
use think\Request;

class Store extends Common {
    /**
     * Function: select
     * Author  : PengZong
     * DateTime: ${DATE} ${TIME}
     *
     * @param   lng   [double]          经度
     * @param   lat   [double]          纬度
     * @param   city  [string]          城市
     * @param   page  [int]             当前页数
     * @param   limit [int]             每页数量
     */
    public function store_select(){
        $store = new model\Store();

        $param = $this->param;

        $keywords = !empty($param['keywords']) ? $param['keywords'] : '';
        $city     = !empty($param['city']) ? $param['city'] : '';
        $lng      = !empty($param['lng']) ? $param['lng'] : '';
        $lat      = !empty($param['lat']) ? $param['lat'] : '';
        $page     = !empty($param['page']) ? $param['page'] : '';
        $limit    = !empty($param['limit']) ? $param['limit'] : '';

        $data = $store->getDataList($keywords,$city,$lng,$lat,$page,$limit);

        if(!$data){
            return result_array(['error' => $store->getError()]);
        }

        return result_array(['data' => $data]);
    }

    /**
     * Function: details
     * Author  : PengZong
     * DateTime: ${DATE} ${TIME}
     *
     * 门店详细信息
     *
     * @param  id   int  门店id
     * @return Json
     */
    public function store_details(){
        $store = new model\Store();

        $param = $this->param;
        $id = !empty($param['id']) ? $param['id'] : '';

        //要显示的字段
        $array = ['stoId','stono','stoname','county','province','city','address','longitude','latitude','isdirect'];

        $data = $store->getDataById($id,$array);

        if (!$data){
            return result_array(['error' => $store->getError()]);
        }

        $config = $store->getStoreConfig($id);      //门店配置
        $devices = $store->getStoreDevices($id);    //门店设备
        $images = $store->getStoreImg($id);         //门店图片
        $stocard = new model\Stocard();
        $cards = $stocard
            ->where('stoId', $id)
            ->alias('a')
            ->join('memcard m', 'a.type=m.memId', 'LEFT')
            ->where('a.state', 1)
            ->field('m.thum')->select();


        if(!$config){$config = '';}
        if(!$devices){$devices = '';}
        if(!$images){$images = '';}

        $data['devices'] = $devices;
        $data['config']  = $config;
        $data['images']  = $images;
        $data['cards']  = $cards;
        return result_array(['data' => $data]);
    }

    public function getCard(Request $request)
    {
        $data = [];

        if ($request->has('stoId', 'param', true)) {
            $data['stoId'] = $request->param('stoId');
        }

        if ($request->has('id', 'param', true)) {
            $data['id'] = $request->param('id');
        }

        $page = $request->has('page', 'param', true) ? $request->param('page') : 1;
        $limit = $request->has('limit', 'param', true) ? $request->param('page') : 10;

        if (empty($data)) {
            return json([
                'code' => 400,
                'error' => '参数不能为空'
            ]);
        }
        $stocard = new model\Stocard();

        return json($stocard->getCard($data, $page, $limit));
    }

    public function getCityList()
    {
        $store = new model\Store();
        return json($store->getCityList());
    }
}