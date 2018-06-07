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

        // get multiple...
        $this->assertEquals($collect->get(['sites.timothymarois','sites.johndoe']),[
            'sites.timothymarois' => 'tmarois.com',
            'sites.johndoe' => 'example.com'
        ]);

        // grab many items from the array, using dot notation
        $this->assertEquals($collect->getMany(['sites.timothymarois','sites.another']), ['sites.timothymarois' => 'tmarois.com', 'sites.another' => 'website.com']);

        // set a new item on the array
        $collect->set('author','timothymarois');
        $this->assertEquals($collect->get('author',false), 'timothymarois');

        // replace existing item on the array
        $collect->set('author','jamesdean');
        $this->assertEquals($collect->get('author',false), 'jamesdean');


        $collect = new Collection([
            'timothymarois' => 'tmarois.com',
            'johndoe' => 'example.com',
            'another' => 'website.com'
        ]);

        $this->assertEquals($collect->first(), 'tmarois.com' );
        $this->assertEquals($collect->last(), 'website.com' );

        // reverse, and return a new collection
        $newCollection = $collect->reverse();

        $this->assertEquals($newCollection->first(), 'website.com' );
        $this->assertEquals($newCollection->last(), 'tmarois.com' );

        // remove an item in the collection
        $collect->remove('timothymarois');
        $this->assertEquals($collect->first(), 'example.com' );
        $this->assertEquals($collect->count(), 2 );

        // take only 1 item from the array
        $this->assertEquals($collect->take(1)->all(), ['johndoe' => 'example.com']);

        // implode all items on a string
        $this->assertEquals($collect->implode(',','.'), 'example.com,website.com');
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


    public function testDefined()
    {
        $collect = new Collection([
            'sites' =>
                [
                    'timothymarois' => 'tmarois.com',
                    'johndoe' => 'example.com',
                    'another' => 'website.com'
                ]
        ]);

        $this->assertEquals($collect->has('sites'),true);
        $this->assertEquals($collect->has('sites.timothymarois'),true);
        $this->assertEquals($collect->has('doesnotexist'),false);

    }

}
