<?php
namespace Nomnom;

class Nomnom 
{
    /**
     * The number to convert
     *
     * @var float|int
     */
    private $start = 0;

    /**
     * Which base to convert from/to
     *
     * @var float
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
     * The unit to convert to
     *
     * @param $unit
     * @param null $precision
     * @return float|string
     */
    public function to($unit, $precision = null)
    {
        $fromBase = UnitResolver::resolve($this->from);
        $toBase = UnitResolver::resolve($unit);
        $this->setBase($unit);
        if ($toBase > $fromBase)
            return $this->div($this->start, pow(1024, $toBase - $fromBase), $precision);
        return $this->mul($this->start, pow(1024, $fromBase - $toBase), $precision);
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
     * Use bcdiv if precision is specified
     * otherwise use native division operator
     *
     * @param $left
     * @param $right
     * @param $precision
     * @return float|string
     */
    protected function div($left, $right, $precision)
    {
        if (is_null($precision)) return $left / $right;
        return bcdiv($left, $right, $precision);
    }

    /**
     * Use bcmul if precision is specified
     * otherwise use native multiplication operator
     *
     * @param $left
     * @param $right
     * @param $precision
     * @return string
     */
    protected function mul($left, $right, $precision)
    {
        if (is_null($precision)) return $left * $right;
        return bcmul($left, $right, $precision);
    }

    /**
     * @param $unit
     * @throws ConversionException
     */
    protected function setBase($unit)
    {
        if ($this->from == 'B' && !preg_match(UnitResolver::IEC_PATTERN, $unit))
            $this->base = 10;
        if (UnitResolver::unitsAreDifferent($this->from, $unit))
            throw new ConversionException("Cannot convert between metric and binary formats");
    }
}