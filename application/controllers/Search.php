<?php

/**
 * 简述
 *
 * 详细说明(可略)
 *
 * @copyright Copyright&copy; 2016, Meizu.com
 * @author   zouzehua <zouzehua@meizu.com>
 * @version $Id: Search.php, v ${VERSION} 2016-11-8 10:13 Exp $
 */
class SearchController extends CommonController {
    private $page_service;

    public function init() {
        parent::init();
        $this->page_service = $this->loadService('Search');
    }

    public function indexAction() {
        $key                       = $this->get('key', false);
        $key                       = urldecode(trim($key));
        $item_id                   = $this->get('item_id');
        $this->output_data['key']  = $key;
        $this->output_data['list'] = $this->page_service->search($key, $item_id);
        $this->display('index', $this->output_data);

        return false;
    }

}