<?php namespace spec\NukaCode\Core\Database;

use NukaCode\Core\Database\Collection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class CollectionSpec extends ObjectBehavior {

    function let()
    {
        $testData =
        [
            [
                'name' => 'bob',
                'age' => 10,
                'kids' => [
                    'name' => 'zack',
                    'age' => 2
                ]
            ],
            [
                'name' => 'jeff',
                'age' => 15,
                'kids' => [
                    'name' => 'jess',
                    'age' => 3
                ]
            ],
            [
                'name' => 'chris',
                'age' => 20,
                'kids' => [
                    'name' => 'jr',
                    'age' => 4
                ]
            ],
            [
                'name' => 'dug',
                'age' => 25,
                'kids' => [
                    'name' => 'dan',
                    'age' => 5
                ]
            ],
            [
                'name' => 'sam',
                'age' => null,
                'kids' => [
                    'name' => 'jane',
                    'age' => null
                ]
            ]
        ];

        foreach ($testData as $data) {
            $newParent = new stdClass();
            $newParent->name = $data['name'];
            $newParent->age = $data['age'];

            $newParent->kids = new Collection();
            $newChild = new stdClass();
            $newChild->name = $data['kids']['name'];
            $newChild->age = $data['kids']['age'];
            $newParent->kids->add($newChild);
            $this->add($newParent);
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('NukaCode\Core\Database\Collection');
    }

    public function it_gets_results_where_key_is_equal_to_given_value()
    {
        $this->getWhere('name', 'bob')->shouldHaveCount(1);
    }

    public function it_gets_results_that_are_in_a_given_array()
    {
        $this->getWhereIn('age', [10, 15])->shouldHaveCount(2);
    }

    public function it_gets_results_between_two_given_values()
    {
        $this->getWhereBetween('age', [10, 20])->shouldHaveCount(3);
    }

    public function it_gets_results_when_key_is_null()
    {
        $this->getWhereNull('age')->shouldHaveCount(1);
    }

    public function it_gets_results_where_key_is_similar_to_given_value()
    {
        $this->getWhereLike('name', 'hri')->shouldHaveCount(1);
    }

    public function it_gets_results_where_key_is_not_equal_to_given_value()
    {
        $this->getWhereNot('name', 'bob')->shouldHaveCount(4);
    }

    public function it_gets_results_that_are_not_in_a_given_array()
    {
        $this->getWhereNotIn('age', [10, 15])->shouldHaveCount(2);
    }

    public function it_gets_results_that_are_not_between_two_given_values()
    {
        $this->getWhereNotBetween('age', [10, 20])->shouldHaveCount(1);
    }

    public function it_gets_results_when_the_key_is_not_null()
    {
        $this->getWhereNotNull('age')->shouldHaveCount(4);
    }

    public function it_gets_results_where_key_is_not_similar_to_given_value()
    {
        $this->getWhereNotLike('name', 'hri')->shouldHaveCount(4);
    }

    public function it_gets_the_first_result_in_a_given_array()
    {
        $data = $this->getWhereInFirst('age', [10, 15]);

        $data->shouldHaveType('stdClass');
        $data->age->shouldBe(10);
    }

    public function it_gets_the_last_result_in_a_given_array()
    {
        $data = $this->getWhereInLast('age', [10, 15]);

        $data->shouldHaveType('stdClass');
        $data->age->shouldBe(15);
    }

    public function it_taps_through_the_given_key_and_checks_the_given_value()
    {
        $data = $this->getWhere('kids->name', 'jess');

        $data->shouldHaveCount(1);
        $data->first()->name->shouldBe('jeff');
    }

    public function it_taps_through_the_given_key_and_checks_in_array()
    {
        $this->getWhereIn('kids->age', [2, 4])->shouldHaveCount(2);
    }

    public function it_taps_through_the_given_key_and_checks_between_two_given_values()
    {
        $this->getWhereBetween('kids->age', [2, 4])->shouldHaveCount(3);
    }

    public function it_taps_through_the_given_key_and_checks_for_null()
    {
        $this->getWhereNull('kids->age')->shouldHaveCount(1);
    }

    public function it_taps_through_the_given_key_and_checks_for_similar()
    {
        $this->getWhereLike('kids->name', 'es')->shouldHaveCount(1);
    }

    public function it_taps_through_the_given_key_and_checks_not_the_given_value()
    {
        $this->getWhereNot('kids->name', 'dan')->shouldHaveCount(4);
    }

    public function it_taps_through_the_given_key_and_checks_not_in_array()
    {
        $this->getWhereNotIn('kids->age', [2, 4])->shouldHaveCount(2);
    }

    public function it_taps_through_the_given_key_and_checks_not_between_two_given_values()
    {
        $this->getWhereNotBetween('kids->age', [2, 4])->shouldHaveCount(1);
    }

    public function it_taps_through_the_given_key_and_checks_for_not_null()
    {
        $this->getWhereNotNull('kids->age')->shouldHaveCount(4);
    }

    public function it_taps_through_the_given_key_and_checks_for_not_similar()
    {
        $this->getWhereNotLike('kids->name', 'es')->shouldHaveCount(4);
    }

    public function it_taps_through_the_object_to_find_the_first_with_a_given_value()
    {
        $data = $this->getWhereInFirst('kids->age', [2, 4]);

        $data->shouldHaveType('stdClass');
        $data->age->shouldBe(10);
    }

    public function it_taps_through_the_object_to_find_the_last_with_a_given_value()
    {
        $data = $this->getWhereInLast('kids->age', [2, 4]);

        $data->shouldHaveType('stdClass');
        $data->age->shouldBe(20);
    }

    public function it_taps_through_a_collection_and_retrieves_a_collection()
    {
        $data = $this->first()->kids->name;

        $data->first()->shouldBe('zack');
        $data->shouldHaveCount(1);
        $data->shouldHaveType('NukaCode\Core\Database\Collection');
    }
}
