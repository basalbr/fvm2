<?php

namespace App\Listeners;

use App\Events\AberturaEmpresa\UserSentMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserSentMessage  $event
     * @return void
     */
    public function handle(UserSentMessage $event)
    {
        try {
            //Sends e-mail to admin informing the event
            Mail::send('emails.admin.newEvent', ['eventName' => $event->name, 'eventMessage' => $event->message], function ($m) use ($event) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject($event->name);
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }
}
