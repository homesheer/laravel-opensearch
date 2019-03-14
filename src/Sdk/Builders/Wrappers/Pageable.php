<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class Pageable
{
    /**
     * @var int
     */
    public $page = null;
    /**
     * @var int
     */
    public $size = null;
    /**
     * @var int
     */
    public $start = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['page'])) {
                $this->page = $vals['page'];
            }
            if (isset($vals['size'])) {
                $this->size = $vals['size'];
            }
            if (isset($vals['start'])) {
                $this->start = $vals['start'];
            }
        }
    }

}
