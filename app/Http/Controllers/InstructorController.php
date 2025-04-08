<?php

namespace App\Http\Controllers;

use App\Models\ClientNotification;
use App\Models\CoachingSession;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    public function updatePricing(Request $request, Instructor $instructor)
    {
        $request->validate([
            'hourly_rate' => 'required',
            'monthly_rate' => 'required',
        ]);


        $instructor->monthly_rate = $request->monthly_rate;
        $instructor->hourly_rate = $request->hourly_rate;
        $instructor->save();

        return back()->with('message', 'Successfully updated rates.');
    }

    public function updateProfile(Request $request, Instructor $instructor)
    {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'required|email',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'phone_number' => 'required',
            'bio' => 'nullable',
        ]);

        $instructor->first_name = $request->first_name;
        $instructor->middle_name = $request->middle_name;
        $instructor->last_name = $request->last_name;
        $instructor->email = $request->email;

        if ($request->hasFile('profile_image')) {
            if ($instructor->profile_image) {
                Storage::disk('public')->delete($instructor->profile_image);
            }

            $file = $request->file('profile_image');
            $path = $file->store('profile_images', 'public');

            $instructor->profile_image = $path;
        }

        $instructor->phone_number = $request->phone_number;
        $instructor->bio = $request->bio;
        $instructor->save();

        return back()->with('message', 'Successfully updated profile.');
    }

    public function profileView()
    {
        $instructor = Auth::guard('instructor')->user();
        $notifications = $instructor->notifications;

        return view('instructor.profile')->with('instructor', $instructor)->with('notifications', $notifications);
    }

    public function clientsView()
    {
        $sessions = Instructor::query()->find(Auth::guard('instructor')->user()->id)->sessions;

        return view('instructor.my-sessions')->with('sessions', $sessions);
    }

    public function startSession(CoachingSession $session)
    {
        $session->status = 'Accepted';

        $session->save();

        $clientAlert = new ClientNotification();
        $clientAlert->title = 'Session Started';
        $clientAlert->body = 'Your session with ' . $session->instructor->fullname . ' has started.';
        $clientAlert->client_id = $session->client->id;
        $clientAlert->save();

        if (env('ZAPIER_EMAIL_ENABLED') == true) {
            Http::post(
                env('ZAPIER_WEBHOOK'),
                [
                    'email' => $session->client->email,
                    'subject' => 'Session Started with: ' . $session->instructor->fullname,
                    'content' => '<div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #0056b3;">Session Started!</h2>
                <p>Dear ' . $session->client->fullname . ',</p>
                <p>Your session with <strong>' . $session->instructor->fullname . '</strong> has started.</p>
                <p>Get ready to achieve your fitness goals!</p>
                <div style="margin-top: 20px; padding: 15px; background-color: #f4f4f4; border-left: 5px solid #0056b3;">
                <strong>Session Details:</strong><br>
                Instructor: ' . $session->instructor->fullname . '<br>
                Date: ' . $session->start_date . '<br>
                </div>
                <p style="margin-top: 20px;">Best regards,<br>The TN Team</p>
            </div>',
                ]
            );
        }

        return redirect('/instructor/clients')->with('message', 'Session started.');
    }

    public function cancelSession(CoachingSession $session)
    {
        $session->status = 'Canceled';

        $session->save();

        return redirect('/instructor/clients')->with('message', 'Session cancelled.');
    }
}
