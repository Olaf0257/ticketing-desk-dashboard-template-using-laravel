<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Setting;

class FooterController extends Controller
{
    public function privacyPolicy()
    {
        $data = Setting::where('name', 'privacy_policy')->first();
        return view('footer.privacy_policy', $data);
    }

    public function terms()
    {
        $data = Setting::where('name', 'terms_of_use')->first();
        return view('footer.terms', $data);
    }
}
