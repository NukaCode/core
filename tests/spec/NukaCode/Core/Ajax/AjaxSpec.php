<?php namespace spec\NukaCode\Core\Ajax;

use Illuminate\Routing\ResponseFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AjaxSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('NukaCode\Core\Ajax\Ajax');

        $this->status->shouldBe('error');
        $this->errors->shouldHaveCount(0);
        $this->data->shouldHaveCount(0);
    }

    function it_adds_data()
    {
        $ajax = $this->addData('test', 'some value');

        $ajax->data->shouldHaveCount(1);
        $ajax->data['test']->shouldEqual('some value');
    }

    function it_adds_an_error()
    {
        $ajax = $this->addError('test', 'some value');

        $ajax->errors->shouldHaveCount(1);
        $ajax->errors['test']->shouldEqual('some value');
    }

    function it_adds_errors()
    {
        $ajax = $this->addErrors(
            [
                'error'         => 'some error 1',
                'another error' => 'some error 2',
                'error'         => 'some error 3'
            ]
        );

        $ajax->errors->shouldHaveCount(2);
        $ajax->errors['error']->shouldEqual('some error 3');
        $ajax->errors['another error']->shouldEqual('some error 2');
    }

    function it_returns_the_errors()
    {
        $ajax = $this->addErrors(
            [
                'error'         => 'some error 1',
                'another error' => 'some error 2',
                'error'         => 'some error 3'
            ]
        );

        $errors = $ajax->getErrors();

        $errors->shouldHaveCount(2);
        $errors['error']->shouldEqual('some error 3');
        $errors['another error']->shouldEqual('some error 2');
    }

    function it_counts_the_errors()
    {
        $ajax = $this->addErrors(
            [
                'error'         => 'some error 1',
                'another error' => 'some error 2',
            ]
        );

        $ajax->errorCount()->shouldBe(2);
    }

    function it_sets_the_status()
    {
        $this->status->shouldBe('error');

        $this->setStatus('success');

        $this->get()->status->shouldBe('success');
    }

    function it_gets_the_status()
    {
        $this->setStatus('error');

        $this->getStatus()->shouldBe('error');
    }
}
