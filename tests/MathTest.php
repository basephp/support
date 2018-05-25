<?php  namespace Base;

use Base\Support\Math;


class MathTest extends \PHPUnit\Framework\TestCase
{

    public function testAddition()
    {
        $result = Math::add(5,10);

        $this->assertEquals($result, 15);
    }


    public function testSubtraction()
    {
        $result1 = Math::subtract(6,5);
        $result2 = Math::subtract(5,6);

        $this->assertEquals($result1, 1);
        $this->assertEquals($result2, -1);
    }


    public function testMultiplication()
    {
        $result1 = Math::multiply(1,5);
        $result2 = Math::multiply(0,5);
        $result3 = Math::multiply(5,5);
        $result4 = Math::multiply(5.5,2);

        $this->assertEquals($result1, 5);
        $this->assertEquals($result2, 0);
        $this->assertEquals($result3, 25);
        $this->assertEquals($result4, 11);
    }


    public function testDivision()
    {
        $result1 = Math::divide(10,2);
        $result2 = Math::divide(10,0);

        $this->assertEquals($result1, 5);
        $this->assertEquals($result2, 0);
    }


    public function testRound()
    {
        $result1 = Math::round(10.100);
        $result2 = Math::round(10.100,2);
        $result3 = Math::round(10.100,1);

        $this->assertEquals($result1, 10);
        $this->assertEquals($result2, 10.10);
        $this->assertEquals($result3, 10.1);
    }


    public function testPercent()
    {
        $result1 = Math::percent(50,100);
        $result2 = Math::percent(100,25);
        $result3 = Math::percent(0,100);
        $result4 = Math::percent(100,100);
        $result5 = Math::percent(50,100,false);

        $this->assertEquals($result1, 50);
        $this->assertEquals($result2, 25);
        $this->assertEquals($result3, 0);
        $this->assertEquals($result4, 100);
        $this->assertEquals($result5, 0.5);
    }

}
