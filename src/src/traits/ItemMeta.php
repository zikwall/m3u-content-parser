<?php

namespace zikwall\m3ucontentparser\traits;

trait ItemMeta
{
    public function getId()
    {
        return $this->id;
    }

    public function getTvgName()
    {
        return $this->tvgName;
    }

    public function getTvgUrl()
    {
        return $this->tvgUrl;
    }

    public function getTvgLogo()
    {
        return $this->tvgLogo;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function getGroupTitle()
    {
        return $this->groupTitle;
    }

    public function getExtGrp()
    {
        return $this->extGrp;
    }

    public function getCensored()
    {
        return $this->censored;
    }

    protected $availableMetaTags = [
        'id', 'tvg-id', 'group_id', 'group-title', 'tvg-shift',
        'tvg-name', 'tvg-logo', 'audio-track', 'audio-track-num',
        'censored', 'tvg-country', 'tvg-language'
    ];

    public function resolveMetaTags(array $attributtes = [])
    {
        $sanuitize = [];

        foreach ($attributtes as $attrName => $attrValue) {
            if (in_array($attrName, $this->availableMetaTags)) {
                $tagName = str_replace(' ', '', ucwords(str_replace('-', ' ', str_replace('_', ' ', $attrName))));
                $tagName[0] = strtolower($tagName[0]);

                if (!property_exists($this, $tagName)) {
                    throw new \Exception("Property: {$tagName} is not exist!");
                }

                $this->{$tagName} = $attrValue;
            }
        }

        return $attributtes;
    }

    // add available attrubuttes
    // remove attributtes
}