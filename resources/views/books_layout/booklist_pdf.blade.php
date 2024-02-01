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
<!-- <form method="GET" action="{{ route('booklist_pdf') }}"> -->
    <form method="GET" action="{{ route('process_form')}}">
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

 <!-- Add button to dynamically add subject and keyword fields -->
 <!-- <div class="form-group text-center">
                <button type="button" class="btn btn-success" onclick="addFields()">Add</button>
            </div>

            <div id="dynamicFieldsContainer"></div>


        </form>
    </div>
</div>

<script>
    function addFields() {
        var container = document.getElementById("dynamicFieldsContainer");

        var newRow = document.createElement("div");
        newRow.className = "row";

        var newSubjectCol = document.createElement("div");
        newSubjectCol.className = "col-md-6";
        var newSubjectGroup = document.createElement("div");
        newSubjectGroup.className = "form-group";
        var newSubjectInput = document.createElement("input");
        newSubjectInput.type = "text";
        newSubjectInput.name = "dynamic_subject[]"; // Use an array for dynamic subjects
        newSubjectInput.placeholder = "Enter subject";
        newSubjectInput.className = "form-control";
        newSubjectGroup.appendChild(newSubjectInput);
        newSubjectCol.appendChild(newSubjectGroup);
        newRow.appendChild(newSubjectCol);

        var newKeywordCol = document.createElement("div");
        newKeywordCol.className = "col-md-6";
        var newKeywordGroup = document.createElement("div");
        newKeywordGroup.className = "form-group";
        var newKeywordInput = document.createElement("input");
        newKeywordInput.type = "text";
        newKeywordInput.name = "dynamic_keyword[]"; // Use an array for dynamic keywords
        newKeywordInput.placeholder = "Enter keyword";
        newKeywordInput.className = "form-control";
        newKeywordGroup.appendChild(newKeywordInput);
        newKeywordCol.appendChild(newKeywordGroup);
        newRow.appendChild(newKeywordCol);

        container.appendChild(newRow);
    }
</script>

 -->



                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" name="action" value="booklist_pdf">Generate Booklist PDF</button>
                    <button type="submit" class="btn btn-primary" name="action" value="collection_analysis">Generate Collection Analysis</button>
                </div>                    
            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
