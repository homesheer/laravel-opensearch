<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class Sort
{
    /**
     * @var \OpenSearch\Generated\Search\SortField[]
     */
    public $sortFields = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['sortFields'])) {
                $this->sortFields = $vals['sortFields'];
            }
        }
    }

}
