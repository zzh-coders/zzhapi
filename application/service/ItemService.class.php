<?php

namespace Yboard;


class ItemService extends CommonService {

    public function getList($params, $limit = 0, $page = 20) {
        $params     = $this->parseParams($params);
        $item_model = $this->loadModel('Item');
        $data       = $item_model->getList($params, $limit, $page);
        foreach ($data as $k => $v) {
            $data[$k]['create_time'] = date('Y-m-d H:i', $v['create_time']);
        }

        return $data;
    }

    public function add($uid, $item_name, $item_description) {
        if (!$uid) {
            return $this->returnInfo(0, '用户id为空');
        }
        if (!$item_name) {
            return $this->returnInfo(0, '项目名称为空');
        }

        $item_model = $this->loadModel('Item');

        if ($item_model->getInfoByItemName($item_name)) {
            return $this->returnInfo(0, '项目已经存在');
        }

        $data = array(
            'item_name'        => $item_name,
            'item_description' => $item_description,
            'uid'              => $uid,
            'create_time'      => NOW_TIME
        );
        if ($item_id = $item_model->save($data)) {
            $item_member_model = $this->loadModel('ItemMember');
            $item_member_model->save([
                'item_id'     => $item_id,
                'uid'         => $uid,
                'create_time' => NOW_TIME
            ]);

            return $this->returnInfo(1, '项目添加成功');
        }

        return $this->returnInfo();
    }

    public function edit($item_id, $uid, $item_name, $item_description) {
        if (!$item_id) {
            return $this->returnInfo(0, '项目id为空');
        }
        if (!$uid) {
            return $this->returnInfo(0, '用户id为空');
        }
        if (!$item_name) {
            return $this->returnInfo(0, '项目名称为空');
        }

        $item_model = $this->loadModel('Item');

        $item_info = $item_model->getInfoByItemName($item_name);
        if ($item_info && $item_info['item_id'] != $item_id) {
            return $this->returnInfo(0, '项目已经存在');
        }

        $data = array(
            'item_name'        => $item_name,
            'item_description' => $item_description,
            'uid'              => $uid,
            'create_time'      => NOW_TIME
        );
        if ($item_model->updateById($item_id, $data)) {
            return $this->returnInfo(1, '项目编辑成功');
        }

        return $this->returnInfo();
    }


    public function del($item_ids) {
        if (!$item_ids) {
            return $this->returnInfo(0, '请选择项目id');
        }
        $item_model = $this->loadModel('Item');

        if ($item_model->deleteByIds($item_ids) !== false) {
            $item_member_model = $this->loadModel('ItemMember');
            $item_member_model->deleteByItemId($item_ids);

            return $this->returnInfo(1, '项目删除成功');
        }

        return $this->returnInfo();
    }

    public function count($params = null) {
        $params     = $this->parseParams($params);
        $item_model = $this->loadModel('Item');

        return $item_model->countByParams($params);
    }

    public function isMeItem($uid, $item_id) {
        if (!$item_id) {
            return false;
        }

        $item_info = $this->getItemById($item_id);

        return $uid == $item_info['uid'];
    }

    public function getItemById($item_id) {
        $item_model = $this->loadModel('Item');

        return $item_model->getById($item_id);
    }

    public function getItemByName($item_name){
        $item_model = $this->loadModel('Item');

        return $item_model->getInfoByItemName($item_name);
    }
}