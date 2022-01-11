<?php

namespace App\Library\Notification;

use App\Mail\NewUser;
use App\Mail\ResetPassword;
use App\Mail\TestMailer;
use App\Models\Setting;
use App\Traits\Singleton;
use Illuminate\Support\Facades\Mail;

class Email
{

    use Singleton;

    public $config;
    public $template;
    public $error;

    public function __construct($config = [])
    {
        $this->config = $this->error = [];

        $this->initSettings();

        $this->initConfig(is_array($config) ? $config : []);

    }

    private function initSettings()
    {
        $settings = Setting::select('field', 'value')
            ->whereIn('field', [
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_from_address',
                'mail_from_name',
                'mail_encryption',
            ])->get();

        foreach ($settings as $data) {
            $this->config[$data->field] = $data->value;
        }
    }

    public function initConfig(array $config = [])
    {

        $this->config = array_merge($this->config, $config);

        if (!isset($this->config['data'])) {
            $this->config['data'] = [];
        }

        $this->setConfig();

        return $this;
    }

    public function setConfig()
    {
        $host = isset($this->config['mail_host']) ? $this->config['mail_host'] : env('MAIL_HOST', 'mail.maacinfo.com');
        $port = isset($this->config['mail_port']) ? $this->config['mail_port'] : env('MAIL_PORT', '465');
        $username = isset($this->config['mail_username']) ? $this->config['mail_username'] : env('MAIL_USERNAME', '');
        $password = isset($this->config['mail_password']) ? $this->config['mail_password'] : env('MAIL_PASSWORD', '');
        $encryption = isset($this->config['mail_encryption']) ? $this->config['mail_encryption'] : env('MAIL_ENCRYPTION', 'tls');
        $fromAddress = isset($this->config['mail_from_address']) ? $this->config['mail_from_address'] : 'lms@marketaccesspl.com';
        $fromName = isset($this->config['mail_from_name']) ? $this->config['mail_from_name'] : 'Somriddhi';
        config([
            'mail.host' => trim($host),
            'mail.port' => intval($port),
            'mail.username' => trim($username),
            'mail.password' => trim($password),
            'mail.encryption' => trim($encryption),
            'mail.from.address' => trim($fromAddress),
            'mail.from.name' => trim($fromName),
        ]);

        if (isset($this->config['template'])) {
            $this->template = $this->config['template'];
        } elseif (isset($this->config['type'])) {
            switch ($this->config['type']) {
                case 'new-user':
                    $this->template = new NewUser($this->config['data']);
                    break;
                case 'reset-password':
                    $this->template = new ResetPassword($this->config['data']);
                    break;

                default:
                    $this->template = new TestMailer($this->config['data']);
                    break;
            }
        }

    }

    public function send(string $emailTo = '')
    {
        if (empty($this->template)) {
            $this->error = [
                'message' => 'Mail template is not specified',
            ];
            return false;
        }

        try {
            Mail::to(empty($emailTo) ? $this->config['receiver'] : $emailTo)
                ->send($this->template);
        } catch (\Swift_TransportException $e) {
            $this->error = [
                'message' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            $this->error = [
                'message' => $e->getMessage(),
            ];
        }

        if (!empty(Mail::failures())) {
            $this->error = [
                'message' => 'Failed to send email to some address',
                'emails' => Mail::failures(),
            ];
        }

        return empty($this->error) ? true : $this->error;
    }
}
