<?php

/**
 * 文件说明
 *
 * @filename    Item.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/6/1 0:27
 */
class ItemController extends CommonController {
    private $item_service;

    public function init() {
        parent::init();
        $this->item_service = $this->loadService('Item');
    }


    public function showAction() {
        $item_id   = $this->get('item_id');
        $item_info = $this->item_service->getItemById($item_id);
        if (!$item_info) {
            E('项目错误');
        }

        $this->output_data['nav'] = [
            ['url' => '', 'name' => $item_info['item_name']]
        ];

        $this->output_data['item_info'] = $item_info;
        $this->output_data['item_id']   = $item_id;
        $item_menu_service              = $this->loadService('ItemMenu');
        $this->output_data['limit']     = $item_menu_service->getCountByItemId($item_id);
        $this->display('show', $this->output_data);

        return false;
    }


    public function shareAction(){
        $item_name   = $this->get('item_name');
        $item_info = $this->item_service->getItemByName($item_name);
        if (!$item_info) {
            E('项目错误');
        }

        $this->output_data['nav'] = [
            ['url' => '', 'name' => $item_info['item_name']]
        ];

        $this->output_data['item_info'] = $item_info;
        $this->output_data['item_id']   = $item_info['item_id'];
        $item_menu_service              = $this->loadService('ItemMenu');
        $this->output_data['limit']     = $item_menu_service->getCountByItemId($item_info['item_id']);
        $this->display('show', $this->output_data);

        return false;
    }
    public function getItenMenuAction() {
        $item_id = $this->get('item_id');
        if (!$item_id) {
            $this->error('项目id错误');
        }
        $item_menu_service = $this->loadService('ItemMenu');
        $count             = $item_menu_service->getCountByItemId($item_id);
        $list              = $item_menu_service->getByItemId($item_id);
        $this->ajaxRows($list, $count);
    }

    /**
     * @return array
     */
    public function getMenuByIdAction() {
        $id = $this->get('id');
        if (!$id) {
            $this->error('目录id不能为空');
        }
        $item_menu_service = $this->loadService('ItemMenu');
        $data              = $item_menu_service->getMenuById($id);
        $this->success($data);
    }

    public function addMenuAction() {
        $name              = $this->post('name');
        $order             = $this->post('order');
        $parent_id         = $this->post('parent_id');
        $item_id           = $this->post('item_id');
        $item_menu_service = $this->loadService('ItemMenu');
        $ret               = $item_menu_service->add($item_id, $name, $order, $parent_id);
        if (!$ret['state']) {
            $this->error($ret['message']);
        }
        $this->success([], $ret['message']);
    }

    public function editMenuAction() {
        $id                = $this->post('id');
        $name              = $this->post('name');
        $order             = $this->post('order');
        $parent_id         = $this->post('parent_id');
        $item_id           = $this->post('item_id');
        $item_menu_service = $this->loadService('ItemMenu');
        $ret               = $item_menu_service->edit($id, $item_id, $name, $order, $parent_id);
        if (!$ret['state']) {
            $this->error($ret['message']);
        }
        $this->success([], $ret['message']);
    }

    public function delMenuAction() {
        $ids               = $this->post('ids');
        $item_menu_service = $this->loadService('ItemMenu');
        $ret               = $item_menu_service->del($ids);
        if (!$ret['state']) {
            $this->error($ret['message']);
        }
        $this->success([], $ret['message']);
    }

    public function addPageAction() {
        $item_id = $this->get('item_id');

        $this->output_data['item_id'] = $item_id;
        $this->display('addPage', $this->output_data);

        return false;

    }

    public function getItemUserAction() {
        $item_id = $this->get('item_id');

        $item_member_service = $this->loadService('ItemMember');
        $data                = $item_member_service->getByItemId($item_id,'username');

        $this->success($data);
    }

    public function setItemUserAction() {
        $item_id             = $this->post('item_id');
        $username            = $this->post('username');
        $item_member_service = $this->loadService('ItemMember');
        $ret                 = $item_member_service->setItemUser($item_id, $username);
        if (!$ret['state']) {
            $this->error($ret['message']);
        }
        $this->success([], $ret['message']);
    }
}