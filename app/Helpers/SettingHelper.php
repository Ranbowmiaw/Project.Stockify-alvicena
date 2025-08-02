<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings;

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Setting::updateOrCreate(['key' => $k], ['value' => $v]);
            }

            $settings = Setting::pluck('value', 'key')->toArray();
            return true;
        }

        if (!$settings) {
            $settings = Setting::pluck('value', 'key')->toArray();
        }

        return $settings[$key] ?? $default;
    }
}

