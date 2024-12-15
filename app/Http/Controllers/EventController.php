<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function showevent()
    {
        $event = Event::all();
        return view('event', compact('event'));
    }

    public function showeventcust()
    {
        $event = Event::all();
        return view('eventcust', compact('event'));
    }

    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $admins = User::where('usertype', 'admin')->get(); // Fetch only admins
        $users = User::where('usertype', 'user')->get(); // Fetch only users

        return view('events.create', compact('admins', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'eventid'      => ['required'],
            'eventname'    => ['required'],
            'eventdate'    => ['required'],
            'eventtime'    => ['required'],
            'eventplace'   => ['required'],
            'eventpicture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ]);

        if ($request->hasFile('eventpicture')) {
            // Define the target directory
            $targetDirectory = public_path('storage/eventpictures');

            // Ensure the directory exists
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            // Generate a unique file name
            $fileName = time() . '_' . $request->file('eventpicture')->getClientOriginalName();

            // Move the file to the target directory
            $request->file('eventpicture')->move($targetDirectory, $fileName);

            // Save the relative path in the database
            $validatedData['eventpicture'] = 'storage/eventpictures/' . $fileName;
        }

        Event::create($validatedData);

        return redirect()->route('events.index')
            ->with('success', 'Event Created Successfully.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $admins = User::where('usertype', 'admin')->get(); // Fetch only admins
        $users = User::where('usertype', 'user')->get(); // Fetch only users
        return view('events.edit', compact('event', 'admins', 'users')); // Pass event, admins, and users to the view
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'eventid'      => ['required'],
            'eventname'    => ['required'],
            'eventdate'    => ['required'],
            'eventtime'    => ['required'],
            'eventpicture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ]);

        if ($request->hasFile('eventpicture')) {
            if ($event->eventpicture) {
                // Delete the old picture from storage
                $oldPath = public_path($event->eventpicture);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Define the target directory
            $targetDirectory = public_path('storage/eventpictures');

            // Ensure the directory exists
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            // Generate a unique file name
            $fileName = time() . '_' . $request->file('eventpicture')->getClientOriginalName();

            // Move the file to the target directory
            $request->file('eventpicture')->move($targetDirectory, $fileName);

            // Save the relative path in the database
            $event->eventpicture = 'storage/eventpictures/' . $fileName;
        }

        // Update event details
        $event->update([
            'eventid'      => $request->eventid,
            'eventname'    => $request->eventname,
            'eventdate'    => $request->eventdate,
            'eventtime'    => $request->eventtime,
            'eventpicture' => $event->eventpicture ?? $event->getOriginal('eventpicture'),
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event Updated Successfully.');
    }





    public function destroy(Event $event)
    {
        if ($event->eventpicture) {
            Storage::disk('public')->delete($event->eventpicture);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event Deleted Successfully.');
    }
}
