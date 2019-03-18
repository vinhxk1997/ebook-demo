<?php
namespace App\Repositories;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Repositories\BaseRepository;
use App\Models\SocialUser;
use App\Models\User;
use DB;

class SocialUserRepository extends BaseRepository
{
    public function getOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = $this->where('provider', $provider)
            ->where('provider_user_id', $providerUser->getId())
            ->first();
        
        if ($account) {
            $user = $account->user;
        } else {
            $email = $providerUser->getEmail() ?? null;
            $account = new SocialUser([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);
            $create_user = true;

            if ($email) {
                $user = User::where('email', $email)->first();
                if (!! $user) {
                    $create_user = false;
                }
            }
            if ($create_user) {
                $avatar = null;
                try {
                    if ($providerUser->user['picture']['data']['is_silhouette'] === false) {
                        $avatar = uploadFile(
                            $providerUser->user['picture']['data']['url'],
                            config('app.avatar_path'),
                            config('app.avatar_sizes')
                        );
                    }
                    DB::beginTransaction();
                    $user = User::create([
                        'full_name' => $providerUser->getName(),
                        'login_name' => str_slug($providerUser->getName(), '.'),
                        'email' => $email,
                        'password' => str_random(63),
                        'avatar' => $avatar,
                    ]);

                    $account->user()->associate($user);
                    $account->save();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return false;
                }
            } else {
                $account->user()->associate($user);
                $account->save();
            }
        }

        return $user;
    }
}
