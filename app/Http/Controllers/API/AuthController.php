<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class AuthController extends Controller
{
  /**
   * Login API
   *
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request){

    if(Auth::attempt(['email' => $request->email,
                      'password' => $request->password] )) {
      $user = Auth::user();
      $user->createAPIToken();

      return response()->json([
        'status' => 'success',
        'data' => $user
      ]);
    } else {
      return response()->json([
        'status' => 'error',
        'data' => 'Unauthorized Access'
      ]);
    }
  }

  /**
   * Register API
   *
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|unique:users,email',
      'password' => 'required|min:6',
    ]);


    if ($validator->fails()) {
      return response()->json(['status' => 'error', 'data'=>$validator->errors()->toArray()]);
    }

    $postArray = $request->all();
    $postArray['password'] = bcrypt($postArray['password']);


    $user = User::create($postArray);

    $user->createAPIToken();
    $success =  $user;

    return response()->json([
      'status' => 'success',
      'data' => $success,
    ]);
  }
}
