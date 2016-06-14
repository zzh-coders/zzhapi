<?php
/**
 * 文件说明
 *
 * @filename    ItemMemberModel.class.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/5/31 23:11
 */

namespace Yboard;


class ItemMemberModel extends CommonModel {

    public function __construct($options = null) {
        $this->_table = 'item_member';
        $this->_pk    = 'item_member_id';
        parent::__construct($options);
    }

    public function deleteByItemId($item_id) {
        if (!$item_id) {
            return false;
        }

        return $this->delete($this->_table, ['item_id' => $item_id]);
    }

}