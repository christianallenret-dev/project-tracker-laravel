<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            // 'id_number' => $this->generateIDNumber(),
        ]);
    }

    /*
        private function generateIDNumber(): string
        {
            // format: YYYY-CO-NNNN
            // YYYY: year
            // CO: code (01 for teacher, 02 for student)
            // NNNN: 4-digit sequential number
            $year = now()->year;
            $code = '01';

            // find the last user with the same year and code
            // get the 4 digit number
            // increment by 1
            // format as 4 digit number
            // return the id_number
            // if no last user, return 0001
            $lastUser = User::where('id_number', 'like', "{$year}-{code}-%")
                ->orderBy('id')
                ->first();

            $nextNumber = $lastUser ? ((int) last(explode('-', $lastUser->id_number))) + 1 : 1;

            return sprintf("{$year}-{$code}-%04d", $nextNumber);
        }
    */

}
