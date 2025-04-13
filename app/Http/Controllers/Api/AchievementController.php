<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    //
    public function index()
    {
        try{

            $achievements = Achievement::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

            return response()->json([
                'achievements' => $achievements,

            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show($slug)
    {
        try{
            $achievements = Achievement::where('slug', $slug)->where('status', 1)->first();

            return response()->json([
                'achievements' => $achievements,

            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
