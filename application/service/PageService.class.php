<?php
/**
 * 文件说明
 *
 * @filename    PageService.class.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2016/6/10 11:31
 */

namespace Yboard;


class PageService extends CommonService {

    public function getPageById($page_id) {
        $page_model = $this->loadModel('Page');

        return $page_model->getById($page_id);
    }

    public function del($page_id) {
        $page_model = $this->loadModel('Page');
        $ret        = $page_model->deleteById($page_id);
        if ($ret === false) {
            return $this->returnInfo(0, '删除失败');
        }

        return $this->returnInfo(1, '删除成功');
    }

    public function add($item_id, $page_title, $page_content, $s_number, $cat_id, $userInfo) {
        if (!$item_id) {
            return $this->returnInfo(0, '项目id不能为空');
        }
        if (!$page_title) {
            return $this->returnInfo(0, '标题不能为空');
        }
        if (!$page_content) {
            return $this->returnInfo(0, '内容不能为空');
        }
        if (!$cat_id) {
            return $this->returnInfo(0, '目录id不能为空');
        }

        $parent    = '/简要描述：\*\*\n\n([\s\S]*?)\n\n\*\*请求URL/i';
        $page_desc = $page_title;
        preg_match_all($parent, $page_content, $match);
        if (isset($match[1][0]) && $match[1][0]) {
            $page_desc = str_replace('-', ' ', $match[1][0]);
        }

        $data       = [
            'item_id'         => $item_id,
            'page_title'      => $page_title,
            'page_desc'       => trim($page_desc),
            'page_content'    => $page_content,
            'order'           => $s_number ? $s_number : 99,
            'cat_id'          => $cat_id,
            'create_time'     => NOW_TIME,
            'author_uid'      => $userInfo['uid'],
            'author_username' => $userInfo['username']
        ];
        $page_model = $this->loadModel('Page');
        $page_id    = $page_model->save($data);
        if ($page_id) {
            return $this->returnInfo(1, '信息提交成功', ['page_id' => $page_id]);
        }

        return $this->returnInfo(0, '信息提交失败');
    }

    public function edit($page_id, $item_id, $page_title, $page_content, $s_number, $cat_id, $userInfo) {
        if (!$page_id) {
            return $this->returnInfo(0, '页面id不能为空');
        }
        if (!$item_id) {
            return $this->returnInfo(0, '项目id不能为空');
        }
        if (!$page_title) {
            return $this->returnInfo(0, '标题不能为空');
        }
        if (!$page_content) {
            return $this->returnInfo(0, '内容不能为空');
        }
        if (!$cat_id) {
            return $this->returnInfo(0, '目录id不能为空');
        }
        $parent    = '/简要描述：\*\*\n\n([\s\S]*?)\n\n\*\*请求URL/i';
        $page_desc = $page_title;
        preg_match_all($parent, $page_content, $match);
        if (isset($match[1][0]) && $match[1][0]) {
            $page_desc = str_replace('-', ' ', $match[1][0]);
        }
        $data       = [
            'item_id'         => $item_id,
            'page_title'      => $page_title,
            'page_desc'       => trim($page_desc),
            'page_content'    => $page_content,
            'order'           => $s_number ? $s_number : 99,
            'cat_id'          => $cat_id,
            'author_uid'      => $userInfo['uid'],
            'author_username' => $userInfo['username']
        ];
        $page_model = $this->loadModel('Page');
        $row        = $page_model->updateById($page_id, $data);
        if ($row) {
            return $this->returnInfo(1, '信息编辑成功', ['page_id' => $page_id]);
        }

        return $this->returnInfo(0, '信息编辑失败');
    }
}