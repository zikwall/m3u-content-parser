<?php

namespace zikwall\m3ucontentparser;

use zikwall\m3ucontentparser\traits\SegmentM3U8Getters;

class SegmentM3U
{
    use SegmentM3U8Getters;

    /**
     * @var string
     */
    protected $source = '';
    /**
     * @var string
     */
    protected $sourceWithout = '';
    /**
     * @var array
     */
    protected $dirtyItems = [];
    /**
     * @var array
     */
    protected $hashHeaders = [];
    /**
     * @var array
     */
    protected $availableHashHeaders = [
        '#EXT-X-VERSION', '#EXT-X-TARGETDURATION', '#EXT-X-MEDIA-SEQUENCE',
        '#EXT-X-ALLOW-CACHE', '#EXT-X-PLAYLIST-TYPE', '#EXT-X-DISCONTINUITY-SEQUENCE'
    ];
    /**
     * @property []SegmentM3U8Item
     */
    protected $segments = [];
    /**
     * @var float
     */
    protected $duration = 0.0;
    /**
     * @property []FragmentM3U8Item
     */
    protected $fragments = [];
    /**
     * @var bool
     */
    protected $isEnding = false;
    /**
     * @var bool
     */
    protected $isFragmentSource = true;

    public function setEnding(bool $ending)
    {
        $this->isEnding = $ending;
    }

    public function setIsFragmentSource(bool $is)
    {
        $this->isFragmentSource = $is;
    }

    public function addSegment(SegmentM3UItem $segment)
    {
        $this->segments[] = $segment;
    }

    public function addFragment(FragmentM3UItem $fragment)
    {
        return $this->fragments[] = $fragment;
    }

    public function incDuration(float $duration)
    {
        $this->duration += $duration;
    }

    public function addHasHeaders($headers) : SegmentM3U
    {
        if (is_array($headers)) {
            $this->availableHashHeaders = array_merge($this->availableHashHeaders, $headers);
        } else {
            $this->availableHashHeaders[] = $headers;
        }

        return $this;
    }

    public function attachSource(string $source) : SegmentM3U
    {
        $s = @file_get_contents($source);

        if ($s === false) {
            return $this;
        }

        $this->source = $s;
        $this->sourceWithout = preg_replace('/[a-zA-Z0-9_-]+.(m3u8|json)/', '', $source);
        return $this;
    }

    public function parse() : SegmentM3U
    {
        $this->dirtyItems = preg_split('/\r\n|\r|\n/', trim($this->getSource()));
        // break #EXTM3U
        $this->dirtyItems = array_slice($this->dirtyItems, 1);

        foreach ($this->dirtyItems as $key => $dirtyItem) {
            if (strpos($dirtyItem, '#EXT-X-ENDLIST') !== false) {
                $this->setEnding(true);

                break;
            }

            if (strpos($dirtyItem, '#EXT-X-STREAM-INF') !== false) {
                /**
                 * #EXT-X-STREAM-INF:PROGRAM-ID=1,BANDWIDTH=2170000,CODECS="mp4a.40.2,avc1.64001f",RESOLUTION=960x540,NAME="540p"
                 * vh1w/playlist.m3u8
                 */
                $this->addFragment(
                    new FragmentM3UItem(
                        $dirtyItem, $this->dirtyItems[$key + 1]
                    )
                );

                continue;
            }

            /**
             * Parse Headers
             */
            if (strpos($dirtyItem, '#EXT-X') !== false) {
                list($hashItem, $hashValue) = $count = explode(':', $dirtyItem);

                if (in_array($hashItem, $this->availableHashHeaders)) {
                    $this->hashHeaders[$hashItem] = $hashValue;
                    continue;
                }
            }

            if (strpos($dirtyItem, '#EXTINF') !== false) {
                if ($this->getIsFragmentSource() === true) {
                    $this->setIsFragmentSource(false);
                }

                /**
                 * $key =       #EXTINF:6,no desc
                 * $key + 1 =   segment-1582357592-01571884.ts
                 */
                $segment = new SegmentM3UItem(
                    $dirtyItem, $this->dirtyItems[$key + 1]
                );

                $this->addSegment(
                    $segment
                );

                $this->incDuration($segment->duration);

                continue;
            }
        }

        return $this;
    }
}
