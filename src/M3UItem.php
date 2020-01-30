<?php

namespace zikwall\m3ucontentparser;

use zikwall\m3ucontentparser\traits\Attributes;
use zikwall\m3ucontentparser\traits\ItemMeta;

class M3UItem
{
    use Attributes;
    use ItemMeta;

    private $id = '';
    private $tvgId = '';
    private $tvgName = '';
    private $tvgUrl = '';
    private $tvgLogo = '';
    private $tvgCountry = '';
    private $tvgLanguage = '';
    private $audioTrack = '';
    private $audioTrackNum = 0;
    private $tvgShift = 0;
    private $censored = 0;
    private $groupId = 0;
    private $groupTitle = '';
    private $extGrp = '';
    private $extraAttributes = [];

    /**
     * M3UItem constructor.
     * @param string $item
     * @throws \Exception
     */
    public function __construct(string $item)
    {
        list($this->tvgName, $this->tvgUrl) = $count = preg_split('/\r\n|\r|\n/', $item);

        if (strpos($this->tvgName, ',') !== false) {
            $ex = explode(',', $this->tvgName);
            $this->tvgName = $ex[1];

            $this->extraAttributes = $this->resolveMetaTags($this->parseAttributes($ex[0]));
        }

        if (count($count) > 2 && isset($count[2]) && !empty($count[2])) {
            if (strpos($count[1], '#EXTGRP') !== false) {
                $groupName = explode(':', $count[1]);
                $this->extGrp = $groupName[1];
            }

            $this->tvgUrl = $count[2];
        }
    }
}