@extends('master_layout.master')
@section('scripts')
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
        <form method="GET">
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

            <!-- Initial Subject and Keyword Fields -->
            <div id="initialFields" class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">Subject</label>
                        <input list="subjectList" name="subject_1" class="form-control" required>
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
                        <input list="keywordList" name="keyword_1" class="form-control" multiple>
                        <datalist id="keywordList">
                            <option value="" selected disabled>Select Keyword</option>
                            @foreach($keywords as $keyword)
                                <option value="{{$keyword->keyword}}">
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>

            <!-- Dynamic Fields Container -->
            <div id="dynamicFieldsContainer"></div>

            <!-- Add and Submit Buttons -->
            <div class="form-group text-center">
                <button type="button" class="btn btn-success" onclick="addFields()">Add New Set</button>
                <button type="submit" class="btn btn-primary"  formaction="{{ route('booklist_pdf') }}">Generate Booklist</button>
                <button type="submit" class="btn btn-primary"  formaction="{{ route('booklis_pdf') }}"> Generate Collection Analysis</button>                
                
            </div>
        </form>
    </div>
</div>

<script>
    var setCount = 2; // Start count from 2 for the additional set

    function addFields() {
        var container = document.getElementById('dynamicFieldsContainer');
        var newFieldSet = document.createElement('div');
        newFieldSet.className = 'row';

        // Subject Field
        var subjectField = document.createElement('div');
        subjectField.className = 'col-md-6';
        subjectField.innerHTML = `
            <div class="form-group">
                <label class="required">Subject</label>
                <input list="subjectList" name="subject_${setCount}" class="form-control" required>
                <datalist id="subjectList">
                    <option value="" selected disabled>Select Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{$subject->subject_name}}">
                    @endforeach
                </datalist>
            </div>`;
        newFieldSet.appendChild(subjectField);

        // Keyword Field

        var keywordField = document.createElement('div');
keywordField.className = 'col-md-6';
keywordField.innerHTML = `<div class="form-group">
    <label>Keyword</label>
    <div class="input-group">
    <input list="keywordList" name="keyword_${setCount}" class="form-control" multiple>
    <datalist id="keywordList">
    <option value="" selected disabled>Select Keyword</option>
    @foreach($keywords as $keyword)
    <option value="{{$keyword->keyword}}">
    @endforeach
    </datalist>
    <div class="input-group-append">
    <button class="btn btn-danger" type="button" onclick="removeFields(this)">
    <i class="fas fa-trash"></i>
    </button>
    </div> 
    </div> 
    </div>`; 
newFieldSet.appendChild(keywordField);


        // Increment the count
        setCount++;

        container.appendChild(newFieldSet);
    }

    function removeFields(button) {
        var container = button.closest('.row');
        container.remove();
    }
</script>
<!-- <div class="form-group text-center">
                    <button type="button" class="btn btn-success" onclick="addFields()">Add</button>
                <button type="submit" class="btn btn-primary">Generate Booklist</button>                
</div>                     -->
            </div>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection 
