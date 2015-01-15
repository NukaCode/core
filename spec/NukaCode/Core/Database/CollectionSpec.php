<?php namespace spec\NukaCode\Core\Database;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior {

    function let()
    {
        $array = [
            0      => 'Test data numeric index',
            'test' => 'Test data string index'
        ];

        $this->beConstructedWith($array);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('NukaCode\Core\Database\Collection');
    }

    function it_converts_an_array_to_a_collection()
    {
        $this->shouldHaveCount(2);
    }

    function it_gets_values_by_numeric_keys()
    {
        $this->first()->shouldBe('Test data numeric index');
        $this->get(0)->shouldBe('Test data numeric index');
    }

    function it_gets_values_by_string_keys()
    {
        $this->last()->shouldBe('Test data string index');
        $this->get('test')->shouldBe('Test data string index');
    }
}
