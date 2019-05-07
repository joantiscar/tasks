<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;

/**
 * Class VerifyMobileController.
 *
 * @package App\Http\Controllers\Tenant\Web
 */
class PhoneVerificationController extends Controller
{
    /**
     * @param ShowUsersManagement $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('sms.index');
    }

}
