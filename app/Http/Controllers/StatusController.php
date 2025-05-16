<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    // Handle status update
    public function updateStatus(Request $request)
    {
        $studentId = $request->input('studentId');
        $status = $request->input('status');

        // Store status in the session (for the current session)
        session()->put("status_{$studentId}", $status);

        // Return success response
        return response()->json(['success' => true]);
    }
}
