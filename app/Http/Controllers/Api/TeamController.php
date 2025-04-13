<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    //
    public function index()
    {
        try{

            $team = Team::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

            return response()->json([
                'team' => $team,

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
            $team = Team::where('slug', $slug)->where('status', 1)->first();

            return response()->json([
                'team' => $team,

            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}

