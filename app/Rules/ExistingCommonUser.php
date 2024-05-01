<?php

namespace App\Rules;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistingCommonUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::whereId($value)
            ->whereType(UserTypeEnum::Common)
            ->exists();

        if(!$user)
            $fail('Only common users can execute transfers');
    }
}
