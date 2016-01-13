Teto AliasLoader
================

[![Package version](http://img.shields.io/packagist/v/zonuexe/aliasloader.svg?style=flat)](https://packagist.org/packages/zonuexe/aliasloader)
[![Build Status](https://travis-ci.org/BaguettePHP/AliasLoader.svg?branch=master)](https://travis-ci.org/BaguettePHP/AliasLoader)
[![Packagist](http://img.shields.io/packagist/dt/zonuexe/aliasloader.svg?style=flat)](https://packagist.org/packages/zonuexe/aliasloader)

Class aliasing for provide flat namespace on your Application.

Note
----

This library is designed for **Application**.  Do not use `AliasLoader` by library code.

Installation
------------

### Composer

```
composer require zonuexe/aliasloader
```

Features
--------

### Before

You have to write `use` statement to each files.

```php
<?php
namespace MyProject\Nested;

use Deep\Nested\Library\Module\Awesome\Miracle as AwesomeClass;

AwesomeClass::awesome_method();

```

### After

```bootstrap.php
<?php

\Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\Miracle', 'AwesomeClass');
```

```
<?php
namespace MyProject\Nested;

AwesomeClass::awesome_method();
```


Copyright
---------

see `./LICENSE`.

    Class aliasing for provide flat namespace on your application
    Copyright (c) 2015 USAMI Kenta <tadsan@zonu.me>

Teto Kasane
-----------

I love [Teto Kasane](http://utau.wikia.com/wiki/Teto_Kasane). (ja: [Teto Kasane official site](http://kasaneteto.jp/))

```
　　　　　 　r /
　 ＿＿ , --ヽ!-- .､＿
　! 　｀/::::;::::ヽ l
　!二二!::／}::::丿ハﾆ|
　!ﾆニ.|:／　ﾉ／ }::::}ｺ
　L二lイ　　0´　0 ,':ﾉｺ
　lヽﾉ/ﾍ､ ''　▽_ノイ ソ
 　ソ´ ／}｀ｽ /￣￣￣￣/
　　　.(_:;つ/  0401 /　ｶﾀｶﾀ
 ￣￣￣￣￣＼/＿＿＿＿/
```
