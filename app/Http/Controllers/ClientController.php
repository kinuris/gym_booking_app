<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CoachingSession;
use App\Models\Instructor;
use App\Models\InstructorNotification;
use App\Models\SessionEvent;
use App\Models\SessionStar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function profileView()
    {
        $client = Auth::guard('client')->user();
        $notifications = $client->notifications;

        return view('client.profile')->with('client', $client)->with('notifications', $notifications);
    }

    public function createEvent(Request $request, CoachingSession $session)
    {
        $request->validate([
            'event_date' => 'required|date',
            'event_type' => 'required',
            'notes' => 'required',
        ]);

        $event = new SessionEvent();
        $event->event_date = $request->input('event_date');
        $event->event_type = $request->input('event_type');
        $event->notes = $request->input('notes');
        $event->coaching_session_id = $session->id;

        $event->save();

        return redirect('/instructor/clients')->with('message', 'Event created successfully.');
    }

    public function deleteEvent(SessionEvent $event)
    {
        $event->delete();

        return redirect('/instructor/clients')->with('message', 'Event deleted successfully.');
    }

    public function updateEvent(Request $request, SessionEvent $event)
    {
        $request->validate([
            'event_type' => 'required',
            'notes' => 'required',
        ]);

        $event->event_type = $request->input('event_type');
        $event->notes = $request->input('notes');

        $event->save();

        return redirect('/instructor/clients')->with('message', 'Event updated successfully.');
    }

    public function browseView()
    {
        $instructors = Instructor::query();

        $instructors = $instructors->get();

        return view('client.browse')->with('instructors', $instructors);
    }

    public function scheduleView(Instructor $instructor)
    {
        return view('client.schedule-session')->with('instructor', $instructor);
    }

    public function scheduleMonthly(Request $request)
    {
        $request->validate([
            // 'duration' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            // 'location' => 'required',
            'instructor_id' => 'required',
        ]);

        $client = Auth::guard('client')->user();

        $coachingSession = new CoachingSession();
        $coachingSession->instructor_id = $request->input('instructor_id');
        $coachingSession->client_id = $client->id;
        // $coachingSession->duration = $request->input('duration');
        // $coachingSession->location = $request->input('location');
        $coachingSession->start_date = $request->input('start_date');
        $coachingSession->end_date = $request->input('end_date');
        $coachingSession->type = 'monthly';
        $coachingSession->save();

        $instructorAlert = new InstructorNotification();
        $instructorAlert->title = 'New Monthly Session!';
        $instructorAlert->body = 'A new monthly session has been scheduled with you. From ' . $client->fullname;
        $instructorAlert->instructor_id = $request->input('instructor_id');
        $instructorAlert->save();

        return redirect('/client')->with('message', 'Monthly coaching session scheduled successfully.');
    }

    public function scheduleHourly(Request $request)
    {
        $request->validate([
            // 'duration' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            // 'location' => 'required',
            'instructor_id' => 'required',
        ]);

        $client = Auth::guard('client')->user();

        $coachingSession = new CoachingSession();
        $coachingSession->instructor_id = $request->input('instructor_id');
        $coachingSession->client_id = $client->id;
        // $coachingSession->duration = $request->input('duration');
        // $coachingSession->location = $request->input('location');
        $coachingSession->start_date = $request->input('start_date');
        $coachingSession->end_date = $request->input('end_date');
        $coachingSession->type = 'hourly';
        $coachingSession->save();

        $instructorAlert = new InstructorNotification();
        $instructorAlert->title = 'New Hourly Session!';
        $instructorAlert->body = 'A new hourly session has been scheduled with you. From ' . $client->fullname;
        $instructorAlert->instructor_id = $request->input('instructor_id');
        $instructorAlert->save();

        return redirect('/client')->with('message', 'Monthly coaching session scheduled successfully.');
    }

    public function clientSessions()
    {
        $sessions = Client::query()->find(Auth::guard('client')->user()->id)->sessions;

        return view('client.my-sessions')->with('sessions', $sessions);
    }

    public function setStars(Request $request, CoachingSession $session)
    {
        $request->validate([
            'rating' => 'required',
            'comment' => 'nullable',
        ]);

        if (!$session->rating) {
            $sessionStar = new SessionStar();
            $sessionStar->stars = $request->rating;
            $sessionStar->comment = $request->comment ?? '';
            $sessionStar->coaching_session_id = $session->id;

            $sessionStar->save();
        } else {
            $session->rating->stars = $request->rating;
            $session->rating->comment = $request->comment ?? '';

            $session->rating->save();
        }

        $session->save();

        return redirect('/my/sessions')->with('message', 'Sucessfully submitted rating');
    }

    public function setNotes(Request $request, CoachingSession $session)
    {
        $notes = $request->json('notes');

        $session->notes = $notes;
        $session->save();
    }

    public function updateProfile(Request $request, Client $client)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $client->first_name = $request->input('first_name');
        $client->middle_name = $request->input('middle_name');
        $client->last_name = $request->input('last_name');
        $client->email = $request->input('email');
        $client->phone_number = $request->input('phone_number');
        $client->birthdate = $request->input('birthdate');
        $client->gender = $request->input('gender');

        if ($request->hasFile('profile_image')) {
            if ($client->profile_image) {
                Storage::disk('public')->delete($client->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $client->profile_image = $imagePath;
        }

        $client->save();

        return redirect()->back()->with('message', 'Profile updated successfully.');
    }

    public function endSession(CoachingSession $session)
    {
        $session->disabled = true;
        $session->status = 'Canceled';
        $session->save();

        $instructorAlert = new InstructorNotification();
        $instructorAlert->title = 'Session Canceled';
        $instructorAlert->body = 'Your ' . $session->type . ' session has been canceled by ' . Auth::guard('client')->user()->fullname;
        $instructorAlert->instructor_id = $session->instructor->id;
        $instructorAlert->save();

        return redirect('/my/sessions')->with('message', 'Session ended.');
    }
}
