<?php
namespace App\Models\Database;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurants';

    /**
     * Get all restaurants
     * 
     * @return object
     */
    public function getAll()
    {
        return $this::all();
    }
}