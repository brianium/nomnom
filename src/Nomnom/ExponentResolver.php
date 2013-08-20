<?php
namespace Nomnom;

class ExponentResolver 
{
    /**
     * Pattern to check if is IEC standard prefix
     *
     * @var string
     */
    private static $iec = '/[A-Z]iB/';

    /**
     * Binary lookup table
     *
     * @var array
     */
    private static $binary = array(
        'KiB' => 1,
        'MiB' => 2,
        'GiB' => 3,
        'TiB' => 4,
        'PiB' => 5,
        'EiB' => 6,
        'ZiB' => 7,
        'YiB' => 8
    );

    /**
     * Metric lookup table
     *
     * @var array
     */
    private static $metric = array(
        'KB' => 1,
        'MB' => 2,
        'GB' => 3,
        'TB' => 4,
        'PB' => 5,
        'EB' => 6,
        'ZB' => 7,
        'YB' => 8
    );

    /**
     * Lookup the exponent based on prefix
     *
     * @param $key
     * @throws PrefixNotFoundException
     * @return int
     */
    public static function resolve($key)
    {
        if ($key == 'B') return 0;
        $dict = static::$metric;
        if (preg_match(static::$iec, $key))
            $dict = static::$binary;
        if (array_key_exists($key, $dict)) return $dict[$key];
        throw new PrefixNotFoundException(sprintf('Prefix "%s" not found', $key));
    }
}