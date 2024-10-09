<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManagementUsersController extends Controller
{


    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::all(); // Fetch all events
        return view('users.create', compact('events'));
    }

    // Generate random user_id
    private function generateSequentialUserId()
    {
        // Get the maximum user_id from the database
        $maxUserId = User::max('user_id');

        // Increment the user_id by 1 for the new user
        // Make sure to handle the case where no users exist
        return $maxUserId ? $maxUserId + 1 : 1; // Start from 1 if no users exist
    }

    // Store function for creating a new user and assigning events
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_name' => 'required|string|unique:m_user,user_name',
            'user_password' => 'required|string',
            'event_ids' => 'required|array', // array of event IDs
        ]);

        // Generate the unique user_id
        $userId = $this->generateSequentialUserId();

        // Create the new user
        $user = User::create([
            'user_id' => $userId,
            'user_name' => $request->user_name,
            'user_password' => bcrypt($request->user_password), // Hash the password
            'user_level' => 'admin', // Assign admin level by default
        ]);

        // Store the user events
        foreach ($request->event_ids as $eventId) {
            UserEvent::create([
                'user_id' => $user->user_id,
                'event_id' => $eventId,
            ]);
        }

        // Redirect or show a success message
        return redirect()->route('users.create')->with('success', 'User and associated events created successfully.');
    }

    public function edit(User $user)
    {
        $events = Event::all(); // Fetch all events
        $userEventFind = UserEvent::where('user_id', $user->user_id)->pluck('event_id')->toArray();
        $userEvent = Event::find($userEventFind[0]);
        return view('users.edit', compact('user', 'events', 'userEvent'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validate the incoming request
        $request->validate([
            'user_name' => 'required|string',
            'user_password' => 'nullable|string', // Password is optional for update
            'event_ids' => 'required|array', // array of event IDs
        ]);

        // Update the user details
        $user->user_name = $request->user_name;

        // Only update the password if provided
        if ($request->user_password) {
            $user->user_password = bcrypt($request->user_password); // Hash the password
        }

        $user->save(); // Save the updated user details

        // Update the user events
        // First, delete existing events for the user
        UserEvent::where('user_id', $user->user_id)->delete();

        // Then, store the new events
        foreach ($request->event_ids as $eventId) {
            UserEvent::create([
                'user_id' => $user->user_id,
                'event_id' => $eventId,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Data berhasil disimpan');
    }


    public function destroy(User $user)
    {
        UserEvent::where('user_id', $user->user_id)->delete();
        $user->delete();

        return response()->json(['status' => 'OK']);
    }
}
