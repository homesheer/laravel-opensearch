<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

/**
 * 聚合打散条件(distinct)
 *
 * 例如：检索关键词“手机”共获得10个结果，分别为：doc1，doc2，doc3，doc4，doc5，doc6，
 * doc7，doc8，doc9，doc10。其中前三个属于用户A，doc4-doc6属于用户B，剩余四个属于
 * 用户C。如果前端每页仅展示5个商品，则用户C将没有展示的机会。但是如果按照user_id进行抽
 * 取，每轮抽取1个，抽取2次，并保留抽取剩余的结果，则可以获得以下文档排列顺序：doc1、
 * doc4、doc7、doc2、doc5、doc8、doc3、doc6、doc9、doc10。可以看出，通过distinct
 * 排序，各个用户的 商品都得到了展示机会，结果排序更趋于合理。
 */
class Distinct
{
    /**
     * 为用户用于做distinct抽取的字段，该字段要求为可过滤字段。
     *
     *
     * @var string
     */
    public $key = null;
    /**
     * 为一次抽取的document数量，默认值为1。
     *
     *
     * @var int
     */
    public $distCount = 1;
    /**
     * 为抽取的次数，默认值为1。
     *
     *
     * @var int
     */
    public $distTimes = 1;
    /**
     * 为是否保留抽取之后剩余的结果，true为保留，false则丢弃，丢弃时totalHits的个数会减去被distinct而丢弃的个数，但这个结果不一定准确，默认为true。
     *
     *
     * @var bool
     */
    public $reserved = true;
    /**
     * 为过滤条件，被过滤的doc不参与distinct，只在后面的 排序中，这些被过滤的doc将和被distinct出来的第一组doc一起参与排序。默认是全部参与distinct。
     *
     *
     * @var string
     */
    public $distFilter = null;
    /**
     * 当reserved为false时，设置update_total_hit为true，则最终total_hit会减去被distinct丢弃的的数目（不一定准确），为false则不减； 默认为false。
     *
     *
     * @var bool
     */
    public $updateTotalHit = false;
    /**
     * 指定档位划分阈值。
     *
     *
     * @var string
     */
    public $grade = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['key'])) {
                $this->key = $vals['key'];
            }
            if (isset($vals['distCount'])) {
                $this->distCount = $vals['distCount'];
            }
            if (isset($vals['distTimes'])) {
                $this->distTimes = $vals['distTimes'];
            }
            if (isset($vals['reserved'])) {
                $this->reserved = $vals['reserved'];
            }
            if (isset($vals['distFilter'])) {
                $this->distFilter = $vals['distFilter'];
            }
            if (isset($vals['updateTotalHit'])) {
                $this->updateTotalHit = $vals['updateTotalHit'];
            }
            if (isset($vals['grade'])) {
                $this->grade = $vals['grade'];
            }
        }
    }

}
