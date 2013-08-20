<?php
namespace Nomnom;

class UnitResolver
{
    /**
     * Pattern to check if is IEC standard unit
     *
     * @var string
     */
    const IEC_PATTERN = '/[A-Z]iB/';

    /**
     * Pattern to check if is SI standard unit
     */
    const SI_PATTERN = '/[A-Zk]B/';

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
     * @throws UnitNotFoundException
     * @return int
     */
    public static function resolve($key)
    {
        if ($key == 'B') return 0;
        $dict = static::$metric;
        if (preg_match(static::IEC_PATTERN, $key))
            $dict = static::$binary;
        if (array_key_exists($key, $dict)) return $dict[$key];
        throw new UnitNotFoundException(sprintf('Unit "%s" not found', $key));
    }


    /**
     * Check if two units are in the same
     * family
     *
     * @param string $first
     * @param string $second
     * @return bool
     */
    public static function unitsAreDifferent($first, $second)
    {
        return
            (preg_match(UnitResolver::SI_PATTERN, $first) && preg_match(UnitResolver::IEC_PATTERN, $second)) ||
            (preg_match(UnitResolver::IEC_PATTERN, $first) && preg_match(UnitResolver::SI_PATTERN, $second));
    }
}