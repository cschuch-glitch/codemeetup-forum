<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        // List the users...
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);

        return view('profiles.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', [User::class, $user]);

        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', [User::class, $user]);

        if ($request->password) {
            $request->merge([
                'password' => bcrypt($request->password),
            ]);
        }

        $request['reply_email_notification'] = (int) $request->has('reply_email_notification');

        $user->update($request->all());

        if ($request->avatar) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save();
        }

        return redirect()->route('home')->withStatus('Profile successfully updated.');
    }

    public function reset_avatar()
    {
        $user = auth()->user();

        $this->authorize('update', [User::class, $user]);

        $user->update([
            'avatar' => null,
        ]);

        return redirect()->route('home')->withStatus('Avatar successfully set to default picture.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', [User::class, $user]);

        // Delete the user...
    }
}
