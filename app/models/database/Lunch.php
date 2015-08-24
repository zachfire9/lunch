<?php
namespace App\Models\Database;

use DB;
use Illuminate\Database\Eloquent\Model;

class Lunch extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lunches';

    /**
     * Get a lunch by id.
     * 
     * @param  int $lunchId Lunch id
     * @return object
     */
    public function getOne($lunchId)
    {
        return $this::find($lunchId);
    }

    /**
     * Delete a lunch by id.
     * 
     * @param  int $lunchId Lunch id
     * @return object
     */
    public function remove($lunchId)
    {
        return $this::destroy($lunchId);
    }

    /**
     * Get restaurant for a lunch by id.
     * 
     * @param  int $lunchId      Lunch id
     * @param  int $restaurantId Restaurant id
     * @return object
     */
    public function getRestaurant($lunchId, $restaurantId)
    {
        return DB::table('lunch_restaurants')
                ->where('lunch_id', '=', $lunchId)
                ->where('restaurant_id', '=', $restaurantId)
                ->first();
    }

    /**
     * Get all restaurants in a lunch.
     * 
     * @param  int $lunchId Lunch id
     * @return object
     */
    public function getRestaurants($lunchId)
    {
        $restaurants = DB::table('lunch_restaurants')
            ->where('lunch_id', '=', $lunchId)
            ->get();

        return $restaurants;
    }

    /**
     * Get full join of restaurants in a lunch.
     * 
     * @param  int $lunchId Lunch id
     * @return object
     */
    public function getRestaurantsFull($lunchId)
    {
        $restaurants = DB::table('lunches')
            ->join('lunch_restaurants', 'lunches.id', '=', 'lunch_restaurants.lunch_id')
            ->leftJoin('lunch_restaurant_ranks', 'lunch_restaurants.id', '=', 'lunch_restaurant_ranks.lunch_restaurant_id')
            ->join('restaurants', 'lunch_restaurants.restaurant_id', '=', 'restaurants.id')
            ->where('lunches.id', $lunchId)
            ->select('lunches.*', 'lunch_restaurants.*', 'lunch_restaurant_ranks.*', 'restaurants.*', 'lunch_restaurant_ranks.user_id AS rank_user_id')
            ->get();

        return $restaurants;
    }

    /**
     * Get friends in a lunch.
     * 
     * @param  int $lunchId Lunch id
     * @return object
     */
    public function getFriends($lunchId)
    {
        $friends = DB::table('lunch_friends')
            ->where('lunch_id', '=', $lunchId)
            ->get();

        return $friends;
    }

    /**
     * Get full join of friends in a lunch.
     * 
     * @param  int $lunchId Lunch id
     * @return object
     */
    public function getFriendsFull($lunchId)
    {
        $friends = DB::table('lunches')
            ->join('lunch_friends', 'lunches.id', '=', 'lunch_friends.lunch_id')
            ->join('users', 'lunch_friends.friend_id', '=', 'users.id')
            ->where('lunches.id', $lunchId)
            ->get();

        return $friends;
    }

    /**
     * Add restaurant to a lunch
     * 
     * @param array $restaurant Restaurant information
     */
    public function addRestaurant($restaurant)
    {
        return DB::table('lunch_restaurants')->insert($restaurant);
    }

    /**
     * Add restaurants to a lunch.
     *
     * @param  array $restaurants Restaurants information
     * @return boolean
     */
    public function addRestaurants($restaurants)
    {
        return DB::table('lunch_restaurants')->insert($restaurants);
    }

    /**
     * Add friend to a lunch.
     * 
     * @param array $friend Friend information
     * @return boolean
     */
    public function addFriend($friend)
    {
        return DB::table('lunch_friends')->insert($friend);
    }

    /**
     * Add restaurants to a lunch.
     *
     * @param  $friends Friends information
     * @return boolean
     */
    public function addFriends($friends)
    {
        return DB::table('lunch_friends')->insert($friends);
    }

    /**
     * Add ranking for restaurant in lunch.
     * 
     * @param array $rank Restaurant ranking
     */
    public function addRestaurantRank($rank)
    {
        return DB::table('lunch_restaurant_ranks')->insert($rank);
    }

    /**
     * Delete all restarant ranks in a lunch.
     * 
     * @param  int $lunchId Lunch id
     * @param  int $userId  User id
     * @return boolean
     */
    public function deleteRestaurantRanks($lunchId, $userId)
    {
        return DB::table('lunch_restaurant_ranks')
                ->join('lunch_restaurants', 'lunch_restaurant_ranks.lunch_restaurant_id', '=', 'lunch_restaurants.id')
                ->join('lunches', 'lunch_restaurants.lunch_id', '=', 'lunches.id')
                ->where('lunches.id', $lunchId)
                ->where('lunch_restaurant_ranks.user_id', $userId)
                ->delete(); 
    }

    /**
     * Delete restaurant in a lunch by associated id.
     * 
     * @param  int $lunchRestaurantsId Resturant id associated to lunch
     * @return boolean
     */
    public function deleteRestaurants($lunchRestaurantsId)
    {
        return DB::table('lunch_restaurants')
                ->where('id', '=', $lunchRestaurantsId)
                ->delete();
    }

    /**
     * Delete friend in a lunch associated by id.
     * 
     * @param  int $lunchFriendsId Friend id associated to lunch
     * @return boolean
     */
    public function deleteFriends($lunchFriendsId)
    {
        return DB::table('lunch_friends')
                ->where('id', '=', $lunchFriendsId)
                ->delete();
    }
}