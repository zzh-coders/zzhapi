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

    /**
     * 初始化mysql数据放在ElasticSearch上面
     */
    public function initElasticSearchAction() {
        set_time_limit(0);
        Yaf\Loader::import(APP_PATH . '/vendor/autoload.php');
        Yaf\Loader::import(LIB_PATH . 'search.class.php');
        $search_class = new \Yboard\Search();
        $client       = $search_class->getClient();
        if ($client->indices()->exists(['index' => 'book'])) {
            $client->indices()->delete(['index' => 'book']);
        }
        $params = [
            'index' => 'book',
            'body'  => [
                'settings' => [
                    'number_of_shards'   => 3,
                    'number_of_replicas' => 1
                ],
                "mappings" => [
                    "page" => [
                        "properties" => [
                            "page_id"      => [
                                "type" => "long"
                            ],
                            "item_id"      => [
                                "type" => "long"
                            ],
                            "page_title"   => [
                                "type"            => "string",
                                "analyzer"        => "ik",
                                "search_analyzer" => "ik"
                            ],
                            "page_content" => [
                                "type"            => "string",
                                "analyzer"        => "ik",
                                "search_analyzer" => "ik"
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $client->indices()->create($params);

        $limit = 200;
        $start = 0;

        $page_service = $this->loadService('Page');
        $page_count   = $page_service->getCount([]);
        $body         = [];
        while ($start < $page_count) {
            $list = $page_service->getList([], $limit, $start, ['page_id', 'item_id', 'page_title', 'page_content']);
            $body = array_merge($body, $list);

            $start += $limit;
        }
        $count  = count($body);
        $params = ['body' => []];
        foreach ($body as $key => $value) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'book',
                    '_type'  => 'page',
                    '_id'    => $value['page_id']
                ]
            ];

            $params['body'][] = $value;
            if (($count > 500 && $key % 500 == 0) || ($key == $count)) {
                $responses = $client->bulk($params);

                $params = ['body' => []];

                unset($responses);
            }

        }
        if (!empty($params['body'])) {
            $responses = $client->bulk($params);
        }

        return false;
    }

    public function searchAction() {
        Yaf\Loader::import(APP_PATH . '/vendor/autoload.php');
        Yaf\Loader::import(LIB_PATH . 'search.class.php');
        $search_class = new \Yboard\Search();
        $client       = $search_class->getClient();
        $key_word     = trim($this->get('key_word'));
        $key_word     = urldecode($key_word);

        $params       = [
            'index' => 'book',
            'type'  => 'page',
            'from'  => 0,
            'size'  => 20,
            'sort'  => [
                '_score' => [
                    'page_id' => 'desc'
                ]
            ],
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'  => $key_word,
                        'fields' => ['page_content', 'page_title'],
                    ]
                ]
            ]
        ];
        $results      = $client->search($params);
        $result_array = [];
        foreach ($results['hits']['hits'] as $key => $value) {
            $result_array[$value['_source']['page_id']]              = $value['_source'];
            $result_array[$value['_source']['page_id']]['page_desc'] = $value['_source']['page_content'];
            unset($result_array[$value['_source']['page_id']]['page_content']);
        }
        $this->output_data['key']  = $key_word;
        $this->output_data['list'] = $result_array;
        $this->display('index', $this->output_data);

        return false;
    }

}