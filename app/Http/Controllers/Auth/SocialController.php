<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Model\Social;
use App\Model\User;
class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            $user = Socialite::driver($provider)->stateless()->user();
            return redirect('/login');
        }
        $authUser   = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('admin/');
    }
    public function findOrCreateUser($socialUser, $provider)
    {
        $sosmed = Social::where('provider_id', $socialUser->getId())
        ->where('provider_name', $provider)
        ->first();
        if ($sosmed) {
            return $sosmed->user;
        }else{
            $user   = User::where('email', $socialUser->getEmail())->first();
            if (! $user) {
                $user   = User::create([
                    'name'  	=> $socialUser->getName(),
                    'email' 	=> $socialUser->getEmail(),
                    'avatar'	=> $socialUser->getAvatar()
                ]);
            }
            $user->social()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);
            return $user;
        }
    }
}