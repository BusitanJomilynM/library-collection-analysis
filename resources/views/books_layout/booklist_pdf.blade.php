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
                        <label class="required">Course Subject</label>
                        <input list="subjectList" name="subject_1" class="form-control" required>
                            <datalist id="subjectList">
                                <option value="" selected disabled>Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id . $subject->subject_name}}">{{$subject->subject_name}}</option>
                                @endforeach
                            </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Book Subject</label>

                        <input list="keywordsList" name="keyword_1" id="keyword" class="form-control"  multiple>

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
                <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                @endforeach
            </datalist>
        </div>`;
    newFieldSet.appendChild(subjectField);

    // Keyword Field Container
    var keywordFieldContainer = document.createElement('div');
        keywordFieldContainer.className = 'col-md-5 d-flex align-items-center';

        // Keyword Field
        var keywordField = document.createElement('div');
        keywordField.className = 'form-group flex-grow-1';
        keywordField.innerHTML = `
            <label for="keyword_${setCount}">Keyword</label>
            <input list="keywordsList" type="text" class="form-control" name="keyword_${setCount}" id="keyword_${setCount}" placeholder="Enter Keywords">`;
        keywordFieldContainer.appendChild(keywordField);


    // Delete button
    var deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-danger ml-2';
    deleteButton.type = 'button';
    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
    deleteButton.onclick = function() {
        removeFields(this);
    };
    keywordFieldContainer.appendChild(deleteButton);

    newFieldSet.appendChild(keywordFieldContainer);

    // Increment the count
    setCount++;

    container.appendChild(newFieldSet);

    // Add event listener for keyword search
    keywordFieldContainer.querySelector('.keyword-search').addEventListener('input', function() {
        const searchText = this.value.toLowerCase().trim(); // Convert to lowercase and remove leading/trailing spaces
        const keywordItems = keywordFieldContainer.querySelectorAll('.dropdown-item');
        keywordItems.forEach(function(item) {
            const label = item.querySelector('label').textContent.toLowerCase();
            if (label.includes(searchText)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// Function to remove fields
function removeFields(button) {
    var container = button.closest('.row');
    container.remove();
}

function removeFields(button) {
    var container = button.closest('.row');
    container.remove();
}

</script>
<script>

var placeholder = "Select Keyword";
$(".mySelect").select2({
  
    placeholder: placeholder,
    allowClear: false,
    minimumResultsForSearch: 5
});


$(".js-responsive").select2({
  
});

$(".js-responsive2").select2({
  
});

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
