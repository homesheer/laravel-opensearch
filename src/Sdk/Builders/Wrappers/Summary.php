<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

/**
 * 增加了此内容后，fieldName字段可能会被截断、飘红等。
 */
class Summary
{
    /**
     * 指定的生效的字段。此字段必需为可分词的text类型的字段。
     *
     *
     * @var string
     */
    public $summary_field = null;
    /**
     * 指定结果集返回的词字段的字节长度，一个汉字为2个字节。
     *
     *
     * @var string
     */
    public $summary_len = null;
    /**
     * 指定用什么符号来标注未展示完的数据，例如“...”。
     *
     *
     * @var string
     */
    public $summary_ellipsis = "...";
    /**
     * 指定query命中几段summary内容。
     *
     *
     * @var string
     */
    public $summary_snippet = null;
    /**
     * 指定命中的query的标红标签，可以为em等。
     *
     *
     * @var string
     */
    public $summary_element = null;
    /**
     * 指定标签前缀。
     *
     *
     * @var string
     */
    public $summary_element_prefix = null;
    /**
     * 指定标签后缀。
     *
     *
     * @var string
     */
    public $summary_element_postfix = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['summary_field'])) {
                $this->summary_field = $vals['summary_field'];
            }
            if (isset($vals['summary_len'])) {
                $this->summary_len = $vals['summary_len'];
            }
            if (isset($vals['summary_ellipsis'])) {
                $this->summary_ellipsis = $vals['summary_ellipsis'];
            }
            if (isset($vals['summary_snippet'])) {
                $this->summary_snippet = $vals['summary_snippet'];
            }
            if (isset($vals['summary_element'])) {
                $this->summary_element = $vals['summary_element'];
            }
            if (isset($vals['summary_element_prefix'])) {
                $this->summary_element_prefix = $vals['summary_element_prefix'];
            }
            if (isset($vals['summary_element_postfix'])) {
                $this->summary_element_postfix = $vals['summary_element_postfix'];
            }
        }
    }

}
