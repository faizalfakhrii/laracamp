<?php

namespace App\Http\Controllers;

use App\Mail\UserAfterRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function heandleProviderCallback()
    {
        

        try {
     
        // return 'Ok';
                // $callback = Socialite::driver('google')->stateless()->user();

                // $data = [
                //     'name'                  => $callback->getName(),
                //     'email'                 => $callback->getEmail(),
                //     'avatar'                => $callback->getAvatar(),
                //     'email_verified_at'     => now(),
                // ];
                // print($data);

                // $user = User::firstOrCreate(['email' => $data['email']], $data);
                // $user = User::whereEmail($data['email'])->first();
                // if (!$user) {
                //     $user = User::create($data);
                //     Mail::to($user->email)->send(new UserAfterRegister($user));
                // }
                // Auth::login($user, true);

                // return redirect()->route('dashboard');

                $user = Socialite::driver('google')->user();
                //dd($user);
      
            $finduser = User::whereEmail('email', $user->email)->first();
      
            if($finduser){
      
                Auth::login($finduser);
     
                return redirect()->route('dashboard');
      
            }else{
                $newUser = User::create([
                    'name'                  => $user->getName(),
                    'email'                 => $user->getEmail(),
                    'avatar'                => $user->getAvatar(),
                    'email_verified_at'     => now(),
                ]);
     
                Auth::login($newUser);
      
               return redirect()->route('dashboard');
            
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
