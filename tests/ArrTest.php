<?php  namespace Base;

use Base\Support\Arr;

class ArrTest extends \PHPUnit\Framework\TestCase
{

    public function testArrayCheck()
    {
        $this->assertSame(Arr::accessible([1,2,3]), true);
        $this->assertSame(Arr::accessible(), false);
        $this->assertSame(Arr::accessible('test'), false);

        $this->assertSame(Arr::isAssoc([1,2,3]), false);
        $this->assertSame(Arr::isAssoc([1=>[1,2,3],2=>[1,2,3],3=>[1,2,3]]), true);
    }


    public function testArrayExists()
    {
        $array = [
            'key1' => 123,
            'key2' => 456,
            'key3' => 789
        ];

        $this->assertSame(Arr::exists($array,'key1'), true);
        $this->assertSame(Arr::exists($array,'23424'), false);

        $this->assertSame(Arr::first($array), 123);
        $this->assertSame(Arr::last($array), 789);
    }


    public function testArrayActs()
    {
        $array = [
            'key1' => 123,
            'key2' => 456,
            'key3' => 789
        ];

        $arrayCheck = [
            'key0' => '000',
            'key1' => 123,
            'key2' => 456,
            'key3' => 789
        ];

        // add an element to the beginning of an array
        $this->assertSame(Arr::prepend($array,'000','key0'), $arrayCheck);

        // pull an element from the array and remove it
        $this->assertSame(Arr::pull($arrayCheck,'key0'), '000');
        // no item in the array, so lets use a default
        $this->assertSame(Arr::pull($arrayCheck,'key777','defaulted'), 'defaulted');
        // check that both arrays are equal now...
        $this->assertSame($array, $arrayCheck);

        // get all items in teh array except for some values
        $this->assertSame(Arr::except($array,['key1','key2']), ['key3'=>789]);
    }


    public function testArrayDots()
    {
        $array = [
            'config' => [
                'db' => [
                    'driver' => 'mysql',
                    'port' => 3306
                ],
                'views' => [
                    'error' => '404',
                    'debug' => true
                ]
            ],
            'routes' => [
                'action' => 'controller',
                'method' => 'index'
            ]
        ];


        $flatten = [
            'mysql',
            3306,
            '404',
            true,
            'controller',
            'index'
        ];

        // flatten the array
        $this->assertSame(Arr::flatten($array), $flatten);
        // get a variable by dot notation
        $this->assertSame(Arr::get($array,'config.db.driver'), 'mysql');
        // get a variable by dot notation (using default)
        $this->assertSame(Arr::get($array,'config.db.host','localhost'), 'localhost');

    }

}
