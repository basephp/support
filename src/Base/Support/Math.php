<?php

namespace Base\Support;

class Math
{

    /**
     * Add 2 numbers together
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public static function add($a, $b)
    {
        return ($a + $b);
    }


    /**
     * Subtract 2 numbers from eachother
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public static function subtract($a, $b)
    {
        return ($a - $b);
    }


    /**
     * Divide 2 numbers
     * (using a save divide since php likes to throw errors)
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public static function divide($a, $b)
    {
        if ($a == 0 || $b == 0) return 0;

        return ($a / $b);
    }


    /**
     * Multiply 2 numbers
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public static function multiply($a, $b)
    {
        return ($a * $b);
    }


    /**
     * Get the percentage of 2 numbers
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public static function percent($a, $b , $percent = true)
    {
        $total = $a;
        $num = $b;

        if ($b < $a) {
            $total = $b;
            $num = $a;
        }

        $number = self::divide($total, $num);

        // return the number as a float (0.00)
        if ($percent == false) return $number;

        // return the number as a true percent 0%
        return self::multiply($number, 100);
    }


    /**
     * Round a number
     *
     * @param int $num
     * @param int $decmial
     * @return int
     */
    public static function round($num, $decmial = 0)
    {
        return round($num, $decmial);
    }

}
