<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Twilio\Jwt\AccessToken;

class TwilioAccessTokenProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AccessToken::class, function ($app) {
                $TWILIO_ACCOUNT_SID = ACdce68652f98ad97686bd9e64c329361c;
                $TWILIO_API_KEY = SK906617c4f8af89218fbe514d17fcb383;
                $TWILIO_API_SECRET = CHSEl6wXOYoqEN9EdVYkG2KjNucKYZAP;

                $token = new AccessToken(
                    $TWILIO_ACCOUNT_SID,
                    $TWILIO_API_KEY,
                    $TWILIO_API_SECRET,
                    3600
                );

                return $token;
            }
        );
    }
}
