<?php

namespace Huoban\Helpers;

/**
 * 筛选器
 */
class Filter
{
    /**
     * 请求结构体
     *
     * @var array
     */
    public $body = [];

    public function __construct()
    {
        $this->setBodyFefault();
    }

    public static function getNewFilter(): object
    {
        $filter = new self();
        return $filter;
    }

    public function setBodyFefault()
    {
        $this->body['limit']  = 500;
        $this->body['offset'] = 0;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * 根据条件生成结构条件
     *
     * @param array $conditions
     * @return object
     */
    public function setWhere(array $conditions): object
    {
        // 如果之前没有条件结构，则新创建一个
        !isset($this->body['where']['and']) && $this->body['where'] = ['and' => []];

        foreach ($conditions as $condition) {
            foreach ($condition as $field => $query) {

                $this->body['where']['and'][] = [
                    'field' => $field,
                    'query' => $query,
                ];
            }
        }
        return $this;
    }

    /**
     * 判断请求体是否已经存在指定的field
     *
     * @param [type] $field
     * @return void
     */
    public function getWhereConditionsRepeatKey($field)
    {
        foreach ($this->body['where']['and'] as $key => $value) {

            if ($field == $value['field'] && isset($value['query']['or'])) {
                return $key;
            }
        }
        return false;
    }

    public function getWhereOrQuery(array $already_or_query, array $query): array
    {
        array_push($already_or_query['or'], $query['or']);
        return $already_or_query;
    }

    public function setLimit(int $limit): object
    {
        $this->body['limit'] = $limit;
        return $this;
    }

    public function setOffset(int $offset)
    {
        $this->body['offset'] = $offset;
        return $this;
    }

    /**
     * 设置筛选器条件，Item_ids
     *
     * @return void
     */
    public function inItemIds($item_ids): object
    {
        $condition = ['item_id' => ['in' => $item_ids]];
        $this->setWhere([$condition]);

        return $this;
    }

    public function eq($field, $value): object
    {
        $condition = [$field => ['eq' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //等于

    public function ne($field, $value): object
    {
        $condition = [$field => ['ne' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //不等于

    public function gt($field, $value): object
    {
        $condition = [$field => ['gt' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //大于

    public function gte($field, $value): object
    {
        $condition = [$field => ['gte' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //大等于

    public function lt($field, $value): object
    {
        $condition = [$field => ['lt' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //小于

    public function lte($field, $value): object
    {
        $condition = [$field => ['lte' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //小等于

    public function in($field, array $value): object
    {
        $condition = [$field => ['in' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //包含

    public function nin($field, array $value): object
    {
        $condition = [$field => ['nin' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //不包含

    public function em($field, bool $value): object
    {
        $condition = [$field => ['em' => $value]];
        $this->setWhere([$condition]);

        return $this;
    } //是否为空

    public function addWhereOr($field, $condition): object
    {
        $condition = [$field => [$condition]];
        $this->setWhere([$condition]);

        return $this;
    } //多个条件并集

    /**
     * exampleWhereConditions
     *
     * @return void
     */
    public function exampleWhereConditions()
    {
        $conditions = [
            'F::{table_alias.field_alias/field_id}' => [
                'eq' => '1',
            ], //等于
            'F::{table_alias.field_alias/field_id}' => [
                'ne' => '1',
            ], //不等于
            'F::{table_alias.field_alias/field_id}' => [
                'in' => ['1'],
            ], //包含
            'F::{table_alias.field_alias/field_id}' => [
                'nin' => ['1'],
            ], //不包含
            'F::{table_alias.field_alias/field_id}' => [
                'gt' => 1,
            ], //大于
            'F::{table_alias.field_alias/field_id}' => [
                'gte' => 1,
            ], //大等于
            'F::{table_alias.field_alias/field_id}' => [
                'lt' => 1,
            ], //小于
            'F::{table_alias.field_alias/field_id}' => [
                'in' => 1,
            ], //小等于
            'F::{table_alias.field_alias/field_id}' => [
                'em' => true,
            ], //是否为空
            'F::{table_alias.field_alias/field_id}' => [
                'or' => [
                    [
                        'ne' => '1',
                    ],
                    [
                        'gt' => '2',
                    ],
                ],
            ], //多个条件并集
        ];
    }

    /**
     * exampleWhereSource
     *
     * @return void
     */
    public function exampleWhereSource()
    {
        // 创建人条件
        $body = [
            'field' => 'created_by',
            'query' => [
                'eq'  => [
                    11001,
                ],
                'ne'  => [
                    11001,
                ],
                'in'  => [
                    110011,
                    110012,
                    'myself',
                ],
                'nin' => [
                    110011,
                    110012,
                    'myself',
                ],
            ],
        ];

        // 创建时间
        $body = [
            'field' => 'created_on',
            'query' => [
                'eq'  => '2015-05-11',
                'ne'  => 'last_week',
                'gt'  => '2015-05-11',
                'lt'  => 'yesterday',
                'gte' => '2015-05-11',
                'lte' => '2015-05-11',
            ],
        ];
        // 文本字段
        $body = [
            'field' => 720002,
            'query' => [
                'eq'  => '匹配的文本',
                'ne'  => '不匹配的文本',
                'in'  => [
                    '匹配的文本1',
                    '匹配的文本2',
                ],
                'nin' => [
                    '不匹配的文本1',
                    '不匹配的文本2',
                ],
                'or'  => [
                    [
                        'eq' => '匹配的文本',
                    ],
                    [
                        'in' => [
                            '匹配的文本1',
                            '匹配的文本2',
                        ],
                    ],
                ],
                'em'  => true,
            ],
        ];
        // 数字字段和计算字段
        $body = [
            'field' => 720003,
            'query' => [
                'eq'  => 20,
                'ne'  => 20,
                'gt'  => 20,
                'lt'  => 20,
                'gte' => 20,
                'lte' => 20,
                'or'  => [
                    [
                        'eq' => 20,
                    ],
                    [
                        'gte' => 10,
                        'lt'  => 20,
                    ],
                ],
                'em'  => false,
            ],
        ];
        // 分类字段
        $body = [
            'field' => 720004,
            'query' => [
                'eq'  => [
                    1,
                    3,
                ],
                'ne'  => [
                    2,
                ],
                'in'  => [
                    1,
                    3,
                ],
                'nin' => [
                    1,
                    3,
                ],
                'em'  => true,
            ],
        ];
        // 时间字段
        $body = [
            'field' => 720005,
            'query' => [
                'eq'  => '2015-05-11',
                'ne'  => 'last_week',
                'gt'  => '2015-05-11',
                'lt'  => 'yesterday',
                'gte' => '2015-05-11',
                'lte' => '2015-05-11',
                'em'  => true,
            ],
        ];
        // 联系人字段
        $body = [
            'field' => 720006,
            'query' => [
                'eq'  => [
                    11001,
                ],
                'ne'  => [
                    11001,
                ],
                'in'  => [
                    110011,
                    110012,
                    'myself',
                ],
                'nin' => [
                    110011,
                    110012,
                    'myself',
                ],
                'em'  => true,
            ],
        ];
        // 图片字段
        $body = [
            'field' => 720007,
            'query' => [
                'em' => false,
            ],
        ];
        // 关联字段
        $body = [
            'field' => 720008,
            'query' => [
                'eq'  => [
                    21001,
                ],
                'ne'  => [
                    21001,
                ],
                'in'  => [
                    210011,
                    210012,
                ],
                'nin' => [
                    210011,
                    210012,
                ],
                'em'  => true,
            ],
        ];
        // 数据ID字段
        $body = [
            'field' => 'item_id',
            'query' => [
                'eq'  => 31001,
                'ne'  => 31001,
                'in'  => [
                    310011,
                    310012,
                ],
                'nin' => [
                    310011,
                    310012,
                ],
            ],
        ];
    }

}
