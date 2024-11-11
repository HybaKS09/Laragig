<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // Redéfinir la méthode all() pour correspondre à la signature de la classe Model
    // public static function all($columns = ['*'])
    // {
    //     return [
    //         [
    //             'id' => 1,
    //             'title' => 'Annonce 1',
    //             'description' => 'Description de l\'annonce 1.'
    //         ],
    //         [
    //             'id' => 2,
    //             'title' => 'Annonce 2',
    //             'description' => 'Description de l\'annonce 2.'
    //         ]
    //     ];
    // }

    // public static function find($id)
    // {
    //     $listings = self::all();

    //     foreach ($listings as $listing) {
    //         if ($listing['id'] == $id) {
    //             return $listing;
    //         }
    //     }

    //     return null;
    // }

    protected $fillable = ['title', 'company', 'location', 'website', 'email', 'tags', 'description', 'logo', 'user_id'];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
