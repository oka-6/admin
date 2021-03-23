<?php

namespace Oka6\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $input = null;
    
    public function __construct($inputToken)  {
    	$this->input = $inputToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */


    public function via($notifiable){
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Alterar Senha ')
            ->line('Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.')
			->action('Resetar Senha', route('password.reset', $this->input->token))
			->line('Se você não solicitou uma alteração da senha, nenhuma ação adicional é necessária.');
    }




    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
