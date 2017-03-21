<?php

namespace Yboard;


class ItemModel extends CommonModel {

    public function __construct() {
        $this->_table = 'item';
        $this->_pk    = 'item_id';
        parent::__construct();
    }

    public function getInfoByItemName($item_name) {
        $result_data = [];
        if (!$item_name) {
            return $result_data;
        }

        $result_data = $this->get($this->_table, '*', ['item_name' => $item_name]);

        return $result_data;
    }

    public function getInfoByUid($uid) {
        $result_data = [];
        if (!$uid) {
            return $result_data;
        }

        $result_data = $this->select($this->_table, '*', ['uid' => $uid]);

        return $result_data;
    }

    public function getList($params, $page, $limit, $field) {
        $params = $params ? $params : [];
        $where  = array_merge(
            $params,
            [
                'ORDER' => 'create_time DESC',
                'LIMIT' => [(int)$limit, (int)$page]
            ]
        );
        $result = $this->select($this->_table, $field ? $field : '*', $where);

        return $result;
    }
}