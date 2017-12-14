<?php
/**
 * 文件说明
 *
 * @filename    PageModel.class.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/6/10 11:32
 */

namespace Yboard;


class PageModel extends CommonModel {
    public function __construct() {
        $this->_table = 'page';
        $this->_pk    = 'page_id';
        parent::__construct();
    }

    public function getPageByItemId($item_id) {
        $where = [
            'item_id' => $item_id,
            'ORDER'   => 'order ASC'
        ];

        return $this->select($this->_table, '*', $where);
    }

    public function getInfoByIdAndName($item_id, $name) {
        $where = [
            'item_id' => $item_id,
            "OR"      => [
                "page_title[~]" => $name,
                "page_desc[~]"  => $name,
            ],
            'ORDER'   => 'order ASC'
        ];

        return $this->select($this->_table, '*', $where);
    }

    public function getInfoIsDescNull() {
        $where = [
            'page_desc' => '',
            'ORDER'     => 'order ASC',
            'LIMIT'     => [0, 200]
        ];

        return $this->select($this->_table, '*', $where);
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

    public function getCount($params) {
        $params = $params ? $params : [];
        $count  = $this->count($this->_table, $params);

        return $count;
    }
}