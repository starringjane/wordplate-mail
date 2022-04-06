<?php

namespace StarringJane\WordplateMail;

class WordplateMail
{
    public function __construct()
    {
        $this->hooks();
    }

    public static function register()
    {
        return new self();
    }

    public function hooks()
    {
        /**
         * Mail settings
         */
        add_action('phpmailer_init', [$this, 'phpmailer_init']);

        /**
         * Custom from emailaddress
         */
        add_filter('wp_mail_from', [$this, 'wp_mail_from']);

        /**
         * Custom from name
         */
        add_filter('wp_mail_from_name', [$this, 'wp_mail_from_name']);
    }

    public function phpmailer_init($mail)
    {
        if (env('MAIL_DRIVER', 'smtp') === 'smtp') {
            $mail->IsSMTP();
        } else {
            $mail->isMail();
        }

        $mail->SMTPAutoTLS = false;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
    
        $mail->Host = env('MAIL_HOST', 'localhost');
        $mail->Port = env('MAIL_PORT', 25);
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
    
        /**
         * Set sender to the same as from address
         */
        $mail->Sender = $mail->From;
    
        return $mail;
    }

    public function wp_mail_from($from_email)
    {
        if (env('MAIL_FROM_ADDRESS')) {
            return env('MAIL_FROM_ADDRESS');
        }

        return $from_email;
    }

    public function wp_mail_from_name()
    {
        if (env('MAIL_FROM_NAME')) {
            return env('MAIL_FROM_NAME');
        }

        return get_bloginfo('name');
    }
}
