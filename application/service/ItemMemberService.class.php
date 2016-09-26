<?php
/**
 * 简述
 *
 * 详细说明(可略)
 *
 * @copyright Copyright&copy; 2016, Meizu.com
 * @author   zouzehua <zouzehua@meizu.com>
 * @version $Id: ItemMemberService.class.php, v ${VERSION} 2016-9-23 16:21 Exp $
 */

namespace Yboard;


class ItemMemberService extends CommonService {

    public function getByItemId($item_id, $filed = null) {
        if (!$item_id) {
            return $this->returnInfo(0, '项目id不能为空');
        }
        $model = $this->loadModel('ItemMember');

        $data                   = $model->getByItemId($item_id);
        $result_data['item_id'] = $item_id;
        if ($filed && $data) {
            $username            = array_column($data, $filed);
            $result_data[$filed] = implode(',', $username);

            return $result_data;
        }

        $result_data['data'] = $data;

        return $result_data;
    }

    public function setItemUser($item_id, $username) {
        if (!$item_id) {
            return $this->returnInfo(0, '项目id不能为空');
        }
        $model = $this->loadModel('ItemMember');
        $model->deleteByItemId($item_id);
        //去重复
        if ($username) {
            $username_array = explode(',', $username);
            $username_array = array_unique($username_array);
            foreach ($username_array as $value) {
                $data = [
                    'item_id'     => $item_id,
                    'username'    => $value,
                    'create_time' => NOW_TIME
                ];
                $model->save($data);
            }
        }

        return $this->returnInfo(1, '项目成员指派成功');

    }

    public function getItemByUserName($username) {
        if (!$username) {
            return null;
        }
        $model       = $this->loadModel('ItemMember');
        $data        = $model->getItemByUserName($username);
        $result_data = ['item_ids' => [], 'username' => $username];
        if ($data) {
            $result_data = [
                'item_ids' => array_column($data, 'item_id'),
                'username' => $username
            ];
        }

        return $result_data;
    }
}