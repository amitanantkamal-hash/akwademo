<?php

namespace Modules\CTWAMeta\Services;

use JanuSoftware\Facebook\PersistentData\PersistentDataInterface;
use Illuminate\Support\Facades\Session;

class LaravelPersistentDataHandler implements PersistentDataInterface
{
    public function get(string $key): mixed
    {
        // Special handling for state parameter
        if ($key === 'state') {
            return Session::get('fb_oauth_state');
        }
        return Session::get('fb_'.$key);
    }

    public function set(string $key, mixed $value): void
    {
        // Special handling for state parameter
        if ($key === 'state') {
            Session::put('fb_oauth_state', $value);
        } else {
            Session::put('fb_'.$key, $value);
        }
        
        // Force immediate save
        Session::save();
    }
}