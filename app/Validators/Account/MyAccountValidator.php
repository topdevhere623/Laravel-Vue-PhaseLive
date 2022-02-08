<?php namespace App\Validators\Account;

use Illuminate\Http\Request;

use App\Validators\PhaseValidator;

use Hash;
use Validator;

/**
 * Class MyAccountValidator
 *
 * Validate inputs from the account page
 *
 * @package App\Validators\Account
 */
class MyAccountValidator extends PhaseValidator
{
    public function validateEmail(Request $request)
    {
        $this->fails = false;
        $this->validator = Validator::make($request->all(), [
            'address' => 'nullable|email|unique:users,email'
        ]);
    }

    public function validatePassword(Request $request)
    {
        $this->fails = false;
        $this->validator = Validator::make($request->all(), [
            'current' => 'required',
            'new' => 'required|same:confirm',
            'confirm' => 'required',
        ]);
        $this->fails = !Hash::check($request->current, $request->user()->password);
    }
}