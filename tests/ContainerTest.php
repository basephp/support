<?php  namespace Base;

use Base\Support\Container;



class ContainerObject
{
    public $test = 9;

	public function handle()
	{
		return 'Yes!';
	}
}


class ContainerObjec2
{
    public $test = 9;

	public function handle()
	{
		return 'Yes!';
	}
}


class ContainerObjec3
{
    public $test = 9;

	public function handle()
	{
		return 'Yes!';
	}
}


class ContainerConstruct
{
    public $test = 0;
    public $text = 'nothing';

	public function __construct($val, $text)
	{
		$this->test = $val;
        $this->text = $text;
	}
}


class ContainerTest extends \PHPUnit\Framework\TestCase
{

    public function testContainerInstance()
    {
        $c1 = new Container();

        $c2 = Container::getInstance();

        $this->assertEquals($c1, $c2);
    }



    public function testMake()
    {
        $c1 = new Container();
        $obj1 = $c1->make('Base\\ContainerObject');

        $this->assertEquals((new ContainerObject()), $obj1);
    }

    public function testGet()
    {
        $c1 = new Container();
        $obj1 = $c1->make('Base\\ContainerObject');

        $this->assertEquals((new ContainerObject()), $c1->get('Base\\ContainerObject'));
    }

    public function testGetChange()
    {
        $c1 = new Container();
        $obj1 = $c1->make('Base\\ContainerObject');
        $obj1->test=10;

        $this->assertEquals($obj1->test, $c1->get('Base\\ContainerObject')->test);
        $this->assertEquals(10, $c1->get('Base\\ContainerObject')->test);
    }




    public function testAliasMake()
    {
        $c1 = new Container();
        $c1->setAlias(['obj1' => 'Base\\ContainerObject']);
        $obj1 = $c1->make('obj1');

        $this->assertEquals((new ContainerObject()), $obj1);
    }


    public function testAliasGet()
    {
        $c1 = new Container();
        $c1->setAlias(['obj1' => 'Base\\ContainerObject']);
        $obj1 = $c1->make('obj1');

        $this->assertEquals((new ContainerObject()), $c1->get('obj1'));
    }


    public function testAliasGetChange()
    {
        $c1 = new Container();
        $c1->setAlias(['obj1' => 'Base\\ContainerObject']);
        $obj1 = $c1->make('obj1');
        $obj1->test=10;

        $this->assertEquals($obj1->test, $c1->get('obj1')->test);
        $this->assertEquals(10, $c1->get('obj1')->test);
    }



    public function testAliasClass()
    {
        $c1 = new Container();
        $c1->setAlias(['obj1' => \Base\ContainerObject::class]);
        $obj1 = $c1->make('obj1');

        $this->assertEquals((new ContainerObject()), $obj1);
    }



    public function testMakeParam()
    {
        $c1 = new Container();
        $obj1 = $c1->make('Base\\ContainerConstruct',['100','hello']);

        $this->assertEquals(100, $obj1->test);
        $this->assertEquals('hello', $obj1->text);
    }



    public function testGetResolved()
    {
        $c1 = new Container();
        $c1->setAlias([
            'obj1' => \Base\ContainerObject::class,
            'obj2' => \Base\ContainerObjec2::class
        ]);

        $c1->make('obj1');
        $c1->make('obj2');

        $this->assertEquals([
            'Base\ContainerObject',
            'Base\ContainerObjec2'
        ], $c1->getResolved());
    }


    public function testGetInstanceKeys()
    {
        $c1 = new Container();
        $c1->setAlias([
            'obj1' => \Base\ContainerObject::class,
            'obj2' => \Base\ContainerObjec2::class
        ]);

        $c1->make('obj1');
        $c1->make('obj2');
        $c1->make('Base\\ContainerObjec3');

        $this->assertEquals([
            'Base\\ContainerObject',
            'Base\\ContainerObjec2',
            'Base\\ContainerObjec3'
        ], array_keys($c1->getInstances()));

        $this->assertEquals($c1->getResolved(), array_keys($c1->getInstances()));
    }



    public function testForgetInstances()
    {
        $c1 = new Container();
        $c1->setAlias([
            'obj1' => \Base\ContainerObject::class,
            'obj2' => \Base\ContainerObjec2::class
        ]);

        $c1->make('obj1');
        $c1->make('obj2');
        $c1->make('Base\\ContainerObjec3');

        $this->assertEquals([
            'Base\\ContainerObject',
            'Base\\ContainerObjec2',
            'Base\\ContainerObjec3'
        ], array_keys($c1->getInstances()));

        $this->assertEquals($c1->getResolved(), array_keys($c1->getInstances()));

        $c1->forgetInstances();

        $this->assertEquals($c1->getResolved(), array_keys($c1->getInstances()));
        $this->assertEquals([], $c1->getResolved());
        $this->assertEquals([], array_keys($c1->getInstances()));
    }



    public function testForgetInstance()
    {
        $c1 = new Container();
        $c1->setAlias([
            'obj1' => \Base\ContainerObject::class,
            'obj2' => \Base\ContainerObjec2::class
        ]);

        $c1->make('obj1');
        $c1->make('obj2');
        $c1->make('Base\\ContainerObjec3');

        $this->assertEquals([
            'Base\\ContainerObject',
            'Base\\ContainerObjec2',
            'Base\\ContainerObjec3'
        ], array_keys($c1->getInstances()));

        $this->assertEquals($c1->getResolved(), array_keys($c1->getInstances()));

        $c1->forgetInstance('obj2');

        $this->assertEquals(array_values($c1->getResolved()), array_keys($c1->getInstances()));
        $this->assertEquals([
            'Base\\ContainerObject',
            'Base\\ContainerObjec3'
        ], array_values($c1->getResolved()));
    }

}
