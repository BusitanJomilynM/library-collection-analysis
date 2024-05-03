<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB; 
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;


class CourseController extends Controller
{

    public function __construct() 
    { 
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth'); 
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('search')) {
            $courses = Course::where('course_code', 'like', '%' . request('search') . '%')
            ->orwhere('course_name', 'like', '%' . request('search') . '%')
            ->orwhere('course_department', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }

        else{
        $courses = Course::paginate(10);
    }

        return view('courses_layout.courses_list', ['courses'=>$courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $courses = Course::all();
    
        return view('courses_layout.courses_list', ['user'=>$user, 'courses'=>$courses]); // Assuming you have a view for creating a new keyword
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        // Retrieve course code and course name from the request
        $courseCode = $request->input('course_code');
        $courseName = $request->input('course_name');
    
        // Check if a record with the same course code and course name exists
        $existingCourse = Course::where('course_code', $courseCode)
                                 ->where('course_name', $courseName)
                                 ->first();
    
        if ($existingCourse) {
            // If a matching record exists, redirect back with an error message
            return redirect()->route('courses.index')->with('error', 'Course already exists with the same course code and name.');
        }
    
        // If no matching record exists, create a new record
        Course::create($request->all());
    
        // Redirect with success message
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('courses_layout.courses_list', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all()); 

            return redirect()->route('courses.index')->with('success','Course successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted!');
    }
}
