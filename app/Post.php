<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Post extends Model
{
    //
    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
protected $fillable=[
    'category_id',
    'photo_id',
    'title',
    'body'

];

public function user(){

    return $this->belongsTo('App\User');
}

public function photo(){

    return $this->belongsTo('App\Photo');
}

public function category(){

    return $this->belongsTo('App\Category');
}

public function comments(){
    return $this->hasMany('App\Comment');
}

public function tags()
{
    return $this->belongsToMany('App\Tag');
}

public function scopeFilter($query, $filters){

    if (isset($filters['month'])){
        if($month = $filters['month']){
        $query->whereMonth('created_at', Carbon::parse($month)->month);
        }
    }
    
    if(isset($filters['year'])){
        if($year = $filters['year']){
        $query->whereYear('created_at', $year);
        }
    }
}

public function photoPlaceholder(){
    return "http://placehold.it/150x150";
}

}
