<?php

/**
 * 简述
 *
 * 详细说明(可略)
 *
 * @copyright Copyright&copy; 2016, Meizu.com
 * @author   zouzehua <zouzehua@meizu.com>
 * @version $Id: Page.php, v ${VERSION} 2016-11-18 11:05 Exp $
 */
class PageController extends Yaf\Controller_Abstract {
    public function indexAction() {
        //先获取page里面page_desc为空的数据
        $page_model = $this->loadModel('Page');
        //将page_content正则匹配出描述放在page_desc里面

        while ($page_info = $page_model->getInfoIsDescNull()) {
            foreach ($page_info as $value) {
                $parent    = '/简要描述：\*\*\n\n([\s\S]*?)\n\n\*\*请求URL/i';
                $page_desc = $value['page_title'];
                preg_match_all($parent, $value['page_content'], $match);
                if (isset($match[1][0]) && $match[1][0]) {
                    $page_desc = str_replace('-', ' ', $match[1][0]);
                }
                $data['page_desc'] = trim($page_desc);
                $page_model->updateById($value['page_id'], $data);
                echo $value['page_id'] . "\n";
                usleep(100);
            }
            sleep(1);
        }


        return false;
    }

    private function loadModel($table, $arg = null) {
        try {
            \Yaf\Loader::import('Model.class.php');
            \Yaf\Loader::import('CommonModel.class.php');
            $table = ucfirst($table);
            static $models;
            if (isset($models[$table]) && $models[$table]) {
                return $models[$table];
            }
            $file = MODEL_PATH . '/' . $table . 'Model.class.php';
            if (PHP_OS == 'Linux') {
                \Yaf\Loader::import($file);
            } else {
                require_once $file;
            }
            $class          = "\\Yboard\\" . $table . 'Model';
            $model          = new $class($arg);
            $models[$table] = $model;

            return $model;
        } catch (Exception $e) {
            E($e->getMessage());
        }

    }
}