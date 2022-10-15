<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function addedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'first_name', 'last_name');
    }

    public function files()
    {
        $files = $this->hasMany('App\Models\File', 'item_id', 'id');
        
        foreach ($files as $file) {
            $file->file = 123;
        }

        return $files;
    }    

    public function product()
    {
        $product = $this->hasOne('App\Models\Product', 'item_id', 'id');
        return $product;
    }
}
