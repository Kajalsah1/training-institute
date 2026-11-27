<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    private function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'duration'    => 'required|integer|min:1|max:104',
            'fee'         => 'required|numeric|min:0|max:999999.99',
            'difficulty'  => 'required|in:Easy,Medium,Hard',
            'is_active'   => 'sometimes|boolean',
        ];
    }

    public function index(Request $request)
    {
        // Admin sees every course, a normal user sees only their own
        $courses = $request->user()->role === 'admin'
            ? Course::latest()->paginate(10)
            : $request->user()->courses()->latest()->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['is_active'] = $request->boolean('is_active');

        // Owner comes from the logged-in user, never from the browser
        $request->user()->courses()->create($data);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        Gate::authorize('manage-course', $course);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        Gate::authorize('manage-course', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        Gate::authorize('manage-course', $course);

        $data = $request->validate($this->rules());
        $data['is_active'] = $request->boolean('is_active');
        $course->update($data);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        Gate::authorize('manage-course', $course);
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
