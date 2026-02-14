<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Services\Guzzle\Mail;
use App\Models\User;
use App\Http\Requests\ChangePasswordRequest;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request, Mail $mailer)
    {
       $this->validateEmail($request);

       $user = User::where('email', $request->email)->first();

       if ($user) {
        $newPassword = \Str::random(8);

        $mailer->emailTo = $request->email;
        $mailer->message = 'Your new password is ' . $newPassword;

        $resultJSON = $mailer->funcGet(); //{"mail":null,"request":false}
        $result = json_decode($resultJSON);

        if ($result->mail) {
           $user->password = \Hash::make($newPassword);
           $user->save();

           return redirect(route('login'))->with('resetPassword', 'A new password has been sent to your email address.');
        } else {
           return redirect(route('password.request'))->with('notSuccess', 'Sorry. Something went wrong. Try again later.');
        }
       } else {
           return redirect(route('password.request'))->with('notSuccess', 'This Email does not exist.');
       }
    } 
    
    /**
     * Display the form to change the password.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function linkChangePassword()
    {
       return view('auth.passwords.change'); //!!!auth.passwords.change   
    }   
    
    /**
     * Change password.
     *
     * @return \Illuminate\View\View
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        $user->password = \Hash::make($request->password);
        $user->save();  
        
        auth()->logout();

        return redirect(route('login'))->with('changePassword', 'Your password has been changed.');        
    }      
}
