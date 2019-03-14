# Laravel OpenSearch

[![For Laravel 5](https://img.shields.io/badge/laravel-5.*-green.svg)](https://github.com/laravel/laravel)
[![For Lumen 5](https://img.shields.io/badge/lumen-5.*-green.svg)](https://github.com/laravel/lumen)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/homesheer/laravel-opensearch.svg)](https://packagist.org/packages/homesheer/laravel-opensearch)
[![Total Downloads](https://img.shields.io/packagist/dt/homesheer/laravel-opensearch.svg)](https://packagist.org/packages/homesheer/laravel-opensearch)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)

## 介绍


## 要求
`Laravel 5.4`或更新的版本

## 安装

使用`Composer`:

``` bash
composer require homesheer/laravel-opensearch
```

发布配置文件:

```bash
php artisan vendor:publish --provider="HomeSheer\OpenSearch\OpenSearchServiceProvider" --tag="config"
```

`Laravel 5.4`或更低的版本:

```php
// config/app.php
HomeSheer\OpenSearch\OpenSearchServiceProvider::class,
```

Lumen:

```php
// bootstrap/app.php
$app->register(HomeSheer\OpenSearch\OpenSearchServiceProvider::class);
```

## 用法

    
## 贡献

欢迎参与贡献, [致谢这些贡献者](https://github.com/homesheer/laravel-opensearch/graphs/contributors) :)

## 许可证

Laravel Assembler 使用 [MIT 许可证](http://opensource.org/licenses/MIT) 开源.