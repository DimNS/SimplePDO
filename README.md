# Simple PDO Wrapper class for MySQL and SQLite

[![Latest Stable Version](https://poser.pugx.org/dimns/simplepdo/v/stable)](https://packagist.org/packages/dimns/simplepdo)
[![Total Downloads](https://poser.pugx.org/dimns/simplepdo/downloads)](https://packagist.org/packages/dimns/simplepdo)
[![License](https://poser.pugx.org/dimns/simplepdo/license)](https://packagist.org/packages/dimns/simplepdo)

## Requirements
- PHP 5.3 or higher is required.
- PHP extension MySQL or SQLite.

## Composer installation
1. Get [Composer](http://getcomposer.org/).
3. Require SimplePDO with `php composer.phar require dimns/simplepdo` or `composer require dimns/simplepdo` (if the composer is installed globally).
3. Add the following to your application's main PHP file: `require 'vendor/autoload.php';`.

## Usage
```php
// Init class for MySQL (default port 3306)
$db = new DimNS\SimplePDO\MySQL('server', 'dbname', 'username', 'password');
// Or init class for MySQL (override port)
$db = new DimNS\SimplePDO\MySQL('server', 'dbname', 'username', 'password', 3307);
// Or init class for SQLite
$db = new DimNS\SimplePDO\SQLite('/path/to/database/file.sqlite');

// Query without prepared variables
$result = $db->query('SELECT `field1`, `field2` FROM `table`');
echo '<pre>';
print_r($result);
echo '</pre>';

// Query with prepared variables
$result = $db->query('INSERT INTO `table` SET
    `field1` = :field1,
    `field2` = :field2
', [
    'field1' => 'Simple string',
    'field2' => 123,
]);
echo $result;
```

## Return values
1. For `select` and `show` returns an array containing all of the result set rows.
2. For `insert` returns the ID of the inserted row.
3. For all other queries returns the number of rows affected by the SQL statement.