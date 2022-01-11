<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function emailConfig(Request $request)
    {
        $settings = Setting::where('field', 'like', 'mail_%')->get();

        if ($settings->isEmpty()) {

            Setting::insert([
                ['field' => 'mail_host', 'value' => 'mail.maacinfo.com'],
                ['field' => 'mail_port', 'value' => '465'],
                ['field' => 'mail_username', 'value' => ''],
                ['field' => 'mail_password', 'value' => ''],
                ['field' => 'mail_from_address', 'value' => 'no-reply@maacinfo.com'],
                ['field' => 'mail_from_name', 'value' => 'MAAC Info'],
                ['field' => 'mail_encryption', 'value' => 'tls'],
            ]);

            $settings = Setting::where('field', 'like', 'mail_%')->get();
        } elseif ($request->mail_host) {

            foreach ($settings as $data) {
                if ($request->mail_host && $data->field == 'mail_host') {
                    $data->value = trim($request->mail_host);
                    $data->save();
                } elseif ($request->mail_port && $data->field == 'mail_port') {
                    $data->value = trim($request->mail_port);
                    $data->save();
                } elseif ($request->mail_username && $data->field == 'mail_username') {
                    $data->value = trim($request->mail_username);
                    $data->save();
                } elseif ($request->mail_password && $data->field == 'mail_password') {
                    $data->value = trim($request->mail_password);
                    $data->save();
                } elseif ($request->mail_from_address && $data->field == 'mail_from_address') {
                    $data->value = trim($request->mail_from_address);
                    $data->save();
                } elseif ($request->mail_from_name && $data->field == 'mail_from_name') {
                    $data->value = trim($request->mail_from_name);
                    $data->save();
                } elseif ($request->mail_encryption && $data->field == 'mail_encryption') {
                    $data->value = trim($request->mail_encryption);
                    $data->save();
                }
            }
            $request->session()->flash('success', 'Email settings updated successfully');
        }

        return view('admin.settings.email', [
            'settings' => $settings,
        ]);
    }

}
