<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\NotesFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    protected $table = 'listings';
    protected $fillable = [
        'title',
        'logo',
        'company',
        'location',
        'website',
        'email',
        'tags',
        'description',
       'user_id'
    ];

    public function scopeFilter($query, array $filters)
    {   
      
        if($filters['tags'] ?? false)
        {
         
         return $query->where('tags','like','%' . $filters['tags'] . '%');

        
        }

        if($filters['search'] ?? false)
        {
         
         return $query->where('title','like','%' . $filters['search'] . '%')
                    ->orWhere('description','like','%' . $filters['search'] . '%')
                    ->orWhere('tags','like','%' . $filters['search'] . '%');

        
        }

       
    }
    
    /**
     * Get Listing's owner/user
     *
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
