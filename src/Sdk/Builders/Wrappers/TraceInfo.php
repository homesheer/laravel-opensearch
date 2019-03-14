<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class TraceInfo
{
    /**
     * @var string
     */
    public $requestId = null;
    /**
     * @var string
     */
    public $tracer = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['requestId'])) {
                $this->requestId = $vals['requestId'];
            }
            if (isset($vals['tracer'])) {
                $this->tracer = $vals['tracer'];
            }
        }
    }

}
