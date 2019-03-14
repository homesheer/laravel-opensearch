<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class Abtest
{
    /**
     * 场景标签。用户在控制台上配置哪些场景需要做实验，查询中只有指定了对应场景名的query才会进行实验。
     *
     * @var string
     */
    public $sceneTag = null;
    /**
     * 流量分配标识。对该值进行hash，将用户查询分配到不同的实验中，该值通常可设置为最终用户的id。
     *
     * @var string
     */
    public $flowDivider = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['sceneTag'])) {
                $this->sceneTag = $vals['sceneTag'];
            }
            if (isset($vals['flowDivider'])) {
                $this->flowDivider = $vals['flowDivider'];
            }
        }
    }
}
