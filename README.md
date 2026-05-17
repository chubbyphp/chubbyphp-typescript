# chubbyphp-typescript

[![CI](https://github.com/chubbyphp/chubbyphp-typescript/actions/workflows/ci.yml/badge.svg)](https://github.com/chubbyphp/chubbyphp-typescript/actions/workflows/ci.yml)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-typescript/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-typescript?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fchubbyphp%2Fchubbyphp-typescript%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/chubbyphp/chubbyphp-typescript/master)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-typescript/v)](https://packagist.org/packages/chubbyphp/chubbyphp-typescript)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-typescript/downloads)](https://packagist.org/packages/chubbyphp/chubbyphp-typescript)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-typescript/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-typescript)

[![bugs](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=bugs)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![code_smells](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=code_smells)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![coverage](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=coverage)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![duplicated_lines_density](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=duplicated_lines_density)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![ncloc](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=ncloc)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![sqale_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![alert_status](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=alert_status)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![reliability_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![security_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=security_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![sqale_index](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=sqale_index)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)
[![vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-typescript&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-typescript)


## Description

PHP port of JavaScript's Array API with TypeScript-style generics.

## Requirements

 * php: ^8.3

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-typescript][1].

```sh
composer require chubbyphp/chubbyphp-typescript "^1.0"
```

## Usage

### Arr (Array)

A PHP port of the JavaScript `Array` class. See the [full documentation](doc/Arr.md) for API reference and examples.

```php
use Chubbyphp\Typescript\Arr;

$arr = new Arr(1, 2, 3, 4, 5);
$arr->push(6);
$arr->pop();
$arr->map(static fn (int $v): int => $v ** 2);
// iterator_to_array($arr->values()) => [1, 4, 9, 16, 25]
```

## Copyright

2026 Dominik Zogg

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-typescript
