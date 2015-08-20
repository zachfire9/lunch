<?php 
namespace App\Models;

use Auth;
use Input;
use View;

class Lunch
{
    /**
     * Data source to access lunch data
     * 
     * @var object
     */
    private $lunchDataSource;

    /**
     * Data source to access restaurant data
     * 
     * @var object
     */
    private $restaurantDataSource;

    /**
     * Data source to access user data
     * 
     * @var object
     */
    private $userDataSource;

    /**
     * Get data to populate new lunch.
     *
     * @param  int $userId User id
     * @return array
     */
    public function create($userId)
    {
        $restaurantDataSource = $this->getRestaurant();
        $userDataSource = $this->getUser();

        $restaurants = $restaurantDataSource->getAll();
        $friends = $userDataSource->getFriends($userId);

        return array(
            'restaurants' => $restaurants, 
            'friends' => $friends,
        );
    }

    /**
     * Store a newly created lunch.
     *
     * @param  int   $userId User id
     * @param  array $input  Data from application
     * @return bool
     */
    public function store($userId, $input)
    {
        $lunchDataSource = $this->getLunch();
 
        $lunchDataSource->user_id     = $userId;
        $lunchDataSource->deadline    = $input['deadline'];
 
        $lunchDataSource->save();

        $lunchRestaurants = array();

        foreach ($input as $key => $val) {
            if (preg_match("/^restaurant_/", $key)) {
                $lunchRestaurants[] = array(
                    'lunch_id' => $lunchDataSource->id, 
                    'restaurant_id' => $val,
                );
            }
        }

        $lunchDataSource->addRestaurants($lunchRestaurants);

        $lunchFriends = array(
            array(
                'lunch_id'  => $lunchDataSource->id,
                'friend_id' => $userId,
            )
        );

        foreach ($input as $key => $val) {
            if (preg_match("/^friend_/", $key)) {
                $lunchFriends[] = array(
                    'lunch_id' => $lunchDataSource->id, 
                    'friend_id' => $val,
                );
            }
        }

        $lunchDataSource->addFriends($lunchFriends);

        return true;
    }

    /**
     * Get data to edit existing lunch.
     *
     * @param  int   $userId  User id
     * @param  int   $lunchId Lunch id
     * @return array
     */
    public function edit($userId, $lunchId)
    {
        $userDataSource = $this->getUser();
        $lunchDataSource = $this->getLunch();

        $lunch = $lunchDataSource->getOne($lunchId);

        $lunchRestaurants = $lunchDataSource->getRestaurantsFull($lunchId);

        $restaurantsAll = $userDataSource->getRestaurants($userId);

        $restaurantsList = array();

        foreach ($restaurantsAll as $restaurant) {
            $restaurant->selected = false;
            $restaurant->checkbox = true;
            $restaurantsList[$restaurant->id] = $restaurant;
        }

        foreach ($lunchRestaurants as $restaurant) {
            if (isset($restaurantsList[$restaurant->id])) {
                $restaurantsList[$restaurant->id]->selected = true;
                $restaurantsList[$restaurant->id]->rank = $restaurant->rank;
            } else {
                $restaurantsList[$restaurant->id] = $restaurant;
                $restaurantsList[$restaurant->id]->checkbox = false;
            }
        }

        $lunchFriends = $lunchDataSource->getFriendsFull($lunchId);

        $friendsAll = $userDataSource->getFriends($userId);

        $friendsList = array();

        foreach ($friendsAll as $friend) {
            $friend->selected = false;
            $friend->edit = true;
            $friendsList[$friend->id] = $friend;
        }

        foreach ($lunchFriends as $friend) {
            if ($friend->friend_id !== $userId && isset($friendsList[$friend->id])) {
                $friendsList[$friend->id]->selected = true;
                $friendsList[$friend->id]->edit = true;
            } elseif ($friend->friend_id !== $userId) {
                $friend->selected = true;
                $friend->edit = false;
                $friendsList[$friend->id] = $friend;
            }
        }
 
        return array(
            'lunch' => $lunch, 
            'restaurants' => $restaurantsList,
            'friends' => $friendsList,
        );
    }

    /**
     * Update the specified lunch in storage.
     *
     * @param  int   $userId  User id
     * @param  int   $lunchId Lunch id
     * @param  array $input   Data from application
     * @return bool
     */
    public function update($userId, $lunchId, $input)
    {
        $lunchDataSource = $this->getLunch();

        $lunch = $lunchDataSource->getOne($lunchId);
 
        $lunch->deadline = $input['deadline'];
 
        $lunch->save();

        $lunchRestaurantsCurrent = array();
        $lunchFriendsCurrent = array();

        $results = $lunchDataSource->getRestaurants($lunchId);

        foreach ($results as $result) {
            if (isset($input['restaurant_' . $result->restaurant_id])) {
                $lunchRestaurantsCurrent[$result->restaurant_id] = $result;
            } else {
                $lunchDataSource->deleteRestaurants($result->id);
            }
        }

        $results = $lunchDataSource->getFriends($lunchId);

        foreach ($results as $result) {
            if (isset($input['friend_' . $result->friend_id])) {
                $lunchFriendsCurrent[$result->friend_id] = $result;
            } else {
                $lunchDataSource->deleteFriends($result->id);
            }
        }

        $lunchRestaurants = array();
        $lunchRestaurantRanks = array();
        $lunchFriends = array();

        foreach ($input as $key => $val) {
            if (preg_match("/^restaurant_\d+$/", $key)) {
                $lunchRestaurants[$val] = array(
                    'rank' => 0, 
                );
            }

            if (preg_match("/^restaurant_rank_/", $key)) {
                preg_match("/[0-9]$/", $key, $matches);
                $rank = array_shift($matches);

                $lunchRestaurantRanks[$val] = array(
                    'rank' => $rank, 
                );
            }

            if (preg_match("/^friend_/", $key)) {
                $lunchFriends[] = array(
                    'lunch_id' => $lunch->id, 
                    'friend_id' => $val,
                );
            }
        }

        foreach ($lunchRestaurants as $key => $vals) {
            if (!isset($lunchRestaurantsCurrent[$key])) {
                $record = array(
                    'lunch_id' => $lunchId, 
                    'restaurant_id' => $key,
                );

                $lunchDataSource->addRestaurant($record);
            }

            if (isset($lunchRestaurantRanks[$key])) {
                $lunchRestaurants[$key]['rank'] = $lunchRestaurantRanks[$key]['rank'];
            }
        }

        foreach ($lunchFriends as $lunchFriend) {
            if (!isset($lunchFriendsCurrent[$lunchFriend['friend_id']])) {
                $lunchDataSource->addFriend($lunchFriend);
            }
        }

        $lunchDataSource->deleteRestaurantRanks($lunchId, $userId); 

        foreach ($lunchRestaurants as $key => $vals) {
            $lunchRestaurant = $lunchDataSource->getRestaurant($lunchId, $key);

            $record = array(
                'lunch_restaurant_id' => $lunchRestaurant->id,
                'user_id' => $userId,
                'rank' => $vals['rank'],
            );

            $lunchDataSource->addRestaurantRank($record);
        }

        return true;
    }

    /**
     * Remove the specified lunch from storage.
     *
     * @param  int  $lunchId Lunch id
     * @return Response
     */
    public function destroy($lunchId)
    {
        $lunchDataSource = $this->getLunch();

        return $lunchDataSource->remove($lunchId);
    }

    /**
     * Set lunch data source
     * 
     * @param object $lunch Lunch data source
     */
    public function setLunch($lunch)
    {
        $this->lunchDataSource = $lunch;
    }

    /**
     * Get lunch data source
     * 
     * @return object
     */
    public function getLunch()
    {
        $lunch = new Database\Lunch();

        if (isset($this->lunchDataSource)) {
            $lunch = $this->lunchDataSource;
        }

        return $lunch;
    }

    /**
     * Set restaurant data source
     * 
     * @param object $restaurant Restaurant data source
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurantDataSource = $restaurant;
    }

    /**
     * Get restaurant data source
     * 
     * @return object
     */
    public function getRestaurant()
    {
        $restaurant = new Database\Restaurant();

        if (isset($this->restaurantDataSource)) {
            $restaurant = $this->restaurantDataSource;
        }

        return $restaurant;
    }

    /**
     * Set user data source
     * 
     * @param object $user User data source
     */
    public function setUser($user)
    {
        $this->userDataSource = $user;
    }

    /**
     * Get user data source
     * 
     * @return object
     */
    public function getUser()
    {
        $user = new Database\User();

        if (isset($this->userDataSource)) {
            $user = $this->userDataSource;
        }

        return $user;
    }
}