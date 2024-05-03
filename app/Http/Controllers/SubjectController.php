<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB; 
use App\Models\Subject;
use App\Models\Course;

class SubjectController extends Controller
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
        if(request('search')) {
            $courses = Course::paginate(10);
            $subjects = Subject::paginate(10);
            $subjects = Subject::where('subject_name', 'like', '%' . request('search') . '%')
            ->orwhere('subject_code', 'like', '%' . request('search') . '%')
            ->orwhere('subject_course', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
        } 
    
        else{
            $courses = Course::paginate(10);
            $subjects = Subject::paginate(10);
        }
        


        return view('subjects_layout.subjects_list', ['subjects'=>$subjects, 'courses'=>$courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $subjects = Subject::all();
    
        return view('subjects_layout.subjects_list', ['user'=>$user, 'subjects'=>$subjects]); // Assuming you have a view for creating a new keyword
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        // Retrieve subject name and subject course from the request
        $subjectName = $request->input('subject_name');
        $subjectCourse = json_encode($request->input('subject_course'));
    
        // Check if a record with the same subject name and subject course exists
        $existingSubject = Subject::where('subject_name', $subjectName)
                                   ->where('subject_course', $subjectCourse)
                                   ->first();
    
        if ($existingSubject) {
            // If a matching record exists, redirect back with an error message
            return redirect()->route('subjects.index')->with('error', 'Subject already exists with the same name and course.');
        }
    
        // If no matching record exists, proceed to create the new subject
        $data = $request->all();
        $data['subject_course'] = $subjectCourse;
        Subject::create($data);
    
        // Redirect with success message
        return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
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
    public function edit(Subject $subject)
    {
        return view('subjects_layout.subjects_list', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->all()); 

        return redirect()->route('subjects.index')->with('success','Subject successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject )
    {
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted!');
    }
}
