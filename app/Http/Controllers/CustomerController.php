<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request)
    {
        $customer = $request->user()->customer;

        $data = $request->validated();

        if ($request->hasFile('avatar')) {

            if ($customer->avatar) {
                Storage::delete($customer->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('customer-avatars');
        }

        $customer->update($data);

        return apiSuccess('تم تعدبل البيانات بنجاح ', new CustomerResource($customer->load('user')));
    }

    public function show()
    {
        $customer = request()->user()
            ->customer()
            ->with('user')
            ->first();

        if (! $customer) {
            return apiFail('سجل الزبون غير موجود', 404);
        }

        return apiSuccess(
            'تم قراءة بينات الزبون',
            new CustomerResource($customer)
        );
    }
}
