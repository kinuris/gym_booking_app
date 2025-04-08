<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FeaturedInstructor;
use App\Models\HomeClientStory;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function manageAccountsView()
    {
        $clients = Client::query();

        return view('admin.manage-accounts')
            ->with('clients', $clients->get());
    }

    public function manageInstructorAccounsView()
    {
        $instructors = Instructor::query();

        return view('admin.manage-instructor-accounts')
            ->with('instructors', $instructors->get());
    }

    public function disableInstructor(Instructor $instructor)
    {
        $instructor->is_disabled = true;
        $instructor->save();

        return redirect('/admin/instructors')->with('message', 'Instructor disabled successfully.');
    }

    public function enableInstructor(Instructor $instructor)
    {
        $instructor->is_disabled = false;
        $instructor->save();

        return redirect('/admin/instructors')->with('message', 'Instructor enabled successfully.');
    }

    public function enableClient(Client $client)
    {
        $client->is_disabled = false;
        $client->save();

        return redirect('/admin')->with('message', 'Client enabled successfully.');
    }

    public function disableClient(Client $client)
    {
        $client->is_disabled = true;
        $client->save();

        return redirect('/admin')->with('message', 'Client disabled successfully.');
    }

    public function homepageStoryView()
    {
        $stories = HomeClientStory::query()->paginate(6);

        return view('admin.homepage-story')->with('stories', $stories);
    }

    public function createHomepageStory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subtitle' => 'required',
            'content' => 'required',
            'image_link_1' => 'required|image',
            'image_link_2' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            session()->flash('openModal', 1);

            return redirect('/admin/homepage-story')->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image_link_1')) {
            $path1 = $request->file('image_link_1')->store('stories', 'public');
        }

        if ($request->hasFile('image_link_2')) {
            $path2 = $request->file('image_link_2')->store('stories', 'public');
        }

        $story = new HomeClientStory();

        $story->title = $request->title;
        $story->subtitle = $request->subtitle;
        $story->body = $request->content;
        $story->image_link_1 = $path1;
        $story->image_link_2 = isset($path2) ? $path2 : null;

        $story->save();

        return redirect('/admin/homepage-story')->with('message', 'Story created successfully.');
    }

    public function toggleHomepageStory(HomeClientStory $story)
    {
        $story->status = $story->status === 'active' ? 'disabled' : 'active';

        $story->save();

        return redirect('/admin/homepage-story')->with('message', 'Story was ' . $story->status === 'active' ? 'activated' : 'disabled');
    }

    public function destroyHomepageStory(HomeClientStory $story)
    {
        $story->delete();

        return redirect('/admin/homepage-story')->with('message', 'Story was deleted');
    }

    public function updateHomepageStory(Request $request, HomeClientStory $story)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subtitle' => 'required',
            'content' => 'required',
            'image_link_1' => 'nullable|image',
            'image_link_2' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            session()->flash('openModal', 1);

            return redirect('/admin/homepage-story')->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image_link_1')) {
            Storage::disk('public')->delete($story->image_link_1);

            $path1 = $request->file('image_link_1')->store('stories', 'public');
            $story->image_link_1 = $path1;
        }

        if ($request->hasFile('image_link_2')) {
            Storage::disk('public')->delete($story->image_link_2);

            $path2 = $request->file('image_link_2')->store('stories', 'public');
            $story->image_link_2 = $path2;
        }

        $story->title = $request->title;
        $story->subtitle = $request->subtitle;
        $story->body = $request->content;

        $story->save();

        return redirect('/admin/homepage-story')->with('message', 'Story updated successfully.');
    }

    public function featuredInstructorsView()
    {
        $featuredInstructors = FeaturedInstructor::all()->map(fn($instructor) => $instructor->instructor); 

        return view('admin.featured-instructors')
            ->with('instructors', $featuredInstructors);
    }

    public function addFeaturedInstructor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/featured-instructors')->withErrors($validator);
        }

        $featuredInstructor = new FeaturedInstructor();
        $featuredInstructor->instructor_id = $request->instructor_id;

        $featuredInstructor->save();

        return redirect('/admin/featured-instructors')->with('message', 'Instructor added to featured list.');
    }

    public function removeFeaturedInstructor(Instructor $instructor)
    {
        $featuredInstructor = FeaturedInstructor::where('instructor_id', $instructor->id)->first();

        $featuredInstructor->delete();

        return redirect('/admin/featured-instructors')->with('message', 'Instructor removed from featured list.');
    }
}
