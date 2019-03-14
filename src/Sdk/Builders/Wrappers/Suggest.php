<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class Suggest
{
    /**
     * @var string
     */
    public $suggestName = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['suggestName'])) {
                $this->suggestName = $vals['suggestName'];
            }
        }
    }

}
