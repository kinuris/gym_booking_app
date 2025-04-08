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
use Illuminate\Support\Facades\Http;
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

        $client = $session->client;

        $emailContent = '<div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #0056b3;">New Event Created!</h2>
            <p>Dear ' . $client->fullname . ',</p>
            <p>A new event has been created for your coaching session.</p>
            <p>Here are the details:</p>
            <div style="margin-top: 20px; padding: 15px; background-color: #f4f4f4; border-left: 5px solid #0056b3;">
            <strong>Event Details:</strong><br>
            Event Type: ' . $event->event_type . '<br>';

        if ($event->event_type == 'Unavailability Notice') {
            $emailContent .= '<p style="color:red; font-size:1.2em; font-weight:bold;">IMPORTANT: This is an Unavailability Notice.</p>';
        }

        $emailContent .= 'Event Date: ' . $event->event_date . '<br>';
        $emailContent .= 'Notes: ' . $event->notes . '
            </div>
            <p style="margin-top: 20px;">Best regards,<br>The TN Team</p>
        </div>';

        if (env('ZAPIER_EMAIL_ENABLED') == true) {
            Http::post(
                env('ZAPIER_WEBHOOK'),
                [
                    'email' => $client->email,
                    'subject' => 'New event created: ' . $event->event_type,
                    'content' => $emailContent,
                ]
            );
        }

        return redirect('/instructor/clients')->with('message', 'Event created successfully.');
    }

    public function deleteEvent(SessionEvent $event)
    {
        $event->delete();

        $client = $event->session->client;

        $emailContent = '<div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #0056b3;">Event Deleted!</h2>
                <p>Dear ' . $client->fullname . ',</p>
                <p>An event has been deleted from your coaching session.</p>
                <p>Here are the details:</p>
                <div style="margin-top: 20px; padding: 15px; background-color: #f4f4f4; border-left: 5px solid #0056b3;">
                <strong>Event Details:</strong><br>
                Event Type: ' . $event->event_type . '<br>';

        if ($event->event_type == 'Unavailability Notice') {
            $emailContent .= '<p style="color:red; font-size:1.2em; font-weight:bold;">IMPORTANT: This was an Unavailability Notice.</p>';
        }

        $emailContent .= 'Event Date: ' . date('F j, Y', strtotime($event->event_date)) . '<br>';
        $emailContent .= 'Notes: ' . $event->notes . '
                </div>
                <p style="margin-top: 20px;">Best regards,<br>The TN Team</p>
            </div>';

        if (env('ZAPIER_EMAIL_ENABLED') == true) {
            Http::post(
                env('ZAPIER_WEBHOOK'),
                [
                    'email' => $client->email,
                    'subject' => 'Event deleted: ' . $event->event_type,
                    'content' => $emailContent,
                ]
            );
        }

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

        $instructor = Instructor::query()->find($request->input('instructor_id'));

        // Send notification to the instructor
        if (env('ZAPIER_EMAIL_ENABLED') == true) {
            Http::post(
                env('ZAPIER_WEBHOOK'),
                [
                    'email' => $instructor->email,
                    'subject' => 'New monthly session at TN: ' . $client->fullname,
                    'content' => '<div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #0056b3;">New Coaching Session!</h2>
        <p>Dear ' . $instructor->fullname . ',</p>
        <p>A new monthly coaching session has been scheduled with you by <strong>' . $client->fullname . '</strong>.</p>
        <p>Please check your dashboard for more details and to confirm the session.</p>
        <p>Thank you for your dedication to helping others achieve their fitness goals!</p>
        <div style="margin-top: 20px; padding: 15px; background-color: #f4f4f4; border-left: 5px solid #0056b3;">
            <strong>Session Details:</strong><br>
            Client: ' . $client->fullname . '<br>
            Start Date: ' . $request->input('start_date') . '<br>
            End Date: ' . $request->input('end_date') . '
        </div>
        <p style="margin-top: 20px;">Best regards,<br>The TN Team</p>
        </div>',
                ]
            );
        }

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
