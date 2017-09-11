<?php
namespace CakeTracking\Test\TestCase\Blacklist;

use Cake\TestSuite\TestCase;

use CakeTracking\Blacklists\BlacklistFileRepository;

class BlacklistFileRepositoryTest extends TestCase
{
    protected $repository;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->repository = new BlacklistFileRepository('');
    }
    
    public function tearDown()
    {
        parent::tearDown();
        
        $this->repository = null;
    }
    
    /**
     * Supplies test cases which will ensure that the array will be searchable
     * in either direction.
     *
     * @return array
     */
    public function binarySearchDataProvider()
    {
        $dataArray = ['a', 'b', 'c', 'd', 'E', 'f'];
        
        return [
            //  checks for last element in array
            [
                $dataArray, 'f', 5,
            ],
            //  checks for first element in array
            [
                $dataArray, 'a', 0,
            ],
            //  checks for non existing element
            [
                $dataArray, 'g', -1,
            ],
            //  checks against an empty array
            [
                [], 'l', -1,
            ],
        ];
    }
    
    /**
     * Test that the binary search implementation works properly.
     *
     * @dataProvider binarySearchDataProvider
     *
     * @param array $array
     * @param string $value
     * @param integer $expectedIndex
     */
    public function testBinearSearchValid(array $array, $value, $expectedIndex)
    {
        $determinedIndex = $this->repository->binarySearch($value, $array);
        
        $this->assertEquals($expectedIndex, $determinedIndex);
    }
}
