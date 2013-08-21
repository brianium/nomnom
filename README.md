Nomnom
======
> Get it? Bytes? Bites?

Nomnom handles file size conversion for PHP 5.3+. It handles both binary (base 2)
and metric (base 10) conversions. It provides a simple interface for converting between
sizes of any type!

Usage
-----
A Nomnom object is constructed with a "start" value that will be converted.
Two methods are defined on this object: `from` and `to`. Each of these methods takes
a metric or binary unit to convert from/to.

The `to` method takes an optional `precision` value to specify how many significant
digits to keep in the result.

```php
$nomnom = new Nomnom(1440000);

//metric conversion to 1.44
$mb = $nomnom->from('B')->to('MB', 2);

$nomnom = new Nomnom(1024);

//binary conversion to 1
$kb = $nomnom->from('kB')->to('MiB');
```

As a convenience, Nomnom provides a factory method called `nom` and constants for the metric
and binary units.

```php
//returns 1.44
Nomnom::nom(1440000)->from(Nomnom::BYTES)->to(Nomnom::MB, 2);
```