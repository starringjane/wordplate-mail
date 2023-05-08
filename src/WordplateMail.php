<?php

namespace StarringJane\WordplateMail;

class WordplateMail
{
    public $variables = [];

    public function __construct()
    {
        $this->hooks();
    }

    public static function register()
    {
        return new self();
    }

    public function set($key, $value)
    {
        $this->variables[$key] = $value;

        return $this;
    }

    public function get($key, $default = null)
    {
        if (isset($this->variables[$key])) {
            return is_callable($this->variables[$key])
                ? $this->variables[$key]()
                : $this->variables[$key];
        }

        return env($key, $default);
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
        if ($this->get('MAIL_DRIVER', 'smtp') === 'smtp') {
            $mail->IsSMTP();
        } else {
            $mail->isMail();
        }

        $mail->SMTPAutoTLS = false;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $this->get('MAIL_ENCRYPTION', 'tls');
    
        $mail->Host = $this->get('MAIL_HOST', 'localhost');
        $mail->Port = $this->get('MAIL_PORT', 25);
        $mail->Username = $this->get('MAIL_USERNAME');
        $mail->Password = $this->get('MAIL_PASSWORD');
    
        /**
         * Set sender to the same as from address
         */
        $mail->Sender = $mail->From;
    
        return $mail;
    }

    public function wp_mail_from($from_email)
    {
        if ($this->get('MAIL_FROM_ADDRESS')) {
            return $this->get('MAIL_FROM_ADDRESS');
        }

        return $from_email;
    }

    public function wp_mail_from_name()
    {
        if ($this->get('MAIL_FROM_NAME')) {
            return $this->get('MAIL_FROM_NAME');
        }

        return get_bloginfo('name');
    }
}
