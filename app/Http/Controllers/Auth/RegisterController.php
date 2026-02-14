<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Services\Guzzle\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/list-projects';
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');

        $this->middleware('guest')->except(['sendLinkEmailVerification']);

        //$this->middleware('auth')->only(['sendLinkEmailVerification']);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request, Mail $mailer)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        $answerVerification = $this->sendLinkEmailVerification($request, $mailer);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath())->with($answerVerification[0], $answerVerification[1]);
    }   

    /**
     * Link emeil-verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendLinkEmailVerification(Request $request, Mail $mailer)
    {
        $user = auth()->user();

        $mailer->emailTo = $user->email;
        $mailer->message = 'You should confirm your email ' . 'https://pilot.25one.com.ua/api/verified/' . $user->api_token;
        $resultJSON = $mailer->funcGet();
        $result = json_decode($resultJSON);

        if ($result->mail) {
           if ($request->again) { 
              return redirect()->route('home')->with('verifiedRequiredEmail', 'We sent a message to your email to complete registration!');
           } else {
              return ['verifiedRequiredEmail', 'We sent a message to your email to complete registration!']; 
           }
        } else {
           return ['verifiedRequiredNotEmail', 'We could not send a message to your email. Please check it!']; 
        }
    }
    
    /**
     * Email-verification.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function emailVerification(Request $request)
    {
       $user = User::where('api_token', $request->api_token)->first();
       
       if ($user) {
          $user->email_verified_at = date('Y-m-d H:i:s');
          $user->save();

          return redirect()->route('home');
       } else {
          return view('404');
       }
    }  

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => \Str::random(60),
        ]);
    }
}
