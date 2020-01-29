<div align="center">
    <h1>m3u Content Parser</h1>
    <h5>Minimalistic, functional and easy to use playlist parser</h5>
</div>

### Example usage

```php

use zikwall\m3ucontentparser\M3UContentParser;
use zikwall\m3ucontentparser\M3UItem;

$parser = new M3UContentParser('https://iptv-org.github.io/iptv/countries/ru.m3u');
$parser->parse();

foreach ($parser->limit(20)->all() as $item) {
    /**
     * @var $item M3UItem
     */
    echo
        $item->getTvgName(),    PHP_EOL,
        $item->getTvgLogo(),    PHP_EOL,
        $item->getTvgUrl(),     PHP_EOL,
        $item->getGroupTitle(), PHP_EOL,
        $item->getId(),         PHP_EOL;
        $item->getGroupId();
}

```

### API

1. The parser constructor accepts a link or file path:
`$parser = new M3UContentParser('https://iptv-org.github.io/iptv/countries/ru.m3u');`

2. Parsing is called by the same method:
`$parser->parse();`

3. TODO

### Installation

`composer require zikwall/m3u-content-parser`

### Develop Mode

``
{
    "minimum-stability": "dev",
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/zikwall/m3u-content-parser.git"
        }
    ],
    "require": {
        "zikwall/m3u-content-parser: "dev-master"
    }
}
``