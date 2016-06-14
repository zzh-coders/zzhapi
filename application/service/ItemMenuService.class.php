<?php
/**
 * 文件说明
 *
 * @filename    ItemMenuService.class.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/6/2 22:06
 */

namespace Yboard;


class ItemMenuService extends CommonService {
    private $menu_model;

    public function __construct() {
        $this->menu_model = $this->loadModel('Menu');
    }

    public function getMenuByItemId($item_id) {
        $item_menu  = $this->menu_model->getByItemId($item_id);
        $page_model = $this->loadModel('Page');
        $page_menu  = $page_model->getPageByItemId($item_id);

        $data = [];
        foreach ($item_menu as $item => $value) {
            $data[] = [
                'parent_id' => $value['parent_id'],
                'type'      => 'menu',
                'name'      => $value['name'],
                'id'        => $value['id']
            ];
        }

        foreach ($page_menu as $item => $value) {
            $data[] = [
                'parent_id' => $value['cat_id'],
                'type'      => 'page',
                'name'      => $value['page_title'],
                'id'        => $value['page_id']
            ];
        }

        $result_data = $this->_getMenuTree($data, 0, $item_id);

        return $result_data;
    }

    private function _getMenuTree(&$data, $parent_id, $item_id) {
        $result_data = [];
        if ($data) {
            foreach ($data as $k => $v) {
                if ($v['parent_id'] == $parent_id) {
                    $result_data[] = [
                        'url'  => ($v['type'] == 'page') ? base_url('pages/' . $v['id'] . '/' . $item_id) : 'javascript:;',
                        'name' => $v['name'],
                        'icon' => 'cogs',
                        'subs' => ($v['type'] == 'page') ? [] : $this->_getMenuTree($data, $v['id'], $item_id)
                    ];
                }
            }
        }

        return $result_data;
    }

    public function getByItemId($item_id) {
        $item_menu   = $this->menu_model->getByItemId($item_id);
        $result_data = [];
        $this->_getTree($item_menu, 0, $result_data);

        return $result_data;
    }

    private function _getTree($data, $parent_id, &$result_data) {
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $parent_id) {
                $result_data[] = [
                    'id'        => $v['id'],
                    'order'     => $v['order'],
                    'name'      => (($parent_id == 0) ? '' : '&nbsp;|-') . $v['name'],
                    'parent_id' => $v['parent_id'],
                    'level'     => $v['level']
                ];
                $this->_getTree($data, $v['id'], $result_data);
            }
        }
    }

    public function getCountByItemId($item_id) {
        return $this->menu_model->countByParams(['item_id' => $item_id]);
    }

    public function del($ids) {
        if (!$ids) {
            return $this->returnInfo(0, '未选择ids');
        }
        $ret = $this->menu_model->deleteByIds($ids);
        if ($ret !== false) {
            return $this->returnInfo(1, '目录删除成功');
        }

        return $this->returnInfo(0, '系统错误');
    }

    public function add($item_id, $name, $order, $parent_id) {
        if (!$name) {
            return $this->returnInfo(0, '请输入名称');
        }
        if (!$item_id) {
            return $this->returnInfo(0, '项目不正确');
        }
        $data['name']    = $name;
        $data['item_id'] = $item_id;
        if (!$order) {
            $order = 99;
        }
        if (!$parent_id) {
            $parent_id = 0;
        }
        $data['order']       = $order;
        $data['parent_id']   = $parent_id;
        $data['create_time'] = NOW_TIME;
        $ret                 = $this->menu_model->save($data);
        if ($ret !== false) {
            return $this->returnInfo(1, '目录添加成功');
        }

        return $this->returnInfo(0, '系统错误');
    }

    public function edit($id, $item_id, $name, $order, $parent_id) {
        if (!$name) {
            return $this->returnInfo(0, '请输入名称');
        }
        if (!$id) {
            return $this->returnInfo(0, '未选择id');
        }
        if (!$item_id) {
            return $this->returnInfo(0, '项目不正确');
        }
        $data['item_id'] = $item_id;
        $data['name']    = $name;
        if (!$order) {
            $order = 99;
        }
        if (!$parent_id) {
            $parent_id = 0;
        }
        $data['order']     = $order;
        $data['parent_id'] = $parent_id;
        $ret               = $this->menu_model->updateById($id, $data);
        if ($ret !== false) {
            return $this->returnInfo(1, '目录编辑成功');
        }

        return $this->returnInfo(0, '系统错误');
    }

    public function getMenuById($id) {
        return $this->menu_model->getById($id);
    }

    public function getMenuByParentId($parent_id) {
        return $this->menu_model->getMenuByParentId($parent_id);
    }
}