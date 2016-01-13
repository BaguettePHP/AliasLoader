<?php

namespace Teto\Wonderland;

/**
 * @runTestsInSeparateProcesses
 */
final class AliasLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        \Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\Miracle', 'AwesomeClass');

        $expected = "It's miracle!";

        $this->assertEquals($expected, AwesomeClass::awesome_method());
    }

    public function test_miss_setting()
    {
        \Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\SettingMiss', 'AwesomeClass');

        $message = 'Class \'\Deep\Nested\Library\Module\Awesome\SettingMiss\' not found';
        $this->setExpectedException(\PHPUnit_Framework_Error_Warning::class, $message);

        AwesomeClass::awesome_method();
    }

    public function test_ClassNotFound()
    {
        \Teto\AliasLoader::add('Deep\Nested\Library\Module\Awesome\Miracle', 'AwesomeClass');

        $this->assertFalse(class_exists('AwesomeNotFound', true));
    }
}
