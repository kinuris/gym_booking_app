<?php

namespace App\Http\Controllers;

use App\Models\ClientNotification;
use App\Models\CoachingSession;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'profile_image' => 'nullable',
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

        return redirect('/instructor/clients')->with('message', 'Session started.');
    }

    public function cancelSession(CoachingSession $session)
    {
        $session->status = 'Canceled';

        $session->save();

        return redirect('/instructor/clients')->with('message', 'Session cancelled.');
    }
}
