@extends('master_layout.master')
@section('Title', 'Subjects')
@section('content')
<h2 style="text-align: center;">Subjects</h2>

<div style="display:flex; justify-content:center;">
    <form style="max-width:300px; display:flex;">
        <input type="text" class="form-control mr-sm-2" placeholder="Search Courses" name="search" value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="btn btn-danger" style="margin-left: 5px;">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<a data-toggle="modal" class="btn btn-primary" data-target="#createSubjectModal"><span>&#43;</span></i>Add New Subject</a>
<br>
<br>

<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark" >
  <tr align="center">
 
  <th>Subject Code</th>
  <th>Subject Name</th>
  <th>Course</th>
  <th>Actions</th>
  </tr>
</thead>
@foreach($subjects as $subject)
<tbody>
    <tr align="center">
    <td>{{$subject->subject_code}}</td>
    <td>{{$subject->subject_name}}</td>
    <td><?php  
                        $x = $subject->subject_course;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($courses as $course) {
                          foreach ($words as $key => $word) {
                              if ($word == $course->id) {
                                  echo $course->course_code;
                                  if ($key < $count - 1) {
                                    echo ",";
                                  } 
                              }
                          }
                      }
                   
                        ?></td>
    <td>
      <div class="flex-parent jc-center">

              <a data-toggle="modal" class="btn btn-primary" data-target="#editSubjectModal_{{$subject->id}}"
              data-action="{{ route('subjects.edit', $subject->id) }}"><span>&#9776;</span>Edit</a>

              <a data-toggle="modal" class="btn btn-danger" data-target="#deleteSubjectModal_{{$subject->id}}"
              data-action="{{ route('subjects.destroy', $subject->id) }}"><i class="fa fa-trash"></i></a>
      </div> 

    </div> 
    </td>
  </tr>
</tbody>


  <!-- Delete Modal -->
  <div class="modal fade" id="deleteSubjectModal_{{$subject->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteKeywordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteKeywordModalLabel">Are you sure you want to delete this keyword?</h5>
            
          </div>
          <form action="{{ route('subjects.destroy', $subject->id) }}" method="GET">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete subject {{$subject->subject_name}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
</div>


<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal_{{$subject->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editsubjectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKeywordModalLabel">Edit Subject Details</h5>
      </div>
      <form action="{{ route('subjects.update', $subject->id) }}" method="PUT">
          <div class="modal-body">
          {{ csrf_field() }}

        
          <div class="form-group">
        <label>Subject Description</label>
        <input class="form-control" type="text" name="subject_name" id="subject_name" value="{{$subject->subject_name}}" required>
        </div>

        <div class="form-group">
        <label>Subject Code</label>
        <input class="form-control" type="text" name="subject_code" id="subject_code" value="{{$subject->subject_code}}" required>
        </div>

        <div class="form-group">
        <label>Course</label>
          <select class="js-example-responsive" name="subject_course[]" id="subject_course_{{$subject->id}}" multiple="multiple" style="width: 100%">
          @foreach($courses as $course)
            <?php
                   $selected = in_array($course->id, json_decode($subject->subject_course, true));
               ?>
               <option value="{{ $course->id }}" {{ $selected ? 'selected' : '' }}>
                   {{ $course->course_name }}
                </option>
            @endforeach
        </select>
        </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>
@endforeach


<!-- Create Subject Modal -->
<div class="modal fade" id="createSubjectModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createSubjectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Add New Subject</h5>
      </div>
        <form action="{{ route('subjects.store') }}" method="POST">
          <div class="modal-body">
          {{ csrf_field() }}

        <div class="form-group">
        <label>Subject Description</label>
        <input class="form-control" type="text" name="subject_name" id="subject_name" required>
        </div>

        <div class="form-group">
        <label>Subject Code</label>
        <input class="form-control" type="text" name="subject_code" id="subject_code" required>
        </div>

        <div class="form-group">
        <label>Course</label>
          <select class="mySelect" name="subject_course[]" id="subject_course" multiple="multiple" style="width: 100%" required>
            @foreach($courses as $course)
            <option value="{{$course->id}}">{{$course->course_name}}</option>
            @endforeach
          </select>
        </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script>

var placeholder = "Select Keyword";
$(".mySelect").select2({
  
    placeholder: placeholder,
    allowClear: false,
    minimumResultsForSearch: 5
});

$(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});

</script>

@endsection

