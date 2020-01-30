<?php

namespace zikwall\m3ucontentparser\traits;

use zikwall\m3ucontentparser\M3UItem;

trait ItemMeta
{
    public function replaceTvgLogo($attrValue) : M3UItem
    {
        $this->tvgLogo = $attrValue;
        return $this;
    }

    public function replaceTvgUrl($attrValue) : M3UItem
    {
        $this->tvgUrl = $attrValue;
        return $this;
    }

    public function replaceTvgName($attrValue) : M3UItem
    {
        $this->tvgName = $attrValue;
        return $this;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getTvgName() : string
    {
        return $this->tvgName;
    }

    public function getTvgUrl() : string
    {
        return $this->tvgUrl;
    }

    public function getTvgLogo() : string
    {
        return $this->tvgLogo;
    }

    public function getTvgShift() : int
    {
        return $this->tvgShift;
    }

    public function getGroupId() : int
    {
        return $this->groupId;
    }

    public function getGroupTitle() : string
    {
        return $this->groupTitle;
    }

    public function getExtGrp() : string
    {
        return $this->extGrp;
    }

    public function getCensored() : int
    {
        return $this->censored;
    }

    public function getLanguage() : string
    {
        return $this->tvgLanguage;
    }

    public function getCountry() : string
    {
        return $this->tvgCountry;
    }

    public function getAudioTrack() : string
    {
        return $this->audioTrack;
    }

    public function getAudioTrackNum() : int
    {
        return $this->audioTrackNum;
    }

    public function getExtraAttributes() : array
    {
        return $this->extraAttributes;
    }

    protected $availableMetaTags = [
        'id', 'tvg-id', 'group_id', 'group-title', 'tvg-shift',
        'tvg-name', 'tvg-logo', 'audio-track', 'audio-track-num',
        'censored', 'tvg-country', 'tvg-language'
    ];

    /**
     * @param array $attributes
     * @return array
     * @throws \Exception
     */
    protected function resolveMetaTags(array $attributes = [])
    {
        foreach ($attributes as $attrName => $attrValue) {
            if (in_array($attrName, $this->availableMetaTags)) {
                $tagName = str_replace(' ', '', ucwords(str_replace('-', ' ', str_replace('_', ' ', $attrName))));
                $tagName[0] = strtolower($tagName[0]);

                if (!property_exists($this, $tagName)) {
                    throw new \Exception("Property: {$tagName} is not exist!");
                }

                $this->{$tagName} = $attrValue;
            }
        }

        return $attributes;
    }
}