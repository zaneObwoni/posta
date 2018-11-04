<?php namespace App\Logic\Mailers;

class UserMailer extends Mailer {

    public function verify($email, $data)
    {
        // $view       = 'emails.activate-link';
        $view       = 'emails.register-activate';
        $subject    = $data['subject'];
        $fromEmail  = 'nightoutkenya@gmail.com';

        $this->sendTo($email, $subject, $fromEmail, $view, $data);
    }

    public function passwordReset($email, $data)
    {
        $view       = 'emails.password-reset';
        $subject    = $data['subject'];
        $fromEmail  = 'nightoutkenya@gmail.com';

        $this->sendTo($email, $subject, $fromEmail, $view, $data);
    }

    public function verif($email, $data)
    {
        // $view       = 'emails.activate-link';
        $view       = 'emails.register-activate';
        // $subject    = '$data['subject']';
        $subject    = 'Fresh n Easy Activation';
        $fromEmail  = 'nightoutkenya@gmail.com';
        $toemail    = 'kenyaleo15@gmail.com';

        $this->sendTo($email, $subject, $fromEmail, $view, $data);

        // \Mail::send($view, $data,
        //      function($message){
        //         $message->to('nightoutkenya@gmail.com')
        //             ->subject('Welcome!!!');
        //      });
    }


    public function sendInvoice($email, $data)
    {
        $view       = 'emails.invoice';
        $subject    = $data['subject'];
        $fromEmail  = 'nightoutkenya@gmail.com';

        $this->sendTo($email, $subject, $fromEmail, $view, $data);
    }

}