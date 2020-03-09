<?php
include_once __DIR__ . '/Curl.class.php';

class Es
{
    private $es_index = '';  // Es 查询的索引
    private $_fields = '';  // 要查询的字段
    private $page = ''; //拼接 分页的数据
    private $where = []; // 查询条件
    private $whereOr = []; // OR查询条件
    private $match = []; // OR查询条件
    private $_es_url = 'http://1903.vonetxs.com:9200/'; // Es 的地址

    // 设置 Es 的地址
    public function setEsUrl($es_url)
    {
        $this->_es_url = $es_url;
    }

    // 指定要查询的索引
    public function index($index_name)
    {
        $this->es_index = $index_name;
        return $this;
    }

    // 指定要查询的字段
    public function fields($fields)
    {
        if (is_array($fields)) {
            $fields = implode(',',$fields);
        }
        $this->_fields = $fields;
        return $this;
    }

    // 拼接 where 条件
    public function where(array $where)
    {
        if (!empty($where)){
            foreach ($where as $k => $v){
                if (is_array($v))
                {
                    $this -> buildWhere($v);
                }else{
                    # 判断查询条件
                    $this -> buildWhere($where);
                    break;
                }
            }
        }
        return $this;
    }

    // 拼接 whereOr 条件
    public function whereOr(array $where)
    {
        if (!empty($where)){
            foreach ($where as $k => $v){
                if (is_array($v))
                {
                    $this -> buildWhereOr($v);
                }else{
                    # 判断查询条件
                    $this -> buildWhereOr($where);
                    break;
                }
            }
        }
        return $this;
    }

    // 拼接 where 条件  buildWhere 方法
    private function buildWhere(array $where)
    {
        switch ( $where[1] )
        {
            case '=':
                $this->where[] = [
                    'term' => [
                        $where[0] => $where[2]
                    ]
                ];
                break;
            case '>':
                $this->where[] = [
                    'range' => [
                        $where[0] => ['gt'=>$where[2]]
                    ]
                ];
                break;
            case '<':
                $this->where[] = [
                    'range' => [
                        $where[0] => ['lt'=>$where[2]]
                    ]
                ];
                break;
            case '>=':
                $this->where[] = [
                    'range' => [
                        $where[0] => ['gte'=>$where[2]]
                    ]
                ];
                break;
            case '<=':
                $this->where[] = [
                    'range' => [
                        $where[0] => ['lte'=>$where[2]]
                    ]
                ];
                break;
            case 'in':
                $this->where[] = [
                    'terms' => [
                        $where[0] => $where[2]
                    ]
                ];
                break;
            case 'like':
                $this->where[] = [
                    'regexp' => [
                        $where[0] => '.*'.$where[2].'.*'
                    ]
                ];
                break;
        }
    }

    // 拼接 where 条件  buildWhereOr 方法
    private function buildWhereOr(array $where)
    {
        switch ( $where[1] )
        {
            case '=':
                $this->whereOr[] = [
                    'term' => [
                        $where[0] => $where[2]
                    ]
                ];
                break;
            case '>':
                $this->whereOr[] = [
                    'range' => [
                        $where[0] => ['gt'=>$where[2]]
                    ]
                ];
                break;
            case '<':
                $this->whereOr[] = [
                    'range' => [
                        $where[0] => ['lt'=>$where[2]]
                    ]
                ];
                break;
            case '>=':
                $this->whereOr[] = [
                    'range' => [
                        $where[0] => ['gte'=>$where[2]]
                    ]
                ];
                break;
            case '<=':
                $this->whereOr[] = [
                    'range' => [
                        $where[0] => ['lte'=>$where[2]]
                    ]
                ];
                break;
            case 'in':
                $this->whereOr[] = [
                    'terms' => [
                        $where[0] => $where[2]
                    ]
                ];
                break;
            case 'like':
                $this->whereOr[] = [
                    'regexp' => [
                        $where[0] => '.*'.$where[2].'.*'
                    ]
                ];
                break;
        }
    }
    /*
     * 查询所有 数据
     */
    public function findAll()
    {
        $end_where = $this -> buildEndWhere();

        if (empty($this->es_index))
        {
            $this->showError('请使用Index方法指定要查询的Es索引');
            return false;
        }
        $es_url = $this->_es_url.$this->es_index.'/_doc/_search';

        if ($this->_fields) {
            $es_url .= '?_source'.$this->_fields.'&'.$this->page;
        }else{
            $es_url .= '?'.$this->page;
        }
//        var_dump($es_url);exit;
        $header = [
            'Content-Type: application/json'
        ];

        # 没有 条件 查询所有数据
        if (empty($end_where)){
            $json = Curl::get($es_url);
        }else{
            $json = Curl::get($es_url,json_encode($end_where),$header);
        }
        $arr = json_decode($json,true);

        if (!empty($arr['error'])) {
            return ['status'=>1,'msg'=>$arr['error']['root_cause'][0]['reason']];
        }else{
            // 把Es返回的数据转换成数组
            $data = [];
            foreach($arr['hits']['hits'] as $k => $v) {
                $data[] = $v['_source'];
            }
            return ['status'=>200,'data'=>$data,'msg'=>'success'];
        }
    }

    /*
     *  查询单条 数据
     */
    public function findOne(int $doc_id)
    {
        $end_where = $this -> buildEndWhere();

        if (empty($this->es_index)) {
            $this->showError('请使用Index方法指定要查询的Es索引');
            return false;
        }
        $es_url = $this->_es_url.$this->es_index.'/_doc/'.$doc_id;

        if ($this->_fields) {
            $es_url .= '?_source='.$this->_fields;
        }

        $header = [
            'Content-Type: application/json'
        ];

        # 没有 条件 查询所有数据
        if (empty($end_where)){
            $json = Curl::get($es_url);
        }else{
            $json = Curl::get($es_url,json_encode($end_where),$header);
        }
        $arr = json_decode($json,true);


        if (!empty($arr['_source'])) {
            return $arr['_source'];
        }else{
            return [];
        }
    }

    // 删除一条数据
    public function delete(int $doc_id)
    {
        if (empty($this->es_index)) {
            $this->showError('请使用Index方法指定要查询的Es索引');
            return false;
        }
        $es_url = $this->_es_url.$this->es_index.'/_doc/'.$doc_id;

        // 发送delete请求
        $result = Curl::delete($es_url);
        $arr = json_decode($result,1);
        //var_dump($arr);die;

        if (!empty($arr['error'])) {
            $this->showError($arr['error']['root_cause'][0]['reason']);
        }else{
            if ($arr['result'] == 'deleted') {
                return true;
            }else{
                return false;
            }
        }
    }

    # 返回 where 拼接的条件
    private function buildEndWhere()
    {
        $end_where = [];
        # 拼接 where 条件
        if(!empty($this->where)){
            # 拼接 Es 的搜索语句
            $end_where['query']['bool']['should'][]=[
                'bool'=>[
                    'must'=>[
                        $this -> where
                    ]
                ]
            ];
        }

        # 拼接 or 条件
        if(!empty($this ->whereOr)){
            $end_where['query']['bool']['should'][] = $this ->whereOr;
        }

        # 拼接 match 条件
        if(!empty($this ->match)){
            $end_where['query']['bool']['should'][] = $this ->match;
        }

        return $end_where;
    }

    // 分页
    public function page($page = 1,$page_size=10)
    {
        $limit = ($page - 1) * $page_size;
        $this -> page = 'size='.$page_size.'&from='.$limit;

        return $this;
    }

    // ik 分词
    public function match( array $match_arr)
    {
        if (!empty($match_arr)){
            foreach ($match_arr as $k=>$v){
                $this -> match[]['match'] = [
                    $k => $v
                ];
            }
        }

        return $this;
    }

    /**
     * 写入ES的数据，ID存在是修改，否则是写入
     * @param int $doc_id
     * @param array $data
     * @return bool
     */
    public function save(int $doc_id,array $data)
    {
        if (empty($this->es_index)) {
            $this->showError('请使用Index方法指定要查询的Es索引');
            return false;
        }
        $es_url = $this->_es_url.$this->es_index.'/_doc/'.$doc_id;
        # [ Es 数据格式为 Content-Type:application/json]
        $header = [
            'Content-Type: application/json'
        ];
        $result = Curl::Post($es_url,json_encode($data),$header);
        $arr = json_decode($result,1);

        if (!empty($arr['error'])) {
            $this->showError($arr['error']);
        }else{
            return true;
        }
    }

    /*
     * 错误 信息
     */
    public function showError($msg='')
    {
        echo '<h1><span style="color:deepskyblue">'.$msg.'</span></h1>';
        exit;
    }
}