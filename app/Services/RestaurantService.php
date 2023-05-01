<?php

namespace App\Services;


use App\Models\Restaurant;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Storage;


class RestaurantService
{
    use ResponseAPI;

    public function addRestaurant($request)
    {
        $file_name = $this->saveImage($request);

        $addRestaurant = new Restaurant();
        $addRestaurant->name = $request['name'];
        $addRestaurant->phone = $request['phone'];
        $addRestaurant->address = $request['address'];
        $addRestaurant->logo = $file_name;
        $addRestaurant->save();

        return response()->json([
            'success' => true,
            'msg' => 'ສຳເລັດແລ້ວ'
        ]);
    }

    public function editRestaurant($request)
    {
        $editRestaurant = Restaurant::find($request['id']);
        $editRestaurant->name = $request['name'];
        $editRestaurant->phone = $request['phone'];
        $editRestaurant->address = $request['address'];

        if(isset($request['logo'])){
            //Update file
            $fileName = $this->saveImage($request);

                //Move for Old file in folder
                if(isset($editRestaurant->logo)){
                    $file_path = 'images/Restaurant/Logo/' . $editRestaurant->logo;
                    if (Storage::disk('public')->exists($file_path)){
                        Storage::disk('public')->delete($file_path);

                    }
                }
            $editRestaurant->logo = $fileName;
        }
        $editRestaurant->save();

        return response()->json([
            'success' => true,
            'msg' => 'ສຳເລັດແລ້ວ'
        ]);
    }

    public function saveImage($request)
    {
        if ($request->hasFile('logo')) {
            $master_path = '/images/Restaurant/Logo';
            $imageFile = $request->file('logo');
            //get just ext
            $extension = $imageFile->getClientOriginalExtension();
            //Filename to storage
            $filename = 'restaurant_logo' . '_' . time() . '.' . $extension;
            Storage::disk('public')->putFileAs($master_path, $imageFile, $filename);

            return $filename;
        }
    }

    public function deleteRestaurant($request)
    {
        $deleteRestaurant = Restaurant::find($request['id']);
        //Delete file in folder
        if(isset($deleteRestaurant->logo)){
            $file_path = 'images/Restaurant/Logo/' . $deleteRestaurant->logo;
            if (Storage::disk('public')->exists($file_path)){
                Storage::disk('public')->delete($file_path);
            }
        }
        $deleteRestaurant->delete();

        return response()->json([
            'success' => true,
            'msg' => 'ສຳເລັດແລ້ວ'
        ]);
    }

    public function listRestaurants()
    {
        $masters = Restaurant::orderBy('id', 'desc')->get();
        $masters->transform(function ($master){
            return $master->format();
        });
        return response()->json([
            'listRestaurants' => $masters
        ]);
    }

}
