<?php

namespace Tessify\Core\Mail\Auth;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecoverAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('tessify-core::auth.recover_account_email_subject'))
                    ->markdown('tessify-core::emails.auth.recover-account', [
                        'user' => $this->user,
                        'text' => str_replace('\n', '<br>', (__('tessify-core::auth.recover_account_email_text', ['name' => 'henk']))),
                        'closing_text' => nl2br(__('tessify-core::general.email_closing_text')),
                    ]);
    }
}
