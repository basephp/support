<?php  namespace Base;

use Base\Support\Filesystem;


class FileTest extends \PHPUnit\Framework\TestCase
{

    public function testDataDirectory()
    {
        $path = __DIR__.'/data';

        $dir = Filesystem::makeDirectory($path);

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
    }


    public function testDeleteDirectory()
    {
        $path = __DIR__.'/data';

        // delete the file now that we are done with it
        $this->assertEquals(Filesystem::deleteDirectory($path), true);
    }


}
