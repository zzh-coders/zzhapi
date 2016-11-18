<?php
/**
 * 简述
 *
 * 详细说明(可略)
 *
 * @copyright Copyright&copy; 2016, Meizu.com
 * @author   zouzehua <zouzehua@meizu.com>
 * @version $Id: SearchService.class.php, v ${VERSION} 2016-11-17 21:05 Exp $
 */

namespace Yboard;


class SearchService extends CommonService {

    public function search($key, $item_id) {
        $page_model = $this->loadModel('Page');

        return $page_model->getInfoByIdAndName($item_id,$key);
    }
}