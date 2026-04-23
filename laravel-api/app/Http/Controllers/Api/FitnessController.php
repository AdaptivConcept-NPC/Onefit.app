<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Exercise;
use App\Models\TrainingProgram;
use App\Models\FitnessBmi;
use App\Models\FitnessHeartRate;
use App\Models\FitnessStepCount;
use App\Models\GeneralUserProfile;
use Carbon\Carbon;

class FitnessController extends Controller
{
    /**
     * Get all exercises.
     */
    public function getExercises()
    {
        return response()->json(Exercise::all());
    }

    /**
     * Get all training programs.
     */
    public function getPrograms()
    {
        return response()->json(TrainingProgram::where('active', true)->get());
    }

    /**
     * Log a fitness metric.
     */
    public function logMetric(Request $request)
    {
        $user = $request->user();
        $profile = GeneralUserProfile::where('users_username', $user->username)->firstOrFail();

        $request->validate([
            'type' => 'required|in:bmi,heart_rate,steps,speed,body_temp',
            'value' => 'required|numeric',
            'exercise_id' => 'nullable|exists:exercises,exercise_id',
            'workout_activity' => 'nullable|string',
            'datasource' => 'nullable|string',
        ]);

        $commonData = [
            'workout_activity' => $request->workout_activity,
            'datasource' => $request->datasource ?? 'OneFit App',
            'date' => Carbon::now()->toDateString(),
            'time' => Carbon::now()->toTimeString(),
            'user_profiles_user_profile_id' => $profile->user_profile_id,
            'exercises_exercise_id' => $request->exercise_id,
        ];

        switch ($request->type) {
            case 'bmi':
                $request->validate(['weight' => 'required|numeric']);
                $metric = FitnessBmi::create(array_merge($commonData, [
                    'bmi' => $request->value,
                    'weight' => $request->weight,
                    'bmi_status' => $this->calculateBmiStatus($request->value),
                ]));
                break;
            case 'heart_rate':
                $metric = FitnessHeartRate::create(array_merge($commonData, [
                    'bpm' => $request->value,
                ]));
                break;
            case 'steps':
                $metric = FitnessStepCount::create(array_merge($commonData, [
                    'steps' => $request->value,
                ]));
                break;
            // Add other types as needed
        }

        return response()->json([
            'message' => 'Metric logged successfully',
            'data' => $metric ?? null
        ]);
    }

    private function calculateBmiStatus($bmi)
    {
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Healthy';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }
}
