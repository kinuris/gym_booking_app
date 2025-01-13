<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Instructor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function manageAccountsView() {
        $clients = Client::query();

        return view('admin.manage-accounts')
            ->with('clients', $clients->get());
    }

    public function manageInstructorAccounsView() {
        $instructors = Instructor::query();

        return view('admin.manage-instructor-accounts')
            ->with('instructors', $instructors->get());
    }
    
    public function disableInstructor(Instructor $instructor) {
        $instructor->is_disabled = true;
        $instructor->save();

        return redirect('/admin/instructors')->with('message', 'Instructor disabled successfully.');
    }

    public function enableInstructor(Instructor $instructor) {
        $instructor->is_disabled = false;
        $instructor->save();

        return redirect('/admin/instructors')->with('message', 'Instructor enabled successfully.');
    }

    public function enableClient(Client $client) {
        $client->is_disabled = false;
        $client->save();

        return redirect('/admin')->with('message', 'Client enabled successfully.');
    }

    public function disableClient(Client $client) {
        $client->is_disabled = true;
        $client->save();

        return redirect('/admin')->with('message', 'Client disabled successfully.');
    }
}
