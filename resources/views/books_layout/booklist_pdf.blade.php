@extends('master_layout.master')

@section('Title', 'Generate Booklist')
@section('content')
<div class="panel panel-default">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('success') }}
        </div>
    @endif
</div>



<div class="row justify-content-center">
            <div class="col-md-6 bg-white p-4">
<!-- booklist_pdf.blade.php -->
<form method="GET" action="{{ route('booklist_pdf') }}">
    @csrf
    <div class="form-group">
        <label class="required">Course</label>
        <input list="courseList" name="course" id="course" class="form-control" required>
        <datalist id="courseList">
            <option value="" selected disabled>Select Course</option>
            @foreach($courses as $course)
                <option value="{{$course->course_name}}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group">
    <label for="callNumberPrefix">Classifications</label>
    <input list="callNumberPrefixList" name="callNumberPrefix" id="callNumberPrefix" class="form-control" style="font-size: 16px;">
    <datalist id="callNumberPrefixList">
        <option value="">-- Subject Header--</option>
        <option value="COM">COM</option>
        <option value="EDUC">EDUC</option>
        <option value="ENG">ENG</option>
        <option value="LAHS">LAHS</option>
        <option value="GRAD">GRAD</option>
        <option value="THES">THES</option>
        <option value="CD">CD</option>
        <option value="FIC">FIC</option>
        <option value="LAW">LAW</option>
        <option value="REL">REL</option>
        <option value="AMS">AMS</option>
        <option value="ARCH">ARCH</option>
        <option value="FIL">FIL</option>
        <option value="CRIM">CRIM</option>
        <option value="ITHM">IHTM</option>
        <option value="THES">THES</option>
        <option value="PER">PER</option>
        <option value="SEF">SEF</option>
        <option value="SR">SR</option>
    </datalist>
</div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">Subject</label>
                        <input list="subjectList" name="subject" id="subject" class="form-control" required>
                        <datalist id="subjectList">
                            <option value="" selected disabled>Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{$subject->subject_name}}">
                            @endforeach
                        </datalist>
                </div>
            </div>
            <div class="col-md-6">
                    <div class="form-group">
                        <label>Keyword</label>
                        <input list="keywordList" name="keyword" id="keyword" class="form-control"  multiple>
                        <datalist id="keywordList">
                            <option value="" selected disabled>Select Keyword</option>
                            @foreach($keywords as $keyword)
                                <option value="{{$keyword->keyword}}">
                            @endforeach
                        </datalist>
                    </div>
    </div>
</div>



    <!-- <div class="form-group">
    <label>Fields to Include:</label>
    <div class="form-check">
        <input type="checkbox" id="booktitle" name="booktitle" class="form-check-input">
        <label for="booktitle" class="form-check-label" style="font-size: 14px;"> Book Title</label>
    </div>

    <div class="form-check">
        <input type="checkbox" id="bookcallnumber" name="bookcallnumber" class="form-check-input">
        <label for="bookcallnumber" class="form-check-label" style="font-size: 14px;"> Book Callnumber</label>
    </div>

    <div class="form-check">
        <input type="checkbox" id="bookauthor" name="bookauthor" class="form-check-input">
        <label for="bookauthor" class="form-check-label" style="font-size: 14px;"> Author</label>
    </div>

    Add similar form-check elements for other checkboxes 

    <div class="form-check">
        <input type="checkbox" id="copy" name="copy" class="form-check-input">
        <label for="copy" class="form-check-label" style="font-size: 14px;"> Number of Copies</label>
    </div>

    <div class="form-check">
        <input type="checkbox" id="volume" name="volume" class="form-check-input">
        <label for="volume" class="form-check-label" style="font-size: 14px;"> Volume</label>
    </div>
</div>  
 -->
    <!-- <p>Filters:</p>
    <label for="includeYearRange">
        <input type="checkbox" id="includeYearRange" name="includeYearRange"> Include Year Range
    </label>
    <label for="startYear">Start Year:</label>
    <input type="text" id="startYear" name="startYear" placeholder="Enter start year">

    <label for="endYear">End Year:</label>
    <input type="text" id="endYear" name="endYear" placeholder="Enter end year">
    <br>
    <label for="subject">
        <input type="checkbox" id="subject" name="subject"> Subject
    </label>
    <input type="text" id="subjectText" name="subjectText" placeholder="Enter subject">
    <br> -->


    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Generate Booklist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
