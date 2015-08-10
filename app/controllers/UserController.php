<?php
class UserController extends \BaseController 
{ 
    public function __construct()
    {
        $this->beforeFilter('auth');
    }
 
    /**
     * Display a listing of the user.
     *
     * @return Response
     */
    public function index()
    {
        $lunches = App\Models\Database\Lunch::all();

        $restaurants = App\Models\Database\Restaurant::where('user_id', '=', Auth::id())->get();
        $friends = DB::table('friends')
            ->join('users', 'users.id', '=', 'friends.friend_id')
            ->where('friends.user_id', '=', Auth::id())
            ->get();

        return View::make('user.index', [
            'lunches' => $lunches, 
            'restaurants' => $restaurants,
            'friends' => $friends
        ]);
    }
 
    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('user.create');
    }
 
    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user = new User;
 
        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');
        $user->username   = Input::get('username');
        $user->email      = Input::get('email');
        $user->password   = Hash::make(Input::get('password'));
 
        $user->save();
 
        return Redirect::to('/user');
    }
 
    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
 
        return View::make('user.edit', ['user' => $user]);
    }
 
    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $user = User::find($id);
 
        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');
        $user->username   = Input::get('username');
        $user->email      = Input::get('email');
        $user->password   = Hash::make(Input::get('password'));
 
        $user->save();
 
        return Redirect::to('/user');
    }
 
    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::destroy($id);
 
        return Redirect::to('/user');
    }

    /**
     * Search for a user.
     * 
     * @return Response
     */
    public function search()
    {
        $name = Input::get('name');

        $users = DB::table('users')
            ->where('first_name', $name)
            ->where('users.id', '<>', Auth::id())
            ->get();

        return View::make('user.search', ['users' => $users]);
    }

    /**
     * Add another user as a friend.
     * 
     * @return Response
     */
    public function add_friend($id)
    {
        DB::table('friends')->insert(
            array(
                'user_id' => Auth::id(), 
                'friend_id' => $id
            )
        );

        return Redirect::to('/user');
    }

    /**
     * Remove friend from user.
     * 
     * @return Response
     */
    public function remove_friend($id)
    {
        DB::table('friends')
            ->where('friend_id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return Redirect::to('/user');
    }
}