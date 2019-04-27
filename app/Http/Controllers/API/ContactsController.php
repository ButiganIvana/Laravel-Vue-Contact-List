<?php

namespace App\Http\Controllers\API;

use App\Phone;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ContactsController extends Controller
{
    public static $UPDATE = 1;
    public static $CREATE = 2;
    public static $FAVOURITE = 1;

    public function index()
    {

        $contacts = Contact::with('phones')->where("user_id", auth()->id())->get();

        return response()->json([
            'status' => 'success',
            'data' => $contacts,
          ]);
    }

    public function store(Request $request)
    {
        return $this->manage(self::$CREATE, $request);
    }

    public function show($contact)
    {
        $found = Contact::with('phones')->where("user_id", auth()->id())->where('id', $contact)->get();

        if (count($found)) {
            return response()->json([
                'status' => 'success',
                'data' => $found,
              ]);
        }
          return response()->json([
            'status' => 'error',
            'data' => "No contact with that id.",
          ]);
    }

    public function edit(Contact $contact)
    {
        $found = Contact::with('phones')->where("user_id", auth()->id())->where('id', $contact)->get();

        if (count($found)) {
            return response()->json([
                'status' => 'success',
                'data' => $found,
              ]);
        }
          return response()->json([
            'status' => 'error',
            'data' => "No contact with that id.",
          ]);
    }

    public function update(Request $request, Contact $contact)
    {
        return $this->manage(self::$UPDATE, $request);
    }


    public function destroy(Contact $contact)
    {
        $contact = Contact::find($contact->id);
        $contact->delete();

        return response()->json([
            'status' => 'success',
            'data' => $contact->id
        ]);
    }

    public function search($q, $fav)
    {
        $contact_results = Contact::queryContacts($q);
        $phones_results = Contact::queryPhones($q);
        $contact_results = Contact::joinContacts($phones_results, $contact_results);

        if ($fav == self::$FAVOURITE) {
            $final_results = Contact::isFavorite($contact_results, $fav);
        } else {
            $final_results = $contact_results;
        }
        return response()->json([
            'status' => 'success',
            'data' => array_unique($final_results, SORT_REGULAR)
        ]);
    }

    public function favourite(Contact $contact) {
        $contact->favourite = !$contact->favourite;
        $contact->save();
        return response()->json([
            'status' => 'success',
            'data' => $contact
        ]);
    }

    private function handlePhoto($to_update, $image) {
        if ($to_update == null)  {
            $profile_photo = "";
        } else {
            $profile_photo = $to_update->profile_photo;
        }

        if ($image == null) {
            $saved_image = [ 'status' => 'success', 'data' => '' ];
        } else {
            $saved_image = Contact::savePhoto($image, $profile_photo);
        }
        return $saved_image;
    }

    private function manage($method, $request) {

        $attributes = $request->all();
        $image = $attributes["profile_photo"];
        $phone_attributes = $attributes['phones'];

        $attributes['full_name'] = join(' ', [$attributes['first_name'], $attributes['last_name']]);

        unset($attributes["phones"]);

        $validate_contact = Contact::validateContact($attributes);

            if (array_key_exists('id', $attributes)) {
                $id =  $attributes['id'];
            } else {
                $id = '';
            }

            $to_update = Contact::find($id);
            $path = $this->handlePhoto($to_update, $image);

            if ($path['status'] == "error") {
                return response()->json($path);
            } else {
                $attributes['profile_photo'] = $path['data'];
            }

        if ($validate_contact['status'] == "error") {
            return response()->json($validate_contact);
        } else {
            $have_duplicates = Phone::checkForDuplicates($phone_attributes);

            if ($have_duplicates['status'] == "error") {
                return response()->json($have_duplicates);
            }

            $attributes['user_id'] = auth()->id();

            DB::beginTransaction();
            if ($method == self::$CREATE) {
                $created = Contact::create($attributes);
                $id =  $created['id'];
            }

            $save_phone = Phone::validateAndSavePhone($id, (array) $phone_attributes);

            if ($save_phone['error']) {
                return response()->json($save_phone);
                DB::rollBack();
            }

            if ($method == self::$UPDATE) {
                $to_update->fill($attributes)->save();
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $id
            ]);

            }
        }
}
