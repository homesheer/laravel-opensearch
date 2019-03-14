<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class Aggregate
{
    /**
     * 指定需要统计的字段名称。
     *
     *
     * @var string
     */
    public $groupKey = null;
    /**
     * 指定统计的方法。当前支持：count、max、min、sum等。
     *
     *
     * @var string
     */
    public $aggFun = null;
    /**
     * 指定统计范围。
     *
     *
     * @var string
     */
    public $range = null;
    /**
     * 最大组个数。
     *
     *
     * @var string
     */
    public $maxGroup = null;
    /**
     * 指定过滤某些统计。
     *
     *
     * @var string
     */
    public $aggFilter = null;
    /**
     * 指定抽样的阈值。
     *
     *
     * @var string
     */
    public $aggSamplerThresHold = null;
    /**
     * 指定抽样的步长。
     *
     *
     * @var string
     */
    public $aggSamplerStep = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['groupKey'])) {
                $this->groupKey = $vals['groupKey'];
            }
            if (isset($vals['aggFun'])) {
                $this->aggFun = $vals['aggFun'];
            }
            if (isset($vals['range'])) {
                $this->range = $vals['range'];
            }
            if (isset($vals['maxGroup'])) {
                $this->maxGroup = $vals['maxGroup'];
            }
            if (isset($vals['aggFilter'])) {
                $this->aggFilter = $vals['aggFilter'];
            }
            if (isset($vals['aggSamplerThresHold'])) {
                $this->aggSamplerThresHold = $vals['aggSamplerThresHold'];
            }
            if (isset($vals['aggSamplerStep'])) {
                $this->aggSamplerStep = $vals['aggSamplerStep'];
            }
        }
    }

}
