<?php

namespace Teto\Wonderland;

/**
 * @runTestsInSeparateProcesses
 */
final class AliasLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        \Teto\AliasLoader::unregisterAutoloader();
        parent::setUp();
    }

    public function test()
    {
        \Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\Miracle', 'AwesomeClass');

        $expected = "It's miracle!";

        $this->assertEquals($expected, AwesomeClass::awesome_method());
    }

    public function test_miss_setting()
    {
        \Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\SettingMiss', 'AwesomeClass');

        $message = '/Class \'?\\\\Deep\\\\Nested\\\\Library\\\\Module\\\\Awesome\\\\SettingMiss\'? not found/';
        $this->setExpectedExceptionRegExp(\PHPUnit_Framework_Error_Warning::class, $message);

        AwesomeClass::awesome_method();
    }

    public function test_ClassNotFound()
    {
        \Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\Miracle', 'AwesomeClass');

        $this->assertFalse(class_exists('AwesomeNotFound', true));
    }

    /**
     * @dataProvider dataProviderFor_test_resolve
     */
    public function test_resolve($expected, $input, array $alias_map)
    {
        $actual = \Teto\AliasLoader::resolve($alias_map, $input);

        $this->assertEquals($expected, $actual);
    }

    public function dataProviderFor_test_resolve()
    {
        $alias_map = array_flip([
            'MyProject\Model\User' => 'UserModel',
            'MyProject\Util\Param' => 'Param',
            'MyProject\App\Hoge'   => 'Hoge',
            'stdClass'             => 'Nurupo',
        ]);

        return [
            [false,                   '\NotFound'  , $alias_map],
            ['\MyProject\Util\Param', '\Param'     , $alias_map],
            ['\MyProject\Model\User', '\UserModel',  $alias_map],
            ['\MyProject\App\Hoge',   '\Hoge',       $alias_map],
            ['\stdClass',             '\Nurupo',     $alias_map],
            [false,                   '\Foo\Class\NotFound'  , $alias_map],
            ['\MyProject\Util\Param', '\Foo\Class\Param'     , $alias_map],
            ['\MyProject\Model\User', '\Foo\Class\UserModel',  $alias_map],
            ['\MyProject\App\Hoge',   '\Foo\Class\Hoge',       $alias_map],
            ['\stdClass',             '\Foo\Class\Nurupo',     $alias_map],
        ];
    }

    public function test_register()
    {
        $original = spl_autoload_functions();

        \Teto\AliasLoader::registerAutoloader();

        $actual = spl_autoload_functions();
        $this->assertCount(count($original) + 1, $actual);

        \Teto\AliasLoader::unregisterAutoloader();

        $this->assertSame($original, spl_autoload_functions());
    }
}
