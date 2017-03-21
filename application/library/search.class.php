<?php
/**
 * 文件说明
 *
 * @filename    search.class.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2017/3/15 10:40
 */

namespace Yboard;


use Elasticsearch\ClientBuilder;

class Search {
    private $client;

    public function __construct() {
        $host         = ['172.16.82.65:9200'];
        $this->client = ClientBuilder::create()->setHosts($host)->build();
    }

    public function getClient() {
        return $this->client;
    }

    public function resultDefault($data) {
        if (isset($data['status']) && isset($data['error'])) {
            return false;
        } else {
            return $data;
        }
    }


}