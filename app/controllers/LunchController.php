<?php
class LunchController extends \BaseController 
{ 
    /**
     * Display a listing of the lunch.
     *
     * @return Response
     */
    public function index()
    {}
 
    /**
     * Display results of the lunch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $lunch = new App\Models\Lunch();
        $view = $lunch->edit(Auth::id(), $id);

        return View::make('lunch.index', $view);
    }

    /**
     * Show the form for creating a new lunch.
     *
     * @return Response
     */
    public function create()
    {
        $lunch = new App\Models\Lunch();
        $view = $lunch->create(Auth::id());

        return View::make('lunch.create', $view);
    }
 
    /**
     * Store a newly created lunch in storage.
     *
     * @return Response
     */
    public function store()
    {
        $lunch = new App\Models\Lunch();
        $lunch->store(Auth::id(), Input::get());

        return Redirect::to('/user');
    }
 
    /**
     * Show the form for editing the specified lunch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $lunch = new App\Models\Lunch();
        $view = $lunch->edit(Auth::id(), $id);

        return View::make('lunch.edit', $view);
    }
 
    /**
     * Update the specified lunch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $lunch = new App\Models\Lunch();
        $lunch->update(Auth::id(), $id, Input::get());

        return Redirect::to('/user');
    }
 
    /**
     * Remove the specified lunch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $lunch = new App\Models\Lunch();
        $lunch->destroy($id);
 
        return Redirect::to('/user');
    }
 
}