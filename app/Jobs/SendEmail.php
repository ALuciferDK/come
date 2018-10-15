<?php
namespace App\Jobs;

use User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
 
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
       $this->user = $user;
    }
 
    /**
     * 执行队列的方法 比如发送邮件
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw($this->user['u_name'].' 邮件发送成功！',function ($message){
            $message->to($this->user['u_email']);   // 收件人的邮箱地址
            $message->subject('队列发送邮件');    // 邮件主题
        });
    }
}