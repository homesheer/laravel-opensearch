<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

/**
 * 排序相关度及表达式
 */
class Rank
{
    /**
     * @var int
     */
    public $reRankSize = 200;
    /**
     * 设置粗排表达式名称
     *
     *
     * @var string
     */
    public $firstRankName = null;
    /**
     * 设置粗排表达式名称
     *
     *
     * @var string
     */
    public $secondRankName = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['reRankSize'])) {
                $this->reRankSize = $vals['reRankSize'];
            }
            if (isset($vals['firstRankName'])) {
                $this->firstRankName = $vals['firstRankName'];
            }
            if (isset($vals['secondRankName'])) {
                $this->secondRankName = $vals['secondRankName'];
            }
        }
    }

}
