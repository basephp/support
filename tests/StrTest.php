<?php  namespace Base;

use Base\Support\Str;

class StrTest extends \PHPUnit\Framework\TestCase
{

    public function testStringCases()
    {
        $string = 'ThIs is My WebSITE!';

        // change the capitalization of strings
        $this->assertEquals(Str::upper($string), 'THIS IS MY WEBSITE!');
        $this->assertEquals(Str::lower($string), 'this is my website!');
        $this->assertEquals(Str::title($string), 'This Is My Website!');

        // check string length
        $this->assertEquals(Str::length($string), 19);

        // test the string limits
        $this->assertEquals(Str::limit($string,5), 'ThIs...');
        $this->assertEquals(Str::limit($string,5,''), 'ThIs');
        $this->assertEquals(Str::limit($string,5,'-'), 'ThIs-');

        // limit words
        $this->assertEquals(Str::words($string,2), 'ThIs is...');
        $this->assertEquals(Str::words('my world is cool',10), 'my world is cool');

        // limit words
        $this->assertEquals(Str::ucfirst('my website'), 'My website');

        $this->assertEquals(Str::substr('my website',0,2), 'my');
    }



    public function testStringUri()
    {
        $string = 'product Name%-4-@&(*)';

        // basic uri check
        $this->assertEquals(Str::uri($string), 'product-name-4');
    }


    public function testStringIs()
    {
        $string = 'This website is the best, I love it so much.';
        $this->assertEquals(Str::is('This website is the best, I love it so much.',$string), true);

        $string = '/php/framework/lib';
        $this->assertEquals(Str::is('*php*',$string), true);

        $string = 'Music can be loud. Music can be soft.';
        $this->assertEquals(Str::is('*can*',$string), true);
        $this->assertEquals(Str::is('',$string), false);
    }


    public function testStringContains()
    {
        $string = 'Music can be loud. Music can be soft.';
        $this->assertEquals(Str::contains($string, ['Music','loud','soft']), true);
        $this->assertEquals(Str::contains($string, 'sdfsdfdsf'), false);
    }

}
