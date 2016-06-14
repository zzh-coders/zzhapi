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
}