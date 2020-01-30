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
        $item->getGroupId(),    PHP_EOL,
        $item->getLanguage(),   PHP_EOL,
        $item->getCountry();
}

```

### API

1. The parser constructor accepts a link or file path:
```php
$parser = new M3UContentParser('https://iptv-org.github.io/iptv/countries/ru.m3u');
```

2. Parsing is called by the same method:
```php
$parser->parse();
```

### Methods in m3u parser

- [x] `getCahce()`
- [x] `getResfresh()`
- [x] `getTvgUrl()`
- [x] `limit(int)`
- [x] `offset(int)`
- [x] `all()`
- [x] `getItems()`

### Methods in m3u item object

- [x] `getId()`
- [x] `getTvgId()`
- [x] `getTvgName()`
- [x] `getTvgUrl()`
- [x] `getTvgLogo()`
- [x] `getTvgShift()`
- [x] `getGroupId()`
- [x] `getGroupTitle()`
- [x] `getExtGrp()`
- [x] `getCensored()`
- [x] `getLanguage()`
- [x] `getCountry()`
- [x] `getAudioTrack()`
- [x] `getAudioTrackNum()`
- [x] `getExtraAttributes()`

### Installation

`composer require zikwall/m3u-content-parser`

### Develop Mode

```json
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
```

#### Questions?

For all questions and suggestions - welcome to Issues
