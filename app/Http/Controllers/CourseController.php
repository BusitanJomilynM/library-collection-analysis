<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB; 
use App\Models\Course;

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
        return view('courses_layout.courses_list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Course::create($request->all());
        return redirect()->route('courses.index');
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
    public function edit($id)
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
    public function update(Request $request, Course $course)
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
