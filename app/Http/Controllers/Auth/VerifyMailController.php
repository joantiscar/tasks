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
class VerifyMailController extends Controller
{

    public function sendVerificationMail(Request $request, User $user)
    {
        $code = MobileCodesGenerator::generate();

        $user->mobile_verification_code = $code;
        $user->save();

        $user->notify(new VerifyMobile($code));

    }
}
