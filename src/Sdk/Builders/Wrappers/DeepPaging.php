<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

/**
 *
 * 传统搜索场景的主要目的是为了尽量短的时间内召回最符合的结果，所以对搜索结果进行了限制。在某些场景下需要提供更多的结果来进行分析工作，
 * 可以使用scroll接口来获取更多的结果，目前scorll只支持query与filter子句，sort子句无法支持。
 *
 * 注意事项
 * <pre>
 *  1, start值无效，通过hit值设置每次返回的结果数，即后续查询都以第一次查询指定的hit值为准；
 *  2, aggregate、sort、distinct、排序表达式无效，如果传入，查询会报错且无结果；
 *  3, 第一次查询需要完整的query、index_name、AccessKeyId等参数，后面的查询不需要传这些参数（即使传入，也会被忽略），只需要传入上一次返回的scroll_id即可；
 *  4, 不支持多应用scroll查询；
 *  5, 每次查询都必须传scroll参数，如果不传，对于第一次查询，就按正常的查询；对于后续的查询，按scroll处理，但结果中无scroll_id返回。
 *  6, 返回结果均有第一次查询中的format决定，后续传scroll_id的响应格式均同第一次；
 *  7, 如果用户传入的scroll_id是非法的，那么查询会报错，返回结果格式为json。
 *  8, 第一次查询将不返回实际文档数据，只返回scroll_id，需要再次访问才能拿到搜索结果。
 *  </pre>
 */
class DeepPaging
{
    /**
     * 设置scroll请求的有效期
     *
     * @param expire 指定的scroll请求有效期 默认 1m 表示一分钟，支持的时间单位包括：w=Week, d=Day, h=Hour, m=minute, s=second
     *
     * @var string
     */
    public $scrollExpire = "1m";
    /**
     * @var string
     */
    public $scrollId = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['scrollExpire'])) {
                $this->scrollExpire = $vals['scrollExpire'];
            }
            if (isset($vals['scrollId'])) {
                $this->scrollId = $vals['scrollId'];
            }
        }
    }

}
