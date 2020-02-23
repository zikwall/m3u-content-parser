<?php

namespace zikwall\m3ucontentparser\traits;

trait SegmentM3U8Getters
{
    public function getSource() : string
    {
        return $this->source;
    }

    public function getCleanSource() : string
    {
        return $this->sourceWithout;
    }

    public function getNewSource(string $trackSource) : string
    {
        return $this->getCleanSource() . $trackSource;
    }

    public function getDirtyItems() : array
    {
        return $this->dirtyItems;
    }

    public function getHashHeaders() : array
    {
        return $this->hashHeaders;
    }

    public function getSegments() : array
    {
        return $this->segments;
    }

    public function getDuration() : float
    {
        return $this->duration;
    }

    public function getFragments() : array
    {
        return $this->fragments;
    }

    public function getTime() : array
    {
        $hours = floor($this->getDuration() / 3600);
        $minutes = floor(($this->getDuration() / 60) % 60);
        $seconds = $this->getDuration() % 60;

        return [
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            '__string' => "{$hours}:{$minutes}:{$seconds}",
            '__duration' => $this->getDuration(),
        ];
    }

    public function getIsEnding() : bool
    {
        return $this->isEnding;
    }

    public function getIsFragmentSource() : bool
    {
        return $this->isFragmentSource;
    }
}
