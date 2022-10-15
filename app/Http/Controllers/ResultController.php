<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Location;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Item;
use App\Models\File;
use App\Models\Product;

class ResultController extends Controller
{
    
    public function results()
    {
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }        

        $items = Item::all();
        
        $results = [];
        $result = [];

        foreach($items as $item)
        {

            foreach ($item->files as $file) {
                $file->file = json_decode($file->file);
            }

            $result['id'] = $item->id;        
            $result['item_type'] = $item->item_type;
            $result['location_id'] = $item->location_id;
            $result['location'] = $item->location;
            $result['tradable'] = $item->tradable;
            $result['user_id'] = $item->user_id;
            $result['added_by'] = $item->addedBy;
            $result['status'] = $item->status;
            $result['is_active'] = $item->is_active;
            $result['files'] = $item->files;
            $result['product']['id'] = $item->product->id;
            $result['product']['item_id'] = $item->product->item_id;
            $result['product']['title'] = $item->product->title;
            $result['product']['category_id'] = $item->product->category_id;
            $result['product']['category'] = $item->product->category;
            $result['product']['sub_category_id'] = $item->product->sub_category_id;
            $result['product']['sub_category'] = $item->product->subCategory;
            $result['product']['negotiable'] = $item->product->negotiable;
            $result['product']['price'] = $item->product->price;
            $result['product']['condition'] = $item->product->condition;
            $result['product']['description'] = $item->product->description;
            $result['product']['min_quantity'] = $item->product->min_quantity;
            $result['product']['validity'] = $item->product->validity;

            $results[] = $result;
        }

        

        return response(['results' => $results], 200);
    }
}