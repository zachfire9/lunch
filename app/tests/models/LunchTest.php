<?php
class LunchTest extends TestCase
{
    /**
     * Testing the create method.
     * 
     * @return null
     */
    public function testCreate()
    {
        $restaurantMock = $this->getMockBuilder('Restaurant')
                               ->setMethods(array('getAll'))
                               ->getMock();

        $restaurants = (object) array(
            (object) array(
                'id' => 1,
                'user_id' => 1,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
            (object) array(
                'id' => 2,
                'user_id' => 1,
                'name' => 'Taco Bell',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
        );

        $restaurantMock->expects($this->any())
                       ->method('getAll')
                       ->willReturn($restaurants);

        $userMock = $this->getMockBuilder('User')
                         ->setMethods(array('getFriends'))
                         ->getMock();

        $friends = (object) array(
            (object) array(
                'id' => 2,
                'user_id' => 1,
                'friend_id' => 2,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
        );

        $userMock->expects($this->any())
                 ->method('getFriends')
                 ->willReturn($friends);

        $expectedResult = array(
            'restaurants' => $restaurants,
            'friends' => $friends,
        );

        $lunch = new App\Models\Lunch();
        $lunch->setRestaurant($restaurantMock);
        $lunch->setUser($userMock);
        $actualResult = $lunch->create(1);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * Testing the create method.
     * 
     * @return null
     */
    public function testStore()
    {
        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods(array('addFriends', 'addRestaurants', 'save'))
                          ->getMock();

        $lunchFriends = array(
            array(
                'lunch_id' => 1, 
                'friend_id' => 1,
            ),
            array(
                'lunch_id' => 1, 
                'friend_id' => 2,
            ),
        );

        $lunchMock->expects($this->once())
                  ->method('addFriends')
                  ->with($this->equalTo($lunchFriends));

        $lunchRestaurants = array(
            array(
                'lunch_id' => 1, 
                'restaurant_id' => 1,
            ),
        );

        $lunchMock->expects($this->once())
                  ->method('addRestaurants')
                  ->with($this->equalTo($lunchRestaurants));

        $lunchMock->expects($this->once())
                  ->method('save')
                  ->willReturn(true);

        $lunchMock->id = 1;

        $lunch = new App\Models\Lunch();
        $lunch->setLunch($lunchMock);

        $input = array(
            'deadline' => '2015-10-17 00:00:00',
            'restaurant_1' => 1,
            'friend_2' => 2,
        );

        $actualResult = $lunch->store(1, $input);

        $this->assertTrue($actualResult);
    }

    /**
     * Testing the edit method.
     * 
     * @return null
     */
    public function testEdit()
    {
        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods(array('getOne', 'getFriendsFull', 'getRestaurantsFull'))
                          ->getMock();

        $lunchData = array(
            'id' => 1,
        );

        $lunchMock->expects($this->once())
                  ->method('getOne')
                  ->willReturn($lunchData);

        $lunchMock->expects($this->once())
                  ->method('getFriendsFull')
                  ->willReturn(array());

        $restaurantsData = array(
            (object) array(
                'id' => 3,
                'user_id' => 1,
                'deadline' => '2015-11-11 00:00:00',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'lunch_id' => 9,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'rank' => 1,
                'name' => 'Burger King',
            ),
        );

        $lunchMock->expects($this->once())
                  ->method('getRestaurantsFull')
                  ->willReturn($restaurantsData);

        $userMock = $this->getMockBuilder('User')
                         ->setMethods(array('getFriends', 'getRestaurants'))
                         ->getMock();

        $userRestaurantsData = array(
            (object) array(
                'id' => 1,
                'user_id' => 1,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
            (object) array(
                'id' => 2,
                'user_id' => 1,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
        );

        $userMock->expects($this->once())
                 ->method('getRestaurants')
                 ->willReturn($userRestaurantsData);

        $friends = array(
            (object) array(
                'id' => 2,
                'user_id' => 1,
                'friend_id' => 2,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
        );

        $userMock->expects($this->once())
                 ->method('getFriends')
                 ->willReturn($friends);

        $lunch = new App\Models\Lunch();
        $lunch->setUser($userMock);
        $lunch->setLunch($lunchMock);

        $actualResult = $lunch->edit(1, 1);

        $restaurantsExpected = array(
            1 => (object) array(
                'id' => 1,
                'user_id' => 1,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            2 => (object) array(
                'id' => 2,
                'user_id' => 1,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            3 => (object) array(
                'id' => 3,
                'user_id' => 1,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'checkbox' => false,
                'rank' => 1,
                'lunch_id' => 9,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'deadline' => '2015-11-11 00:00:00',
            ),
        );

        $friendsExpected = array(
            2 => (object) array(
                'id' => 2,
                'user_id' => 1,
                'friend_id' => 2,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
                'selected' => false,
            ),
        );

        $expectedResult = array(
            'lunch' => $lunchData,
            'restaurants' => $restaurantsExpected,
            'friends' => $friendsExpected,
        );

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * Testing the update method.
     * 
     * @return null
     */
    public function testUpdate()
    {
        $lunchMethods = array(
            'addFriend',
            'addRestaurant',
            'addRestaurantRank',
            'deleteFriends',
            'deleteRestaurantRanks',
            'deleteRestaurants', 
            'getFriends', 
            'getOne', 
            'getRestaurant',
            'getRestaurants', 
        );

        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods($lunchMethods)
                          ->getMock();

        $lunchMock->expects($this->any())
                  ->method('addFriend')
                  ->willReturn(true);

        $lunchMock->expects($this->any())
                  ->method('addRestaurant')
                  ->willReturn(true);

        $lunchMock->expects($this->any())
                  ->method('addRestaurantRank')
                  ->willReturn(true);

        $lunchMock->expects($this->any())
                  ->method('deleteFriends')
                  ->willReturn(true);

        $lunchMock->expects($this->once())
                  ->method('deleteRestaurantRanks')
                  ->willReturn(true);

        $lunchMock->expects($this->any())
                  ->method('deleteRestaurants')
                  ->willReturn(true);

        $lunchFriends = array(
            (object) array(
                'id' => 12,
                'lunch_id' => 7,
                'friend_id' => 2,
            ),
        );

        $lunchMock->expects($this->once())
                  ->method('getFriends')
                  ->with($this->equalTo(1))
                  ->willReturn($lunchFriends);

        $lunchDataMock = $this->getMockBuilder('Lunch')
                              ->setMethods(array('save'))
                              ->getMock();

        $lunchDataMock->expects($this->once())
                      ->method('save')
                      ->willReturn(true);

        $lunchDataMock->id = 1;
        $lunchDataMock->deadline = '';

        $lunchMock->expects($this->once())
                  ->method('getOne')
                  ->willReturn($lunchDataMock);

        $lunchRestaurant = (object) array(
            'id' => 12,
            'lunch_id' => 7,
            'restaurant_id' => 1,
        );

        $lunchMock->expects($this->any())
                  ->method('getRestaurant')
                  ->willReturn($lunchRestaurant);

        $lunchRestaurants = array(
            (object) array(
                'id' => 12,
                'lunch_id' => 7,
                'restaurant_id' => 1,
            ),
            (object) array(
                'id' => 18,
                'lunch_id' => 7,
                'restaurant_id' => 3,
            ),
        );

        $lunchMock->expects($this->once())
                  ->method('getRestaurants')
                  ->with($this->equalTo(1))
                  ->willReturn($lunchRestaurants);

        $input = array(
            'deadline' => '2015-10-17 00:00:00',
            'restaurant_1' => 1,
            'restaurant_3' => 3,
            'restaurant_4' => 4,
            'friend_2' => 2,
            'friend_3' => 3,
        );

        $lunch = new App\Models\Lunch();
        $lunch->setLunch($lunchMock);

        $actualResult = $lunch->update(1, 1, $input);

        $this->assertTrue($actualResult);
    }

    /**
     * Testing the destroy method.
     * 
     * @return null
     */
    public function testDestroy()
    {
        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods(array('remove'))
                          ->getMock();

        $lunchMock->expects($this->once())
                  ->method('remove')
                  ->with($this->equalTo(1))
                  ->willReturn(true);

        $lunch = new App\Models\Lunch();
        $lunch->setLunch($lunchMock);

        $actualResult = $lunch->destroy(1);

        $this->assertTrue($actualResult);
    }
}