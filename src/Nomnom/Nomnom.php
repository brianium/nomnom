<?php
namespace Nomnom;

class Nomnom 
{
    /**
     * The conversion base
     *
     * @var float
     */
    private $base = 0;

    /**
     * @var int
     */
    private $from = 0;

    /**
     * Construct
     *
     * @param float $base
     */
    public function __construct($base)
    {
        $this->base = $base;
    }

    /**
     * @param string $unit
     * @return $this
     */
    public function from($unit)
    {
        $this->from = $unit;
        return $this;
    }

    public function to($unit, $precision = null)
    {
        $fromBase = ExponentResolver::resolve($this->from);
        $toBase = ExponentResolver::resolve($unit);
        if ($toBase > $fromBase)
            return $this->div($this->base, pow(1024, $toBase - $fromBase), $precision);
        return $this->mul($this->base, pow(1024, $fromBase - $toBase), $precision);
    }

    protected function div($left, $right, $precision)
    {
        if (is_null($precision)) return $left / $right;
        return bcdiv($left, $right, $precision);
    }

    protected function mul($left, $right, $precision)
    {
        if (is_null($precision)) return $left * $right;
        return bcmul($left, $right, $precision);
    }
}