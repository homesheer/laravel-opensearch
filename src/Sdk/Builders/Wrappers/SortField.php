<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class SortField
{
    /**
     * 排序方式字段名.
     *
     *
     * @var string
     */
    public $field = null;
    /**
     * 排序方式，有升序“INCREASE”和降序“DECREASE”两种方式。默认值为“DECREASE”
     *
     *
     * @var int
     */
    public $order =   0;

    public function __construct($vals=null) {
        if (is_array($vals)) {
            if (isset($vals['field'])) {
                $this->field = $vals['field'];
            }
            if (isset($vals['order'])) {
                $this->order = $vals['order'];
            }
        }
    }

}
