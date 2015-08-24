<?php
class LunchTest extends TestCase
{
    /**
     * Provider for testCreate.
     * 
     * @return array
     */
    public function providerCreate()
    {
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

        return array(
            array($restaurants, $friends),
        );
    }

    /**
     * Testing the create method.
     *
     * @dataProvider providerCreate
     * @param  object $restaurants Users restaurants
     * @param  object $friends     Users friends
     * @return null
     */
    public function testCreate($restaurants, $friends)
    {
        $restaurantMock = $this->getMockBuilder('Restaurant')
                               ->setMethods(array('getAll'))
                               ->getMock();

        $restaurantMock->expects($this->any())
                       ->method('getAll')
                       ->willReturn($restaurants);

        $userMock = $this->getMockBuilder('User')
                         ->setMethods(array('getFriends'))
                         ->getMock();

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
     * Provider for testStore.
     * 
     * @return array
     */
    public function providerStore()
    {
        $input = array(
            'deadline' => '2015-10-17 00:00:00',
            'restaurant_1' => 1,
            'friend_2' => 2,
        );

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

        $lunchRestaurants = array(
            array(
                'lunch_id' => 1, 
                'restaurant_id' => 1,
            ),
        );

        return array(
            array($input, $lunchFriends, $lunchRestaurants),
        );
    }

    /**
     * Testing the create method.
     * 
     * @dataProvider providerStore
     * @param  object $input            Input from user
     * @param  object $lunchFriends     Friends to add to lunch
     * @param  object $lunchRestaurants Restaurants to add to lunch
     * @return null
     */
    public function testStore($input, $lunchFriends, $lunchRestaurants)
    {
        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods(array('addFriends', 'addRestaurants', 'save'))
                          ->getMock();

        $lunchMock->expects($this->once())
                  ->method('addFriends')
                  ->with($this->equalTo($lunchFriends));

        $lunchMock->expects($this->once())
                  ->method('addRestaurants')
                  ->with($this->equalTo($lunchRestaurants));

        $lunchMock->expects($this->once())
                  ->method('save')
                  ->willReturn(true);

        $lunchMock->id = 1;

        $lunch = new App\Models\Lunch();
        $lunch->setLunch($lunchMock);

        $actualResult = $lunch->store(1, $input);

        $this->assertTrue($actualResult);
    }

    /**
     * Provider for testEdit.
     * 
     * @return array
     */
    public function providerEdit()
    {
        $lunchId = 1;
        $userId = 1;

        $lunchData = array(
            'id' => $lunchId,
        );

        $restaurantsData = array(
            (object) array(
                'id' => 3,
                'user_id' => 5,
                'deadline' => '2015-11-11 00:00:00',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'rank' => 1,
                'rank_user_id' => $userId,
                'name' => 'Burger King',
            ),
        );

        $userRestaurantsData = array(
            (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
            (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
        );

        $friends = array(
            (object) array(
                'id' => 3,
                'user_id' => 3,
                'friend_id' => 3,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
            (object) array(
                'id' => 5,
                'user_id' => 5,
                'friend_id' => 5,
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

        $friendsFull = array(
            (object) array(
                'id' => 1,
                'user_id' => $userId,
                'friend_id' => 1,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
            (object) array(
                'id' => 2,
                'user_id' => 2,
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
            (object) array(
                'id' => 3,
                'user_id' => 3,
                'friend_id' => 3,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
            (object) array(
                'id' => 4,
                'user_id' => 4,
                'friend_id' => 4,
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

        $restaurantsExpected = array(
            1 => (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            2 => (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            3 => (object) array(
                'id' => 3,
                'user_id' => 5,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'checkbox' => false,
                'rank' => 1,
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'deadline' => '2015-11-11 00:00:00',
                'rank_user_id' => $userId,
            ),
        );

        $friendsExpected = array(
            2 => (object) array(
                'id' => 2,
                'user_id' => 2,
                'friend_id' => 2,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
                'selected' => true,
                'edit' => false,
            ),
            3 => (object) array(
                'id' => 3,
                'user_id' => 3,
                'friend_id' => 3,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
                'selected' => true,
                'edit' => true,
            ),
            4 => (object) array(
                'id' => 4,
                'user_id' => 4,
                'friend_id' => 4,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
                'selected' => true,
                'edit' => false,
            ),
            5 => (object) array(
                'id' => 5,
                'user_id' => 5,
                'friend_id' => 5,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
                'selected' => false,
                'edit' => true,
            ),
        );

        $input = array(
          'user_id' => $userId,
          'lunch_id' => $lunchId,
        );

        $mockData = array(
            'lunchData' => $lunchData,
            'restaurantsData' => $restaurantsData,
            'userRestaurantsData' => $userRestaurantsData,
            'friends' => $friends,
            'friendsFull' => $friendsFull,
        );

        $expectedResult = array(
            'lunch' => $lunchData,
            'restaurants' => $restaurantsExpected,
            'friends' => $friendsExpected,
        );

        $testA = array($input, $mockData, $expectedResult);

        $friendsFull = array(
            (object) array(
                'id' => 1,
                'user_id' => $userId,
                'friend_id' => 1,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
            ),
            (object) array(
                'id' => 2,
                'user_id' => 2,
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

        $friendsExpected = array(
            2 => (object) array(
                'id' => 2,
                'user_id' => 2,
                'friend_id' => 2,
                'username' => 'test',
                'email' => 'test@aol.com',
                'password' => 'test',
                'first_name' => 'Test',
                'last_name' => 'Name',
                'remember_token' => '',
                'created_at' => '2015-03-18 02:19:01',
                'updated_at' => '2015-03-18 02:19:01',
                'selected' => true,
                'edit' => false,
            ),
        );

        $restaurantsData = array(
            (object) array(
                'id' => 3,
                'user_id' => 5,
                'deadline' => '2015-11-11 00:00:00',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'rank' => 1,
                'rank_user_id' => 10,
                'name' => 'Burger King',
            ),
        );

        $restaurantsExpected = array(
            1 => (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            2 => (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            3 => (object) array(
                'id' => 3,
                'user_id' => 5,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'checkbox' => false,
                'rank' => 0,
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'deadline' => '2015-11-11 00:00:00',
                'rank_user_id' => 10,
            ),
        );

        $mockData = array(
            'lunchData' => $lunchData,
            'restaurantsData' => $restaurantsData,
            'userRestaurantsData' => $userRestaurantsData,
            'friends' => array(),
            'friendsFull' => $friendsFull,
        );

        $expectedResult = array(
            'lunch' => $lunchData,
            'restaurants' => $restaurantsExpected,
            'friends' => $friendsExpected,
        );

        $testB = array($input, $mockData, $expectedResult);

        $restaurantsData = array(
            (object) array(
                'id' => 3,
                'user_id' => $userId,
                'deadline' => '2015-11-11 00:00:00',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'rank' => 1,
                'rank_user_id' => 10,
                'name' => 'Burger King',
            ),
        );

        $userRestaurantsData = array(
            (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
            (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
            (object) array(
                'id' => 3,
                'user_id' => $userId,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
        );

        $restaurantsExpected = array(
            1 => (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            2 => (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            3 => (object) array(
                'id' => 3,
                'user_id' => $userId,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => true,
                'checkbox' => true,
                'rank' => 0,
            ),
        );

        $mockData = array(
            'lunchData' => $lunchData,
            'restaurantsData' => $restaurantsData,
            'userRestaurantsData' => $userRestaurantsData,
            'friends' => array(),
            'friendsFull' => $friendsFull,
        );

        $expectedResult = array(
            'lunch' => $lunchData,
            'restaurants' => $restaurantsExpected,
            'friends' => $friendsExpected,
        );

        $testC = array($input, $mockData, $expectedResult);

        // Checking to make sure rankings are not overwritten

        $restaurantsData = array(
            (object) array(
                'id' => 3,
                'user_id' => $userId,
                'deadline' => '2015-11-11 00:00:00',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'rank' => 1,
                'rank_user_id' => $userId,
                'name' => 'Burger King',
            ),
            (object) array(
                'id' => 3,
                'user_id' => $userId,
                'deadline' => '2015-11-11 00:00:00',
                'created_at' => '2015-03-18 02:20:45',
                'updated_at' => '2015-03-18 02:20:45',
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
                'lunch_restaurant_id' => 26,
                'rank' => 1,
                'rank_user_id' => 10,
                'name' => 'Burger King',
            ),
        );

        $userRestaurantsData = array(
            (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
            (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
            (object) array(
                'id' => 3,
                'user_id' => $userId,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
            ),
        );

        $restaurantsExpected = array(
            1 => (object) array(
                'id' => 1,
                'user_id' => $userId,
                'name' => 'Five Guys',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            2 => (object) array(
                'id' => 2,
                'user_id' => $userId,
                'name' => 'Tijuana Flats',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => false,
                'checkbox' => true,
            ),
            3 => (object) array(
                'id' => 3,
                'user_id' => $userId,
                'name' => 'Burger King',
                'created_at' => '2015-03-18 02:20:29',
                'updated_at' => '2015-03-18 02:20:29',
                'selected' => true,
                'checkbox' => true,
                'rank' => 1,
            ),
        );

        $mockData = array(
            'lunchData' => $lunchData,
            'restaurantsData' => $restaurantsData,
            'userRestaurantsData' => $userRestaurantsData,
            'friends' => array(),
            'friendsFull' => $friendsFull,
        );

        $expectedResult = array(
            'lunch' => $lunchData,
            'restaurants' => $restaurantsExpected,
            'friends' => $friendsExpected,
        );

        $testD = array($input, $mockData, $expectedResult);

        return array(
            $testA,
            $testB,
            $testC,
            $testD,
        );
    }

    /**
     * Testing the edit method.
     *
     * @dataProvider providerEdit
     * @param  array $input           Data sent to the method
     * @param  array $mockData        Data for mocking methods
     * @param  array $expectedResult  Data expected back from the method
     * @return null
     */
    public function testEdit($input, $mockData, $expectedResult)
    {
        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods(array('getOne', 'getFriendsFull', 'getRestaurantsFull'))
                          ->getMock();

        $lunchMock->expects($this->once())
                  ->method('getOne')
                  ->willReturn($mockData['lunchData']);

        $lunchMock->expects($this->once())
                  ->method('getFriendsFull')
                  ->willReturn($mockData['friendsFull']);

        $lunchMock->expects($this->once())
                  ->method('getRestaurantsFull')
                  ->willReturn($mockData['restaurantsData']);

        $userMock = $this->getMockBuilder('User')
                         ->setMethods(array('getFriends', 'getRestaurants'))
                         ->getMock();

        $userMock->expects($this->once())
                 ->method('getRestaurants')
                 ->willReturn($mockData['userRestaurantsData']);

        $userMock->expects($this->once())
                 ->method('getFriends')
                 ->willReturn($mockData['friends']);

        $lunch = new App\Models\Lunch();
        $lunch->setUser($userMock);
        $lunch->setLunch($lunchMock);

        $actualResult = $lunch->edit($input['user_id'], $input['lunch_id']);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * Provider for providerUpdate.
     * 
     * @return array
     */
    public function providerUpdate()
    {
        $lunchId = 7;

        $input = array(
            'deadline' => '2015-10-17 00:00:00',
            'restaurant_1' => 1,
            'restaurant_3' => 3,
            'restaurant_4' => 4,
            'friend_2' => 2,
            'friend_3' => 3,
        );

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

        $lunchFriends = array(
            (object) array(
                'id' => 12,
                'lunch_id' => $lunchId,
                'friend_id' => 2,
            ),
        );

        $lunchRestaurant = (object) array(
            'id' => 12,
            'lunch_id' => $lunchId,
            'restaurant_id' => 1,
        );

        $lunchRestaurants = array(
            (object) array(
                'id' => 12,
                'lunch_id' => $lunchId,
                'restaurant_id' => 1,
            ),
            (object) array(
                'id' => 18,
                'lunch_id' => $lunchId,
                'restaurant_id' => 3,
            ),
        );

        $mockData = array(
            'lunchFriend' => array(
                'lunch_id' => $lunchId,
                'friend_id' => 3,
            ),
            'lunchMethods' => $lunchMethods,
            'lunchFriends' => $lunchFriends,
            'lunchRestaurant' => $lunchRestaurant,
            'lunchRestaurants' => $lunchRestaurants,
        );

        return array(
            array($lunchId, $input, $mockData),
        );
    }

    /**
     * Testing the update method.
     *
     * @dataProvider providerUpdate
     * @param  array $input    Input from user
     * @param  array $mockData Data for mocking methods
     * @return null
     */
    public function testUpdate($lunchId, $input, $mockData)
    {
        $lunchMock = $this->getMockBuilder('Lunch')
                          ->setMethods($mockData['lunchMethods'])
                          ->getMock();

        $lunchMock->expects($this->at(5))
                  ->method('addFriend')
                  ->with($mockData['lunchFriend'])
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

        $lunchMock->expects($this->once())
                  ->method('getFriends')
                  ->with($this->equalTo($lunchId))
                  ->willReturn($mockData['lunchFriends']);

        $lunchDataMock = $this->getMockBuilder('Lunch')
                              ->setMethods(array('save'))
                              ->getMock();

        $lunchDataMock->expects($this->once())
                      ->method('save')
                      ->willReturn(true);

        $lunchDataMock->id = $lunchId;
        $lunchDataMock->deadline = '';

        $lunchMock->expects($this->once())
                  ->method('getOne')
                  ->willReturn($lunchDataMock);

        $lunchMock->expects($this->any())
                  ->method('getRestaurant')
                  ->willReturn($mockData['lunchRestaurant']);

        $lunchMock->expects($this->once())
                  ->method('getRestaurants')
                  ->with($this->equalTo($lunchId))
                  ->willReturn($mockData['lunchRestaurants']);

        $lunch = new App\Models\Lunch();
        $lunch->setLunch($lunchMock);

        $actualResult = $lunch->update(1, $lunchId, $input);

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