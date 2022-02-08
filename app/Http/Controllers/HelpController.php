<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use App\Mail\Help\AdminContactFormSubmitted;
use App\FaqCategory;
use App\User;

class HelpController extends Controller
{
    public function listFaqs()
    {
        return FaqCategory::inOrder()->get();
    }

    public function postContactForm(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send to main site admin email
        Mail::to(setting('admin_email'))
            ->send(new AdminContactFormSubmitted($validated));

        // Send to all users with permission to receive contact submissions
        $users = User::permission('receive contact submissions')->get();
        foreach ($users as $user) {
            Mail::to($user)
                ->send(new AdminContactFormSubmitted($validated));
        }
    }
}
