<?php

namespace App\Http\Controllers;

use App\Helpers\GoogleDrive;
use App\Mail\ContactUs;
use App\Mail\UserConfirmation;
use App\Models\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /////////////////////////////////////////////////////////////
    /// DDTNET = DISABLED/NOT FULLY OK DUE TO NOT ENOUGH TIME ///
    /////////////////////////////////////////////////////////////

    public function handleFormSubmit()
    {
//        ddd(request()->post());
//        ddd(request()->file());
        $validator = Validator::make(request()->post(), [
            'email'       => 'email|required',
//            '_token'   => 'required', // Disabled CSRF DDTNET
            'name'        => 'required',
            'nationality' => 'numeric|required',
            'are-you'     => 'required', // DDTNET
            'title'       => 'required',
            'story'       => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('alert_ko', 'Invalid data on the form. Please try again!');

            return redirect(route('homepage', ['bypassed-js-validation']));
        }

        // Handle uploads or share link
        $googleDrive = new GoogleDrive();
        $files       = [];
        if (request()->hasFile('file_text')) {
            foreach (request()->file('file_text') as $file) {
                $storage_path = $file->store('uploads');
                $full_path    = Storage::path($storage_path);
                // Upload it
                $files[] = $googleDrive->storeAndGetURL($full_path);
                Storage::delete($storage_path);
            }
        }
        if (request()->hasFile('file_media')) {
            foreach (request()->file('file_media') as $file) {
                $storage_path = $file->store('uploads');
                $full_path    = Storage::path($storage_path);
                // Upload it
                $files[] = $googleDrive->storeAndGetURL($full_path);
                Storage::delete($storage_path);
            }
        }
        if (request()->post('share_link') && filter_var(request()->post('share_link'), FILTER_VALIDATE_URL)) {
            $files[] = request()->post('share_link');
        }

        // All is probably (DDTNET) fine ... send the email
        $paramsEmail = [
            'data'  => [
                'email'       => request()->post('email'),
                'name'        => request()->post('name'),
                'nationality' => Country::findOrFail(intval(request()->post('nationality'))),
                'are-you'     => request()->post('are-you'),
                'title'       => request()->post('title'),
                'story'       => request()->post('story'),
                'accept'      => request()->post('accept', 'no'),
            ],
            'to'    => config('custom.where-to-send-email'),
            'files' => $files,
        ];

        $this->sendEmail($paramsEmail);
//        Session::flash('alert_ok', 'Thank you for your submission!');
//        return redirect(route('homepage', ['#js-confirmation-box']));
        return view('success');
    }

    private function sendEmail($paramsEmail)
    {
        Mail::to($paramsEmail['data']['email'])->send(new UserConfirmation());
        Mail::to($paramsEmail['to'])->send(new ContactUs($paramsEmail));

        return true;
    }
}
