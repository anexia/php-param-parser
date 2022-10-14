param-parser
============

[![PHP version](https://img.shields.io/packagist/v/anexia/param-parser.svg)](https://packagist.org/packages/anexia/param-parser)
[![Test status](https://github.com/anexia/php-param-parser/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/anexia/php-param-parser/actions/workflows/test.yml)
[![Codecov](https://codecov.io/gh/anexia/php-param-parser/branch/main/graph/badge.svg)](https://codecov.io/gh/anexia/php-param-parser)

`param-parser` is a parser library for a param string expression. Those expressions are arbitrary strings with 
placeholders in it, where a placeholder consists of a name, an optional type and a list of options.

# Install

With a correctly set up PHP and composer installation, run:

```bash
composer require anexia/param-parser
```

# Getting started

Examples of param string expressions look as follows:

```
this-is-a-{param:string:option1,option2,option3}-expression
this-is-a-{param:string}-expression
this-is-a-{param}-expression
```

As you see, a param is introduced by an opening curly bracket, followed by the name of the param, a colon, the type of 
the param, another colon and a comma separated list of options. The param configuration gets terminated by a closing 
curly bracket. Note that the type and option configuration are optional, but the name is mandatory.

To parse an expression shown above, use the PHP code as follows:

```php
<?php
use function Anexia\ParamParser\parse;

$result = parse('this-is-a-{param:string:option1,option2,option3}-expression');

$result[0]; // Gets a Anexia\ParamParser\Node\SequenceNode instance
$result[0]->getSequenceValue(); // Gets "this-is-a-" as a string

$result[1]; // Gets a Anexia\ParamParser\Node\ParamNode instance
$result[1]->getParamName(); // Gets "param" as a string
$result[1]->getParamType(); // Gets "string" as a string
$result[1]->getParamOptions(); // Gets ["option1", "option2", "option3"] as an array of strings

$result[2]; // Gets a Anexia\ParamParser\Node\SequenceNode instance
$result[2]->getSequenceValue(); // Gets "-expression" as a string
```

It is also possible to escape opening curly brackets, closing curly brackets, colons and commas as follows:

```php
<?php
use function Anexia\ParamParser\parse;

$result = parse('this-is-a-\{param:string:option1,option2,option3\}-expression');

$result[0]; // Gets a Anexia\ParamParser\Node\SequenceNode instance
$result[0]->getSequenceValue(); // Gets "this-is-a-{param:string:option1,option2,option3}-expression" as a string
```

# Supported versions

|         | Supported |
|---------|-----------|
| PHP 7.1 | ✓         |
| PHP 7.2 | ✓         |
| PHP 7.3 | ✓         |
| PHP 7.4 | ✓         |
| PHP 8.0 | ✓         |
| PHP 8.1 | ✓         |

# List of developers

* Andreas Stocker <AStocker@anexia-it.com>, Lead Developer
