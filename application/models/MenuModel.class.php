<?php
/**
 * 文件说明
 *
 * @filename    MenuModel.class.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/6/2 22:08
 */

namespace Yboard;


class MenuModel extends CommonModel {

    public function __construct() {
        $this->_table = 'menu';
        $this->_pk    = 'id';
        parent::__construct();
    }

    public function getByItemId($item_id, $parent_id = 0) {
        $where = [
            'item_id' => $item_id,
            'ORDER'   => 'order ASC'
        ];

        return $this->select($this->_table, '*', $where);
    }

    public function getMenuByParentId($item_id, $parent_id = 0) {
        $where = [
            'item_id'   => $item_id,
            'parent_id' => $parent_id,
            'ORDER'     => 'order ASC'
        ];

        return $this->select($this->_table, '*', $where);
    }
}