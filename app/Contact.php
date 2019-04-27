<?php

namespace App;

use App\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Contact extends Model
{
    protected $guarded = [];

    public function phones() {
        return $this->hasMany(Phone::class);
    }

    public static function validateContact($attributes) {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|nullable|email'
        ];

        $validator = Validator::make($attributes, $rules);

        if ($validator->fails())
        {
            return [
                'status' => "error",
                'data' => $validator->messages()->toArray()
            ];
        } else {
            return [
                'status' => "success",
            ];
        }

    }

    public static function queryContacts($q) {
        $search_terms = explode(" ", $q);

        $query_contact = Contact::where('user_id', auth()->id())
            ->where(function ($query) use ($search_terms) {
                foreach ($search_terms as $value) {
                    $query->where('full_name', 'like', "%{$value}%");
                  }

                        });
        return $query_contact->get();
    }

    public static function queryPhones($q) {
        $query_phones = Phone::with('contact')
                            ->whereHas('contact', function($query) {
                                $query->where('user_id', auth()->id());
                            })
                            ->where('name', 'like', "%$q%");

        return $query_phones->get();
    }

    public static function isFavorite($contact_results, $fav) {
        $final_results = [];
        foreach($contact_results as $r) {
            if ($r['favourite'] == $fav) {
                array_push($final_results, $r);
            }
        }
        return $final_results;
    }

    public static function joinContacts($phones_results, $contact_results) {
        foreach($phones_results as $r) {
            $contact_results->push(collect($r->contact));
        }
        return $contact_results->toArray();
    }

    public static function savePhoto($image, $current_image) {

        if ($image == $current_image) {
            return [
                'status' => 'success',
                'data' => $image
            ];
        }

        $size = @getimagesize($image);

        if($size == false) {
            return [
                'status' => 'error',
                'data' => ["profile_photo" => "You must upload image file."]
            ];
        }

        $im = explode(",",$image);
        preg_match("/\/.*?\;/", $im[0], $extension);
        $extension = substr($extension[0], 1, -1);
        $image_name = str_random(10).'.'.$extension;

        $k = Storage::put("/profile_photos/".$image_name, file_get_contents($image));
        return [
            'status' => 'success',
            'data' => "/storage/profile_photos/".$image_name
        ];
    }
}
