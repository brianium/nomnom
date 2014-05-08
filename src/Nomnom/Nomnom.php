<?php
namespace Nomnom;

class Nomnom 
{
    /**
     * Metric and Binary constants
     */
    const BYTES = 'B';
    const kB = 'kB';
    const MB = 'MB';
    const GB = 'GB';
    const TB = 'TB';
    const PB = 'PB';
    const EB = 'EB';
    const ZB = 'ZB';
    const YB = 'YB';
    const KiB = 'KiB';
    const MiB = 'MiB';
    const GiB = 'GiB';
    const TiB = 'TiB';
    const PiB = 'PiB';
    const EiB = 'EiB';
    const ZiB = 'ZiB';
    const YiB = 'YiB';

    /**
     * The number to convert
     *
     * @var float|int
     */
    private $start = 0;

    /**
     * Which base to convert from/to
     *
     * @var int
     */
    private $base = 2;

    /**
     * @var int
     */
    private $from = 0;

    /**
     * Construct
     *
     * @param float $start
     */
    public function __construct($start)
    {
        $this->start = $start;
    }

    /**
     * The unit to convert from
     *
     * @param string $unit
     * @return $this
     */
    public function from($unit)
    {
        $this->from = $unit;
        return $this;
    }

    /**
     * Convert the start value to the given unit.
     * Accepts an optional precision for how many significant digits to
     * retain
     *
     * @param $unit
     * @param int|null $precision
     * @return float
     */
    public function to($unit, $precision = null)
    {
        $fromUnit = UnitResolver::resolve($this->from);
        $toUnit = UnitResolver::resolve($unit);
        $this->setBase($unit);
        $base = $this->getBase() == 2 ? 1024 : 1000;
        //some funky stuff with negative exponents and pow
        if ($toUnit > $fromUnit)
            return $this->div($this->start, pow($base, $toUnit - $fromUnit), $precision);
        return $this->mul($this->start, pow($base, $fromUnit - $toUnit), $precision);
    }

    /**
     * Convert the start value to it's highest whole unit.
     * Accespts an optional precision for how many significant digits
     * to retain
     *
     * @param int|null $precision
     * @return float
     */
    public function toBest($precision = null)
    {
        $fromUnit = UnitResolver::resolve($this->from);
        $base = $this->getBase() == 2 ? 1024 : 1000;
        $converted = $this->start;
        while ($converted >= 1) {
            $fromUnit++;
            $result = $this->div($this->start, pow($base, $fromUnit), $precision);
            if ($result <= 1) return $converted;
            $converted = $result;
        }
        return $converted;
    }

    /**
     * Returns the number base being used by Nomnom
     *
     * @return int
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Return a new Nomnom
     *
     * @param $start
     * @return \Nomnom\Nomnom
     */
    public static function nom($start)
    {
        return new Nomnom($start);
    }

    /**
     * Return a new Filesize
     *
     * @param $file
     * @return \Nomnom\Filesize
     */
    public static function file($file)
    {
        return new Filesize($file);
    }

    /**
     * Use bcdiv if precision is specified
     * otherwise use native division operator
     *
     * @param $left
     * @param $right
     * @param $precision
     * @return float
     */
    protected function div($left, $right, $precision)
    {
        if (is_null($precision)) return $left / $right;
        return floatval(bcdiv($left, $right, $precision));
    }

    /**
     * Use bcmul if precision is specified
     * otherwise use native multiplication operator
     *
     * @param $left
     * @param $right
     * @param $precision
     * @return float
     */
    protected function mul($left, $right, $precision)
    {
        if (is_null($precision)) return $left * $right;
        return floatval(bcmul($left, $right, $precision));
    }

    /**
     * @param $unit
     * @throws ConversionException
     */
    protected function setBase($unit)
    {
        if ($this->shouldSetBaseTen($unit))
            $this->base = 10;
        if (UnitResolver::unitsAreDifferent($this->from, $unit))
            throw new ConversionException("Cannot convert between metric and binary formats");
    }

    /**
     * Match from against the unit to see if
     * the base should be set to 10
     *
     * @param $unit
     * @return bool
     */
    protected function shouldSetBaseTen($unit)
    {
        $unitMatchesIec = preg_match(UnitResolver::IEC_PATTERN, $unit);
        return
            ($this->from == 'B' && !$unitMatchesIec) ||
            (preg_match(UnitResolver::SI_PATTERN, $this->from) && !$unitMatchesIec);
    }
}
