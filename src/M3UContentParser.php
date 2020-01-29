<?php

namespace zikwall\m3ucontentparser;

use zikwall\m3ucontentparser\traits\M3UFinder;

class M3UContentParser
{
    use M3UFinder;

    private $m3uFileContent = '';
    private $dirtyItems = [];
    private $m3uItems = [];
    private $tvgUrl = '';
    private $cache = 0;
    private $refresh = 0;
    private $countItems = 0;
    private $items = [];

    public function __construct(string $file)
    {
        $this->loadFile($file);
    }

    /**
     * @param string $file
     * @throws \Exception
     */
    public function loadFile(string $file)
    {
        $content = file_get_contents($file);

        if (false === $content) {
            throw new \Exception(sprintf('Can\'t read file %s', $file));
        }

        $this->m3uFileContent = $content;
    }

    public function getM3UContent()
    {
        return $this->m3uFileContent;
    }

    /**
     * @param bool $resetDirtyItems
     * @throws \Exception
     */
    public function parse(bool $resetDirtyItems = true) : void
    {
        $this->dirtyItems = preg_split( "/(#EXTINF:0|#EXTINF:-1|#EXTINF:-1,)/", $this->getM3UContent());
        $this->parseAndSetTvgUrl($this->dirtyItems[0]);

        $this->dirtyItems = array_slice($this->dirtyItems, 1);

        foreach ($this->dirtyItems as $key => $item) {
            $this->items[] = new M3UItem($item);

            if ($resetDirtyItems === true) {
                unset($this->dirtyItems[$key]);
            }

            $this->countItems++;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTvgUrl()
    {
        return $this->tvgUrl;
    }

    public function parseAndSetTvgUrl($url)
    {
        if (preg_match('/"([^"]+)"/', $url, $m)) {
            $this->tvgUrl = $m[1];
        }
    }

    public function offset(int $offset) : M3UContentParser
    {
        $this->offset = $offset;
        return $this;
    }

    public function limit(int $limit) : M3UContentParser
    {
        $this->limit = $limit;
        return $this;
    }

    private function executeAll() {}

    public function all() : array
    {
        $this->executeAll();

        if ($this->limit === 0) {
            $this->limit = $this->countItems;
        }

        return array_slice($this->getItems(), $this->offset, $this->limit);
    }
}