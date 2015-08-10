<?php
class RestaurantController extends \BaseController 
{ 
    /**
     * Display a listing of the restaurant.
     *
     * @return Response
     */
    public function index()
    {}
 
    /**
     * Show the form for creating a new restaurant.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('restaurant.create');
    }
 
    /**
     * Store a newly created restaurant in storage.
     *
     * @return Response
     */
    public function store()
    {
        $restaurant = new App\Models\Database\Restaurant();
 
        $restaurant->user_id 	= Auth::id();
        $restaurant->name	    = Input::get('name');
 
        $restaurant->save();
 
        return Redirect::to('/user');
    }
 
    /**
     * Show the form for editing the specified restaurant.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $restaurant = App\Models\Database\Restaurant::find($id);
 
        return View::make('restaurant.edit', ['restaurant' => $restaurant]);
    }
 
    /**
     * Update the specified restaurant in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $restaurant = App\Models\Database\Restaurant::find($id);
 
        $restaurant->name	= Input::get('name');
 
        $restaurant->save();
 
        return Redirect::to('/user');
    }
 
    /**
     * Remove the specified restaurant from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        App\Models\Database\Restaurant::destroy($id);
 
        return Redirect::to('/user');
    }
 
}