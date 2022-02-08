<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Meta;
use App\Page;
use App\Setting;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.edit')->with('settings', $settings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'logo_title' => 'required|max:255',
            'admin_email' => 'required|email|max:255',
            'wav_fee' => 'required|integer|min:0',
            'tax_rate' => 'required|numeric|min:0|max:1',
            'purchase_approval_threshold' => 'required|numeric|min:0',
            'banned_words' => 'required|string|max:255',
            'featured_spot_price' => 'required|numeric|min:0'
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back();
    }
}
