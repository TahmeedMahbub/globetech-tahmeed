<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\User;
use App\Models\Location;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Item;
use App\Models\File;
use App\Models\Product;


class CreateController extends Controller
{
    public function location(Request $request)
    {   
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }
        
        $request->validate([
            'country' => 'required | string',
            'address_1' =>  'required | string',
            'address_2' =>  'nullable | string',
            'city' =>  'required | string',
            'state' =>  'required | string',
            'zone' =>  'required | string',
            'zip_code' =>  'required | string',
            'lat' => 'required | numeric',
            'lng' => 'required | numeric',
            'type' =>  'required | string',
            'added_by' =>  'required | numeric',
        ]);

        if(!User::find($request->added_by))
        {
            return response()->json(['error' => 'No user found as added_by!'], 404);            
        }

        DB::beginTransaction();
        try {

            $location = new Location();

            $location->country = $request->country;
            $location->address_1 = $request->address_1;
            $location->address_2 = $request->address_2;
            $location->city = $request->city;
            $location->state = $request->state;
            $location->zone = $request->zone;
            $location->zip_code = $request->zip_code;
            $location->lat = $request->lat;
            $location->lng = $request->lng;
            $location->type = $request->type;
            $location->added_by = $request->added_by;

            $location->save();

            $location->code = "SU-000000".$location->id;
            $location->save();

            DB::commit();

            return response(['location' => $location], 201);

        } catch(Exception $ex) {

            DB::rollBack();

            return response([
                'message' => 'Insertion Failed!',
                'error' => $ex->getMessage()
            ], 500);
        }
    }

    
    public function category(Request $request)
    {   
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }

        $request->validate([            
            'name' => 'required | string',
            'type' => 'required | string',
            'is_active' => 'required | boolean',
        ]);

        DB::beginTransaction();
        try {

            $category = new Category();

            $category->name = $request->name;
            $category->type = $request->type;
            $category->is_active = $request->is_active;

            $category->save();

            DB::commit();

            return response(['category' => $category], 201);

        } catch(Exception $ex) {

            DB::rollBack();

            return response([
                'message' => 'Insertion Failed!',
                'error' => $ex->getMessage()
            ], 500);
        }

    }

    
    public function subcategory(Request $request)
    {         
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }
          
        $request->validate([            
            'name' => 'required | string',
            'parent_id' => 'required | numeric',
            'is_active' => 'required | boolean',
        ]);

        if(!Category::find($request->parent_id))
        {
            return response()->json(['error' => 'No category found like parent_id!'], 404);            
        }

        DB::beginTransaction();
        try {

            $subcategory = new SubCategory();

            $subcategory->name = $request->name;
            $subcategory->parent_id = $request->parent_id;
            $subcategory->is_active = $request->is_active;

            $subcategory->save();

            DB::commit();

            return response(['subcategory' => $subcategory], 201);

        } catch(Exception $ex) {

            DB::rollBack();

            return response([
                'message' => 'Insertion Failed!',
                'error' => $ex->getMessage()
            ], 500);
        }

    }

    
    public function item(Request $request)
    {         
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }
          
        $request->validate([            
            'item_type' => 'required | string',
            'location_id' => 'required | numeric',            
            'tradable' => 'required | boolean',
            'user_id' => 'required | numeric',
            'status' => 'required | string',           
            'is_active' => 'required | boolean',   
        ]);

        if(!Location::find($request->location_id))
        {
            return response()->json(['error' => 'No location found as location_id!'], 404);            
        }

        if(!User::find($request->user_id))
        {
            return response()->json(['error' => 'No user found in user_id!'], 404);            
        }

             
            
        DB::beginTransaction();
        try {

            $item = new Item();

            $item->item_type = $request->item_type;
            $item->location_id = $request->location_id;
            $item->tradable = $request->tradable;
            $item->user_id = $request->user_id;
            $item->status = $request->status;
            $item->is_active = $request->is_active;

            $item->save();

            DB::commit();

            return response(['item' => $item], 201);

        } catch(Exception $ex) {

            DB::rollBack();

            return response([
                'message' => 'Insertion Failed!',
                'error' => $ex->getMessage()
            ], 500);
        }

    }

    
    public function file(Request $request)
    {         
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }
        
        $request->validate([            
            'item_id' => 'required | numeric',
            'file' => 'required | mimes:jpg,jpeg,png,bmp | max:51200',            
            'description' => 'nullable | string',
            'is_primary' => 'required | string', 
        ]);  

        if(!Item::find($request->item_id))
        {
            return response()->json(['error' => 'No items found in item_id!'], 404);            
        }
             
            
        DB::beginTransaction();
        try {

            $file = new File();

            $file->item_id = $request->item_id;
            $file->is_primary = $request->is_primary;

            $file->save();



            $file_details = [];
            $file_details['id'] = $file->id;
            $file_details['name'] = $request->file->getClientOriginalName();
            $file_details['file'] = $request->getHttpHost().'/'.$request->file->getClientOriginalName();
            $file_details['extension'] = $request->file->extension();
            $file_details['size'] = $request->file->getSize();
            $file_details['description'] = $request->description;
    
            $request->file->move(public_path('/'), $file_details['name']);

            
            $file->file = json_encode($file_details, true);
            $file->save();

            DB::commit();

            return response(['file' => $file], 201);

        } catch(Exception $ex) {

            DB::rollBack();

            return response([
                'message' => 'Insertion Failed!',
                'error' => $ex->getMessage()
            ], 500);
        }

    }

    
    public function product(Request $request)
    {         
        if(!auth()->user())
        {
            return response()->json(['error' => 'Unauthorized!'], 401);            
        }
        
        $request->validate([            
            'item_id' => 'required | numeric',
            'title' => 'required | string',
            'category_id' => 'required | numeric',
            'sub_category_id' => 'required | numeric',
            'negotiable' => 'required | boolean',
            'price' => 'required | numeric',
            'condition' => 'required | string',
            'description' => 'required | string',   
            'min_quantity' => 'required | numeric',
            'validity' => 'required | date',
        ]);

        if(!Item::find($request->item_id))
        {
            return response()->json(['error' => 'No items found in item_id!'], 404);            
        }

        if(!Category::find($request->category_id))
        {
            return response()->json(['error' => 'No categories found in category_id!'], 404);            
        }

        if(!SubCategory::find($request->sub_category_id))
        {
            return response()->json(['error' => 'No sub-categories found in sub_category_id!'], 404);            
        }
             
            
        DB::beginTransaction();
        try {

            $product = new Product();

            $product->item_id = $request->item_id;
            $product->title = $request->title;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->negotiable = $request->negotiable;
            $product->price = $request->price;
            $product->condition = $request->condition;
            $product->description = $request->description;
            $product->min_quantity = $request->min_quantity;
            $product->validity = $request->validity;

            $product->save();

            DB::commit();

            return response(['product' => $product], 201);

        } catch(Exception $ex) {

            DB::rollBack();

            return response([
                'message' => 'Insertion Failed!',
                'error' => $ex->getMessage()
            ], 500);
        }

    }
}