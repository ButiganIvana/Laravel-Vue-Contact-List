<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Phone extends Model
{

    protected $guarded = [];

    public function contact() {
        return $this->belongsTo('App\Contact');
    }

    public function contacts() {
        return $this->hasMany('App\Contact');
    }

    public static function checkForDuplicates($phone_attributes) {
        $attr = [];
        foreach ($phone_attributes as $attribute) {
            array_push($attr, $attribute['name']);
        }

        $have_duplicates = count($attr) !== count(array_unique($attr, SORT_REGULAR));
        $error['phones'] = ['Some phones are duplicates.'];

        if ($have_duplicates) {
            return ['status' => 'error', 'data' => $error];
        } else {
            return ['status' => 'success'];
        }
    }


    public static function validateAndSavePhone($id, $phone_attributes) {

        DB::beginTransaction();
        Phone::where('contact_id', $id)->delete();




// Dump array with object-arrays

        for ($i = 0; $i < count($phone_attributes); $i++) {

            $attribute = $phone_attributes[$i];

            $attribute['contact_id'] = $id;

            $rules = [
                'label' => 'required',
                'name' => 'required|numeric',
                'contact_id' => 'required'
            ];


            $validator = Validator::make($attribute, $rules);

            if ($validator->passes()) {
                Phone::create($validator->validate());
            } else {
                DB::rollBack();
                return ['error' => true, 'data' => $validator->messages()];
            }
        }
        DB::commit();
    }
}
