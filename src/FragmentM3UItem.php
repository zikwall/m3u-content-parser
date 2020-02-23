<?php

namespace zikwall\m3ucontentparser;

class FragmentM3UItem
{
    /**
     * @var array
     */
    public $descriptions = [];
    /**
     * @var string
     */
    public $fragment = '';

    public function __construct(string $extxinf, string $fragment)
    {
        list($_, $descriptions) = explode(':', $extxinf);
        $descriptions = explode(',', $descriptions);

        if (count($descriptions) > 0) {
            foreach ($descriptions as $description) {
                $count = explode('=', str_replace('"', '', $description));

                // break crashed params
                if (count($count) < 2) {
                    /**
                     * TODO parse & validate next props string: CODECS="mp4a.40.2,avc1.64001f"
                     */
                    continue;
                }

                list ($key, $value) = $count;

                $this->descriptions[] = [
                    'key' => $key,
                    'value' => $value
                ];
            }
        }

        if ($fragment[0] === '/') {
            $fragment = substr($fragment, 1, strlen($fragment));
        }

        $this->fragment = $fragment;
    }
}
