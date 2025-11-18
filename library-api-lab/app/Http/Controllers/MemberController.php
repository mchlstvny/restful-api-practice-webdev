<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * GET /api/members
     */
    public function index()
    {
        return response()->json(Member::all());
    }

    /**
     * POST /api/members
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:members|max:50',
            'name'       => 'required|max:255',
            'email'      => 'required|email|unique:members',
        ]);

        $member = Member::create($validated);

        return response()->json([
            'message' => 'Member added successfully',
            'data' => $member
        ], 201);
    }

    /**
     * GET /api/members/{id}
     */
    public function show(Member $member)
    {
        return response()->json($member);
    }

    /**
     * PATCH /api/members/{id}
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'student_id' => [
                'sometimes',
                'max:50',
                Rule::unique('members')->ignore($member->id)
            ],
            'name'  => 'sometimes|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('members')->ignore($member->id)
            ],
        ]);

        $member->update($validated);

        return response()->json([
            'message' => 'Member updated successfully',
            'data' => $member
        ]);
    }

    /**
     * DELETE /api/members/{id}
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json(null, 204);
    }
}
