<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ِِAuthController extends Controller
{
    public function __construct(protected OtpService $otpService) {}

    /**
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) { //حساب موجود لكن غير مفعل، الحسابات المفعلى تم استبعادها في validation
            return apiSuccess("الحساب موجود مسبقاً وتم إرسال رمز تفعيل جديد");
        }

        $avatarPath = null;

        if ($request->hasFile('avatar')) 
            $avatarPath = Storage::putFile('customer_images', $request->file('avatar'));
        

        try {
            $user = DB::transaction(function () use ($request, $avatarPath) {

                $user = User::create($request->safe()->only(['name', 'email',  'password',]));
                $customerData = $request->safe()->only(['gender', 'DOB', 'phone', 'lang',]);
                $customerData['avatar'] = $avatarPath;

                $user->customer()->create($customerData);

                return $user;
            });            
        } catch (\Throwable $e) {
            //محي الملف في حال حدث خطأ خلال التخزين
            if ($avatarPath) {
                Storage::delete($avatarPath);
            }
            throw $e;
        }

        $this->otpService->createOtp($user);

        return apiSuccess('تم إنشاء زبون غير مفعل');
    }

    /**
     * @param VerifyOtpRequest $request
     * @return JsonResponse
     */
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $user = user::where('email', $request->email)->first();

        if ($user->email_verified_at)
            return apiFail('تم تفعيل الحساب مسبقاً');

        $otp = $user->otp;
        if (!$otp) {
            return apiFail("لا يوجد رمز مرتبط بهذا الحساب", code: 404); // front should show button "resend otp"
        }

        if ($otp->expires_at < now()) {
            return apiFail("انتهت صلاحية الكود"); // front should show button "resend otp"
        }

        if ($otp->attempts >= 5) {
            return apiFail("تجاوزت عدد المرات المسموح"); // front should add button "resend otp"
        }

        if (!Hash::check($request->otp_hash, $otp->otp_hash)) {
            $otp->increment('attempts');
            return apiFail("الرمز المدخل غير صحيح"); // front should add button "resend otp"
        }
        $user->email_verified_at =  now();
        $user->save();

        $otp->delete();

        return apiSuccess('تم تفعيل الحساب');
    }

    /**
     * @param ResendOtpRequest $request
     * @return JsonResponse
     */
    function resendOtp(ResendOtpRequest $request): JsonResponse
    {
        $user = user::where('email', $request->email)->first();

        if (! $user)
            return apiFail('البريد الالكتروني غير موجود', code: 422);

        if ($user->email_verified_at)
            return apiSuccess('تم تفعيل الحساب مسبقاً');

        $this->otpService->createOtp($user);

        return apiSuccess("تم ارسال opt بنجاح");
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();


        if (! $user || ! Hash::check($password, $user->password)) {
            return apiFail('معلومات الدخول غير صحيحة', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! $user->email_verified_at)
            return apiFail("الحساب غير مفعل"); // front should show button "resend otp"

        $token = $user->createToken('api token');

        return apiSuccess('أهلا بك  ', [
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return apiSuccess('تم تسجيل الخروج');
    }
}
