<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class SearchParams
{
    /**
     * config for search.
     *
     * @var \OpenSearch\Generated\Search\Config
     */
    public $config = null;
    /**
     * 设定指定索引字段范围的搜索关键词(query)
     *
     * 此query是查询必需的一部分，可以指定不同的索引名，并同时可指定多个查询及之间的关系
     * （AND, OR, ANDNOT, RANK）。
     *
     * 例如查询subject索引字段的query:“手机”，可以设置为 query=subject:'手机'。
     *
     * 上边例子如果查询price 在1000-2000之间的手机，其查询语句为： query=subject:'手机'
     * AND price:[1000,2000]
     *
     * NOTE: text类型索引在建立时做了分词，而string类型的索引则没有分词。
     *
     * @link http://docs.aliyun.com/?spm=5176.2020520121.103.8.VQIcGd&tag=tun#/pub/opensearch/api-reference/query-clause&query-clause
     *
     *
     * @var string
     */
    public $query = null;
    /**
     * 过滤规则(filter)
     *
     * @var string
     */
    public $filter = null;
    /**
     * 排序字段及排序方式(sort)
     *
     * @var \OpenSearch\Generated\Search\Sort
     */
    public $sort = null;
    /**
     * @var \OpenSearch\Generated\Search\Rank
     */
    public $rank = null;
    /**
     * 添加统计信息(aggregate)相关参数
     *
     * @var \OpenSearch\Generated\Search\Aggregate[]
     */
    public $aggregates = null;
    /**
     * 聚合打散条件
     *
     * @var \OpenSearch\Generated\Search\Distinct[]
     */
    public $distincts = null;
    /**
     * 动态摘要(summary)信息
     *
     * @var \OpenSearch\Generated\Search\Summary[]
     */
    public $summaries = null;
    /**
     * 设置查询分析规则(qp)
     *
     * @var string[]
     */
    public $queryProcessorNames = null;
    /**
     * @var \OpenSearch\Generated\Search\DeepPaging
     */
    public $deepPaging = null;
    /**
     * 关闭某些功能模块(disable)
     *
     * 有如下场景需要考虑：
     * 1、如果要关闭整个qp的功能，则指定disableValue="qp"。
     * 2、要指定某个索引关闭某个功能，则可以指定disableValue="qp:function_name:index_names",
     *   其中index_names可以用“|”分隔，可以为index_name1|index_name2...
     * 3、如果要关闭多个function可以用“,”分隔，例如：disableValue="qp:function_name1:index_name1,qp:function_name2:index_name1"
     *
     * qp有如下模块：
     * 1、spell_check: 检查用户查询串中的拼写错误，并给出纠错建议。
     * 2、term_weighting: 分析查询中每个词的重要程度，并将其量化成权重，权重较低的词可能不会参与召回。
     * 3、stop_word: 根据系统内置的停用词典过滤查询中无意义的词
     * 4、synonym: 根据系统提供的通用同义词库和语义模型，对查询串进行同义词扩展，以便扩大召回。
     *
     * example:
     * "qp" 标示关闭整个qp
     * "qp:spell_check" 标示关闭qp的拼音纠错功能。
     * "qp:stop_word:index_name1|index_name2" 标示关闭qp中index_name1和index_name2上的停用词功能。
     *
     * key 需要禁用的函数名称
     * value 待禁用函数的详细说明
     *
     * @var array
     */
    public $disableFunctions = null;
    /**
     * @var array
     */
    public $customParam = null;
    /**
     * 下拉提示是搜索服务的基础功能，在用户输入查询词的过程中，智能推荐候选query，减少用户输入，帮助用户尽快找到想要的内容。
     * OpenSearch下拉提示在实现了中文前缀，拼音全拼，拼音首字母简拼查询等通用功能的基础上，实现了基于用户文档内容的query智能识别。
     * 用户通过控制台的简单配置，就能拥有专属的定制下拉提示。此外，控制台上还提供了黑名单，推荐词条功能，让用户进一步控制下拉提示
     * 的结果，实现更灵活的定制。
     *
     *
     * @var \OpenSearch\Generated\Search\Suggest
     */
    public $suggest = null;
    /**
     * Abtest
     *
     * @var \OpenSearch\Generated\Search\Abtest
     */
    public $abtest = null;
    /**
     * 终端用户的id，用来统计uv信息
     *
     * @var string
     */
    public $userId = null;
    /**
     * 终端用户输入的query
     *
     * @var string
     */
    public $rawQuery = null;

    /**
     * SearchParams constructor.
     *
     * @param null $vals
     */
    public function __construct($vals=null) {
        $this->rank = new Rank(array(
            "reRankSize" => 200,
        ));
        if (is_array($vals)) {
            if (isset($vals['config'])) {
                $this->config = $vals['config'];
            }
            if (isset($vals['query'])) {
                $this->query = $vals['query'];
            }
            if (isset($vals['filter'])) {
                $this->filter = $vals['filter'];
            }
            if (isset($vals['sort'])) {
                $this->sort = $vals['sort'];
            }
            if (isset($vals['rank'])) {
                $this->rank = $vals['rank'];
            }
            if (isset($vals['aggregates'])) {
                $this->aggregates = $vals['aggregates'];
            }
            if (isset($vals['distincts'])) {
                $this->distincts = $vals['distincts'];
            }
            if (isset($vals['summaries'])) {
                $this->summaries = $vals['summaries'];
            }
            if (isset($vals['queryProcessorNames'])) {
                $this->queryProcessorNames = $vals['queryProcessorNames'];
            }
            if (isset($vals['deepPaging'])) {
                $this->deepPaging = $vals['deepPaging'];
            }
            if (isset($vals['disableFunctions'])) {
                $this->disableFunctions = $vals['disableFunctions'];
            }
            if (isset($vals['customParam'])) {
                $this->customParam = $vals['customParam'];
            }
            if (isset($vals['suggest'])) {
                $this->suggest = $vals['suggest'];
            }
            if (isset($vals['abtest'])) {
                $this->abtest = $vals['abtest'];
            }
            if (isset($vals['userId'])) {
                $this->userId = $vals['userId'];
            }
            if (isset($vals['rawQuery'])) {
                $this->rawQuery = $vals['rawQuery'];
            }
        }
    }
}
