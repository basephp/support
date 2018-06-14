<?php  namespace Base;

use Base\Support\Filesystem;


class FileTest extends \PHPUnit\Framework\TestCase
{

    public function testDataDirectory()
    {
        $path = __DIR__.'/data';

        $dir = Filesystem::makeDirectory($path);

        // Test to see if we can make the directory again..
        // should return false.
        $dir2 = Filesystem::makeDirectory($path);
        $this->assertSame($dir2, false);

        // if the directory already exist
        // we cant create it, then we need to empty it...
        if ($dir === false)
        {
            $this->assertSame(Filesystem::empty($path), true);
        }

        $this->assertSame(true, true);
    }


    public function testDirectoryExists()
    {
        $path = __DIR__.'/data';

        // check if the directory is readable
        $this->assertEquals(Filesystem::isReadable($path), true);

        // check that the directory exists
        $this->assertEquals(Filesystem::exists($path), true);

        // Check if this is a directory
        $this->assertEquals(Filesystem::isDirectory($path), true);

        // check that the directory is not a file
        $this->assertEquals(Filesystem::isFile($path), false);

        // check if the directory is writable
        $this->assertEquals(Filesystem::isWritable($path), true);
    }


    public function testNoDirectoryExists()
    {
        // check that this file DOES NOT exists
        $this->assertEquals(Filesystem::exists(__DIR__.'/dataXXX'), false);

        // check that it does not exist
        $this->assertEquals(Filesystem::isDirectory(__DIR__.'/dataXXX'), false);
    }


    public function testNoFileExists()
    {
        // check that this file DOES NOT exists
        $this->assertEquals(Filesystem::exists(__DIR__.'/data/fileXXX.txt'), false);

        // check that it does not exist
        $this->assertEquals(Filesystem::isFile(__DIR__.'/data/fileXXX.txt'), false);

        // check that it does not exist
        $this->assertEquals(Filesystem::get(__DIR__.'/data/fileXXX.txt'), false);
    }


    public function testFileActions()
    {
        $path = __DIR__.'/data/file.txt';

        // Save file and check its bytes
        $this->assertEquals(Filesystem::put($path, 'test'), 4);
        $this->assertEquals(Filesystem::get($path), 'test');

        // check that the file exists
        $this->assertEquals(Filesystem::exists($path), true);
        // check if it is a file
        $this->assertEquals(Filesystem::isFile($path), true);
        // check if this file is a directory
        $this->assertEquals(Filesystem::isDirectory($path), false);

        // Append additional to the file
        $this->assertEquals(Filesystem::append($path, '123'), 3);
        $this->assertEquals(Filesystem::get($path), 'test123');

        // Prepend content to the file
        $this->assertEquals(Filesystem::prepend($path, '555'), 10);
        $this->assertEquals(Filesystem::get($path), '555test123');

        $this->assertEquals(Filesystem::prepend(__DIR__.'/data/file55.txt', '88'), 2);
        $this->assertEquals(Filesystem::get(__DIR__.'/data/file55.txt'), '88');

        $this->assertEquals(Filesystem::name(__DIR__.'/data/file55.txt'), 'file55');

        // check types
        $this->assertEquals(Filesystem::type(__DIR__.'/data/file55.txt'), 'file');
        $this->assertEquals(Filesystem::type(__DIR__.'/data'), 'dir');

        // delete the file now that we are done with it
        $this->assertEquals(Filesystem::delete($path), true);
    }


    public function testMultipleFiles()
    {
        $path = __DIR__.'/data';

        Filesystem::empty($path);

        for ($i=0; $i < 10; $i++)
        {
            Filesystem::put($path.'/test_'.$i.'.txt', 'ABC');
        }

        $files = Filesystem::getAll($path);

        // check if we got all files created.
        $this->assertEquals(count($files), 10);

        // count how many files are in directory
        $this->assertEquals(Filesystem::count($path), 10);


        // lets try to only get the .txt files,
        // first create a random file
        Filesystem::put($path.'/test_na.stub', '1111');

        $files = Filesystem::getAll($path, 'txt');

        $this->assertEquals(count($files), 10);


        $files = Filesystem::getAll($path, 'stub');

        $this->assertEquals(count($files), 1);

        Filesystem::empty($path);
    }


    public function testChmod()
    {
        $path = __DIR__.'/data/chmod.txt';

        Filesystem::put($path, 'test');

        $this->assertEquals('0644', Filesystem::chmod($path));

        // don't believe this is working locally right now...
        $this->assertEquals(true, Filesystem::chmod($path, '0775'));

        // cant test this on local right now...
        // $this->assertEquals('0777', Filesystem::chmod($path));
    }


    public function testCopyMove()
    {
        $path = __DIR__.'/data/444';
        $path2 = __DIR__.'/data/777';

        Filesystem::makeDirectory($path);
        Filesystem::makeDirectory($path2);

        Filesystem::put($path.'/newfile.txt', 'test');

        $this->assertEquals(1, Filesystem::count($path));

        // move files from one directory to another...
        $this->assertEquals(true, Filesystem::move($path.'/newfile.txt', $path2.'/movedfile.txt'));
        $this->assertEquals(1, Filesystem::count($path2));
        $this->assertEquals(0, Filesystem::count($path));
        $this->assertEquals(true, Filesystem::exists($path2.'/movedfile.txt'));

        $this->assertEquals(true, Filesystem::copy($path2.'/movedfile.txt', $path2.'/copyied.txt'));
        $this->assertEquals(2, Filesystem::count($path2));
        $this->assertEquals(true, Filesystem::exists($path2.'/copyied.txt'));
        $this->assertEquals('test', Filesystem::get($path2.'/copyied.txt'));
    }


    public function testDeleteDirectory()
    {
        $path = __DIR__.'/data';

        // delete the file now that we are done with it
        $this->assertEquals(Filesystem::deleteDirectory($path), true);
    }





}
