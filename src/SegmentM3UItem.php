<?php

namespace zikwall\m3ucontentparser;

class SegmentM3UItem
{
    /**
     * @var float
     */
    public $duration = 0.0;
    /**
     * @var string
     */
    public $segment = '';

    public function __construct(string $extinf, string $segment)
    {
        list($_, $duration) = explode(':', $extinf);
        $this->duration = explode(',', $duration)[0];

        $this->segment = trim($segment);
    }
}
