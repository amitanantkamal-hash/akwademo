<?php

namespace App\Actions\Fortify;

use App\Helpers\StaticHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Http\Controllers\HubSpotController;
use App\Helpers\HubSpotHelper;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\PendingUser;
use App\Mail\VerifyPendingUserMail;
use Illuminate\Support\Facades\Mail;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */

    protected $hubSpotHelper;
    protected $request;

    public function __construct(HubSpotHelper $hubSpotHelper, Request $request)
    {
        $this->hubSpotHelper = $hubSpotHelper;
        $this->request = $request;
    }

    // public function create(array $input): User
    // {
    // //     $phone = trim(preg_replace('/[\s+]+/', '', $input['phone']));
    // //    // $phone = '+' . $input['country_code'] . $phone;
    // //    // $input['phone'] = $phone;

    //     Validator::make($input, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'phone' => ['required', 'string', 'max:255', 'unique:users,phone'], // Add 'phone' to the validation rules
    //         'name_company' => ['required', 'string', 'max:255'],
    //         'password' => $this->passwordRules(),
    //         'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
    //     ])->validate();

    //     $phone = '+' . $input['country_code'] . trim($input['phone']);
    //     $phone = trim(preg_replace('/[\s]/', '',  $phone));

    //     $userData = [
    //         'name' => $input['name'],
    //         'name_company' => $input['name_company'],
    //         'email' => $input['email'],
    //         'password' => Hash::make($input['password']),
    //         'phone' => $phone,
    //         'is_optin' => isset($input['is_optin']) && $input['is_optin'] === 'on' ? 1 : 0,
    //     ];

    //     if (env('OTP_VERIFICATION') == true) {
    //         // If OTP verification is enabled, generate OTP and set verification status
    //         $otp = rand(100000, 999999);
    //         $userData['otp'] = $otp;
    //         $userData['otp_sent_at'] = now();
    //         $userData['is_otp_verified'] = 0; // Initially not verified
    //     } else {
    //         // If OTP verification is disabled, mark as verified automatically
    //         $userData['is_otp_verified'] = 1;
    //     }

    //     // Create the user with the conditional data
    //     //dd($userData);
    //     $user = User::create($userData);
    //     $user->plan_id = config('settings.free_pricing_id');
    //     $user->trial_ends_at = Carbon::now()->addDays(config('settings.free_trail_days'));
    //     $user->free_plan_used = true;
    //     $user->save();

    //     $user->assignRole('owner');

    //     //Create company
    //     $lastCompanyId = DB::table('companies')->insertGetId([
    //         'name' => $input['name'],
    //         'subdomain' => strtolower(preg_replace('/[^A-Za-z0-9]/', '', $input['name'])),
    //         'user_id' => $user->id,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //         'phone' => $phone, // Add 'phone' to the company creation
    //         'logo' => asset('uploads') . '/default/no_image.jpg',
    //     ]);

    //     if (env('OTP_VERIFICATION') == true) {
    //         //Send Message to WA
    //         StaticHelper::sendWA_OTP($otp, $phone);
    //     }
    //     $user->company_id = $lastCompanyId;
    //     $user->update();
    //     // //by brij negi
    //     // // Get form data
    //     // if (!empty($input['email']) && !empty($input['name']) && !empty($phone)) {
    //     //     $contactData = [
    //     //         'email' => $input['email'],
    //     //         'firstname' => $input['name'],
    //     //         'lastname' => '',
    //     //         'phone' => $phone
    //     //         // Add more contact properties if needed
    //     //     ];

    //     //     $contactId = null;

    //     //     // Call Controller function to save contact
    //     //     $contactResponse = $this->hubSpotHelper->addContact($contactData);

    //     //     $isPropertiesArray = isset($contactResponse['id']);

    //     //     if ($isPropertiesArray) {
    //     //         // Get contact ID from response if successful
    //     //         $contactId = $contactResponse->getId();
    //     //         // Update user with Hubspot contact ID if successful
    //     //         $user->hubspot_contactId = $contactId;
    //     //         $user->save();
    //     //     } else {
    //     //         // Update user with Hubspot contact ID find by user email address
    //     //         $contactResponseData = $this->hubSpotHelper->findContactIdByEmail($input['email']);
    //     //         $contactResponse  = json_decode($contactResponseData->getContent(), true);
    //     //         $isPropertiesArray = isset($contactResponse['contact_id']);

    //     //         if ($isPropertiesArray) {

    //     //             $contactId = $contactResponse['contact_id'];
    //     //             // Update user with Hubspot contact ID if successful
    //     //             $user->hubspot_contactId = $contactId;
    //     //             $user->save();
    //     //         }
    //     //         // Handle error if contact creation failed
    //     //         //dd($contactResponse);
    //     //     }

    //     //     $freeListId = env('HUBSPOT_FREE_SUBSCRIPTION_LIST_ID');

    //     //     //add contact to list
    //     //     if (!empty($contactId) && !empty($freeListId)) {
    //     //         $this->hubSpotHelper->addContactToList($freeListId, $contactId);
    //     //     }
    //     // }

    //     // //necesario para el modulo de referidos
    //     // event(new Registered($user));

    //     return $user;
    // }

    public function create(array $input)
    {
        //
    }
}
