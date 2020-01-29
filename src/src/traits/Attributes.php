<?php

namespace zikwall\m3ucontentparser\traits;

trait Attributes
{
    public function parseAttributes($tag){
        // The Regex pattern will match all instances of attribute="value"
        $pattern = '/([\w\-_]+)+=[\'"]([^\'"]*)/';
        preg_match_all($pattern, $tag, $matches,PREG_SET_ORDER);

        $result = [];
        foreach($matches as $match){
            $attrName = $match[1];

            // parse the string value into an integer if it's numeric,
            // leave it as a string if it's not numeric,
            $attrValue = is_numeric($match[2]) ? (int)$match[2] : trim($match[2]);

            $result[$attrName] = $attrValue;
        }

        return $result;
    }
}