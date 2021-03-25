<?php

Class LiqpayActivation
{
    private static $apiUrl = 'https://webplus.com.ua/wp-plugin-activation/liqpay';

    public function __construct($file)
    {
        register_activation_hook( $file, array($this, 'activation') );

        add_action( 'upgrader_process_complete', array($this, 'activation'), 10, 2 );

        add_filter( 'site_admin_email_change_email', array($this, 'site_admin_email_change_email'), 10, 3 );

    }

    private function runApi($data)
    {
        @file_get_contents(self::$apiUrl . '?' . build_query($data));
    }

    public function activation()
    {
        $data = array(
            'domain' => get_home_url(),
            'email' => get_option('admin_email')
        );
        $this->runApi($data);
    }

    public function site_admin_email_change_email( $email_change_email, $old_email, $new_email ){
        $data = array(
            'domain' => get_home_url(),
            'email' => $new_email
        );
        $this->runApi($data);

        return $email_change_email;
    }

}