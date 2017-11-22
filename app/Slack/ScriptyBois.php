<?php

namespace App\Slack;

use Illuminate\Notifications\Notifiable;

class ScriptyBois
{
    use Notifiable;

    /**
     * The key for the slack team.
     *
     * @return string
     */
    public function getKey()
    {
        return 'scripty-bois';
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return env('SCRIPTY_BOIS_WEBHOOK_URL');
    }
}
