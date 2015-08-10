<?php
namespace App\Models\Database;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * Get friends of a user
     * 
     * @param  int $userId User id
     * @return object
     */
    public function getFriends($userId)
    {
        $friends = DB::table('friends')
            ->join('users', 'users.id', '=', 'friends.friend_id')
            ->where('friends.user_id', '=', $userId)
            ->get();

        return $friends;
    }

    /**
     * Get restaurants of a user
     * 
     * @param  int $userId User id
     * @return object
     */
    public function getRestaurants($userId)
    {
        $restaurants = DB::table('restaurants')
            ->where('user_id', '=', $userId)
            ->get();

        return $restaurants;
    }
}