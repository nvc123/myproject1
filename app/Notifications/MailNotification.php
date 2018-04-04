<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class MailNotification extends Notification
{
    use Queueable;

    protected $not;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($nnot)
    {
        //
	$this->not=$nnot;
	Log::info('constr class: '.get_class($this->not));
	
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
	$jsonObj=json_decode($this->not->payload, true);
	$type=$this->not->type;
	if($type==0){
	    $subj='Статус вашей статьи был изменён';
	    if($jsonObj['status']=='published'){
		$line0='Ваша статья была опубликована';
	    }
	    if($jsonObj['status']=='not_published'){
		$line0='Ваша статья не была опубликована по причине:' . $jsonObj['text'];
	    }
	    if($jsonObj['status']=='locked'){
		$line0='Ваша статья была заблокирована по причине:' . $jsonObj['text'];
	    }
	    $url=route('articles').'/'.$jsonObj['article'];
	}
	if($type==1){
	    $subj='Новые комментарии';
	    $url=route('articles').'/'.$jsonObj['article'];
	    $line0='У вашей статьи появились новые комментарии';
	}
	if($type==2){
	    $subj='Новая публикация';
	    $url=route('articles').'/'.$jsonObj['article'];
	    $line0='Среди ваших подписок опубликована новая статья';
	}
	//get_class
	Log::info('class: '.get_class($this->not));
	Log::info('notifiable->type: '.$type);
	//Log::info('jsonObj[\'status\']: '.$jsonObj['status']);
        return (new MailMessage)
                    ->subject($subj)
		    ->line($line0)
                    ->action('Просмотреть', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
