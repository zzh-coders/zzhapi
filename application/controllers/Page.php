<?php

/**
 * 文件说明
 *
 * @filename    Page.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/6/10 11:24
 */
class PageController extends CommonController {
    private $page_service;

    public function init() {
        parent::init();
        $this->page_service = $this->loadService('Page');
    }

    public function showAction() {
        $page_id = $this->get('page_id');
        if (!$page_id) {
            $this->error('页面id错误');
        }
        $page_info = $this->page_service->getPageById($page_id);
        Yaf\Loader::import('Parsedown.class.php');
        $Parsedown                      = new Parsedown();
        $page_info['page_content']      = $Parsedown->text(htmlspecialchars_decode($page_info['page_content']));
        $this->output_data['page_info'] = $page_info;
        $this->display('show', $this->output_data);

        return false;
    }

    public function addAction() {
        if (IS_AJAX) {
            $item_id      = $this->post('item_id');
            $page_title   = $this->post('page_title');
            $page_content = htmlspecialchars($this->post('page_content',false));
            $s_number     = $this->post('s_number');
            $cat_id       = $this->post('cat_id');
            $page_service = $this->loadService('Page');
            $ret          = $page_service->add($item_id, $page_title, $page_content, $s_number, $cat_id, $this->userinfo);
            if (!$ret['state']) {
                $this->error($ret['message']);
            }
            $this->success([], $ret['message'], base_url('Page/show',['page_id'=>$ret['extra']['page_id'],'item_id'=>$item_id]));
        } else {
            $item_id = $this->get('item_id');
            if (!$item_id) {
                $this->error('项目id错误');
            }
            $this->output_data['item_id'] = $item_id;
            $this->output_data['action']  = base_url('Page/add');
            $this->display('add', $this->output_data);

            return false;
        }
    }

    public function copyAction() {
        if (IS_AJAX) {
            $item_id      = $this->post('item_id');
            $page_title   = $this->post('page_title');
            $page_content = htmlspecialchars($this->post('page_content',false));
            $s_number     = $this->post('s_number');
            $cat_id       = $this->post('cat_id');
            $page_service = $this->loadService('Page');
            $ret          = $page_service->add($item_id, $page_title, $page_content, $s_number, $cat_id, $this->userinfo);
            if (!$ret['state']) {
                $this->error($ret['message']);
            }
            $this->success([], $ret['message'], base_url('Page/show',['page_id'=>$ret['extra']['page_id'],'item_id'=>$item_id]));
        } else {
            $page_id = $this->get('page_id');
            if (!$page_id) {
                $this->error('页面id错误');
            }
            $page_info                      = $this->page_service->getPageById($page_id);
            $page_info['page_title']        = $page_info['page_title'] . '-复制';
            $page_info['order']             = 99;
            $this->output_data['page_info'] = $page_info;
            $this->output_data['item_id']   = $page_info['item_id'];
            $this->output_data['action']    = base_url('Page/add');
            $this->display('add', $this->output_data);

            return false;
        }
    }

    public function editAction() {
        if (IS_AJAX) {
            $page_id      = $this->post('page_id');
            $item_id      = $this->post('item_id');
            $page_title   = $this->post('page_title');
            $page_content = htmlspecialchars($this->post('page_content',false));
            $s_number     = $this->post('s_number');
            $cat_id       = $this->post('cat_id');
            $page_service = $this->loadService('Page');
            $ret          = $page_service->edit($page_id, $item_id, $page_title, $page_content, $s_number, $cat_id, $this->userinfo);
            if (!$ret['state']) {
                $this->error($ret['message']);
            }
            $this->success([], $ret['message'], base_url('Page/show',['page_id'=>$ret['extra']['page_id'],'item_id'=>$item_id]));
        } else {
            $page_id = $this->get('page_id');
            if (!$page_id) {
                $this->error('页面id错误');
            }
            $page_info                      = $this->page_service->getPageById($page_id);
            $this->output_data['page_info'] = $page_info;
            $this->output_data['item_id']   = $page_info['item_id'];
            $this->output_data['action']    = base_url('Page/edit');
            $this->display('add', $this->output_data);

            return false;
        }
    }

    public function delAction() {
        $page_id = $this->get('page_id');
        if (!$page_id) {
            $this->error('页面id错误');
        }
        $ret = $this->page_service->del($page_id);
        if ($ret['state']) {
            $this->success([], $ret['message']);
        }
        $this->error($ret['message']);
    }

    public function shareAction(){
        $page_id = $this->get('page_id');
        if (!$page_id) {
            $this->error('页面id错误');
        }
        $page_info = $this->page_service->getPageById($page_id);
        Yaf\Loader::import('Parsedown.class.php');
        $Parsedown                      = new Parsedown();
        $page_info['page_content']      = $Parsedown->text(htmlspecialchars_decode($page_info['page_content']));
        $this->output_data['page_info'] = $page_info;
        $this->display('show', $this->output_data);

        return false;
    }
}