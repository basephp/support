<?php  namespace Base;

use Base\Support\Arr;
use Base\Support\Collection;

class CollectionTest extends \PHPUnit\Framework\TestCase
{

    public function testBasic()
    {
        $collect = new Collection([1,2,3]);

        // check that we get all items
        $this->assertEquals($collect->all(), [1,2,3]);

        // check that we count all items
        $this->assertEquals($collect->count(), 3);
    }


    public function testActions()
    {
        $collect = new Collection([
            'sites' =>
                [
                    'timothymarois' => 'tmarois.com',
                    'johndoe' => 'example.com',
                    'another' => 'website.com'
                ]
        ]);

        // grab an item from array with dot notation
        $this->assertEquals($collect->get('sites.timothymarois'), 'tmarois.com');

        // grab many items from the array, using dot notation
        $this->assertEquals($collect->getMany(['sites.timothymarois','sites.another']), ['sites.timothymarois' => 'tmarois.com', 'sites.another' => 'website.com']);

        // set a new item on the array
        $collect->set('author','timothymarois');
        $this->assertEquals($collect->get('author',false), 'timothymarois');

        // replace existing item on the array
        $collect->set('author','jamesdean');
        $this->assertEquals($collect->get('author',false), 'jamesdean');
    }


    public function testOutput()
    {
        $collect = new Collection(['timothymarois' => 'tmarois.com']);

        // Return all items as an array
        $this->assertEquals($collect->toArray(), ['timothymarois' => 'tmarois.com']);
        // Return all items as an array
        $this->assertEquals($collect->all(), ['timothymarois' => 'tmarois.com']);

        // force it to be returned as a string
        $this->assertEquals((string) $collect, '{"timothymarois":"tmarois.com"}');
        // return it as JSON format
        $this->assertEquals($collect->toJson(), '{"timothymarois":"tmarois.com"}');


    }

}
