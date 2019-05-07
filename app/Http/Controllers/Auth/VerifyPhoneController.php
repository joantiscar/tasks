<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyMobile;
use App\User;
use Carbon\Carbon;
use App\CodeGenerator\MobileCodesGenerator;
use Illuminate\Http\Request;

/**
 * Class VerifyMobileController.
 *
 * @package App\Http\Controllers\Tenant\Api\SMS
 */
class VerifyPhoneController extends Controller
{
    public function verify(Request $request, User $user)
    {
        if ($request->code === $user->mobile_verification_code) {
            $user->mobile_verified_at = Carbon::now();
            $user->mobile_verification_code = null;
            $user->save();
        }
        else abort(422,'El codi no és correcte');
    }

    public function requestCode(Request $request, User $user)
    {
        $code = MobileCodesGenerator::generate();

        $user->mobile_verification_code = $code;
        $user->save();

        $user->notify(new VerifyMobile($code));

    }
}
