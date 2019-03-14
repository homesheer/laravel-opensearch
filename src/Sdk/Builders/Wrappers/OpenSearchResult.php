<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class OpenSearchResult
{
    /**
     * @var string
     */
    public $result = null;
    /**
     * @var \OpenSearch\Generated\Common\TraceInfo
     */
    public $traceInfo = null;

    public function __construct($vals=null) {
        if (is_array($vals)) {
            if (isset($vals['result'])) {
                $this->result = $vals['result'];
            }
            if (isset($vals['traceInfo'])) {
                $this->traceInfo = $vals['traceInfo'];
            }
        }
    }

}
