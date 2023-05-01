<?php

namespace App\Services;


use App\Models\Customer;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Storage;

class CustomerService
{
    use ResponseAPI;

    public function addCustomer($request)
    {
        $profile_name = $this->saveProfile($request);

        $addCustomer = new Customer();
        $addCustomer->name = $request['name'];
        $addCustomer->phone = $request['phone'];
        $addCustomer->address = $request['address'];
        $addCustomer->profile = $profile_name;
        $addCustomer->save();

        return response()->json([
            'success' => true,
            'msg' => 'ສຳເລັດແລ້ວ'
        ]);
    }

    public function saveProfile($request)
    {
        if ($request->hasFile('profile')) {
            $file_master = '/images/Customer/profile';
            $proFile = $request->file('profile');
            //get just ext
            $extension = $proFile->getClientOriginalExtension();
            //proFilename to storage
            $proFilename = 'customer_profile' . '_' . time() . '.' . $extension;
            Storage::disk('public')->putFileAs($file_master, $proFile, $proFilename);

            return $proFilename;
        }
    }

    public function editCustomer($request)
    {
        $editCustomer = Customer::find($request['id']);
        $editCustomer->name = $request['name'];
        $editCustomer->phone = $request['phone'];
        $editCustomer->address = $request['address'];

            if(isset($request['profile'])){
                //Update proFile
                $fileName = $this->saveProfile($request);

                    //Move for Old proFile in folder
                    if(isset($editCustomer->profile)){
                        $file_master = 'images/Customer/profile/' . $editCustomer->profile;
                        if (Storage::disk('public')->exists($file_master)){
                            Storage::disk('public')->delete($file_master);

                        }
                    }
                $editCustomer->profile = $fileName;
            }
        $editCustomer->save();

        return response()->json([
            'success' => true,
            'msg' => 'ສຳເລັດແລ້ວ'
        ]);
    }

    public function deleteCustomer($request)
    {
        $deleteCustomer = Customer::find($request['id']);
        //Delete proFile in folder
            if(isset($deleteCustomer->profile)){
                $file_master = 'images/Customer/profile/' . $deleteCustomer->profile;
                if (Storage::disk('public')->exists($file_master)){
                    Storage::disk('public')->delete($file_master);
                }
            }
        $deleteCustomer->delete();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function listCustomers()
    {
        $masters = Customer::orderBy('id', 'desc')->get();
        $masters->transform(function ($item){
            return $item->format();
        });

        return response()->json([
            'listCustomers' => $masters
        ]);
    }

    public function updateCustomerStatus($request)
    {
        $updateStatus = Customer::find($request['id']);
        $updateStatus->status = $request['status'];
        $updateStatus->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }
}
