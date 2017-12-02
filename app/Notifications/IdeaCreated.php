<?php

namespace App\Notifications;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class IdeaCreated extends Notification
{
    use Queueable;

    /**
     * The freshly created idea instance.
     *
     * @var \App\Models\Idea
     */
    protected $idea;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('Ideasheet', ':bulb:')
            ->success()
            ->content('New idea was added!')
            ->attachment(function ($attachment) {
                $attachment
                    ->title($this->idea->content)
                    ->content('link here');
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $idea->toArray();
    }
}
