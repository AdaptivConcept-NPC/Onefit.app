<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GeneralUserProfile;
use App\Models\UserProfileAbout;
use App\Models\UserSocial;

class ProfileController extends Controller
{
    /**
     * Get the current user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        
        $profile = GeneralUserProfile::with('aboutInfo')
            ->where('users_username', $user->username)
            ->first();

        if (!$profile) {
            // Create a default profile if not found
            $profile = GeneralUserProfile::create([
                'users_username' => $user->username,
                'verification' => 'unverified',
            ]);
            $profile->load('aboutInfo');
        }

        return response()->json($profile);
    }

    /**
     * Update the current user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        $profile = GeneralUserProfile::where('users_username', $user->username)->firstOrFail();
        
        $validatedData = $request->validate([
            'about' => 'nullable|string|max:45',
            'profile_type' => 'nullable|string|max:45',
            'profile_url' => 'nullable|string|max:100',
            'profile_banner_url' => 'nullable|string',
            'profile_image_url' => 'nullable|string',
            // About Info fields
            'height' => 'nullable|numeric',
            'target_weight' => 'nullable|numeric',
            'fitness_goals' => 'nullable|string',
            'preferred_workout_time' => 'nullable|string|max:20',
        ]);

        $profile->update($request->only([
            'about', 'profile_type', 'profile_url', 'profile_banner_url', 'profile_image_url'
        ]));

        // Update or Create About Info
        $aboutInfo = UserProfileAbout::updateOrCreate(
            ['general_user_profiles_user_profile_id' => $profile->user_profile_id],
            $request->only(['height', 'target_weight', 'fitness_goals', 'preferred_workout_time'])
        );

        return response()->json($profile->load('aboutInfo'));
    }

    /**
     * Get user social links.
     */
    public function getSocials(Request $request)
    {
        $socials = UserSocial::where('username', $request->user()->username)->get();
        return response()->json($socials);
    }

    /**
     * Update user social links.
     */
    public function updateSocials(Request $request)
    {
        $request->validate([
            'socials' => 'required|array',
            'socials.*.social_network' => 'required|string',
            'socials.*.handle' => 'required|string',
            'socials.*.link' => 'required|string',
        ]);

        $username = $request->user()->username;
        
        // Simple approach: delete and recreate for now
        UserSocial::where('username', $username)->delete();

        foreach ($request->socials as $social) {
            UserSocial::create([
                'username' => $username,
                'social_network' => $social['social_network'],
                'handle' => $social['handle'],
                'link' => $social['link'],
            ]);
        }

        return response()->json(['message' => 'Socials updated successfully']);
    }
}
