@extends('master_layout.master')
@section('Title', 'Courses')
@section('content')
<h2 style="text-align: center;">Courses</h2>

<div class="panel panel-default">
@if (session('success'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {{ session('success') }}
</div>
@endif
</div>

<div>
<form style="margin:auto;max-width:300px">
    <input type="text" class="form-control mr-sm-2" placeholder="Search Courses" name="search"  value="{{ request('search') }}">
    <button type="submit" class="btn btn-danger">
    <i class="fa fa-search"></i>
    </button>
</form>
</div>

<a data-toggle="modal" class="btn btn-primary" data-target="#createCourseModal"><span>&#43;</span></i>Add New Course</a>
<br>
<br>

<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark" >
  <tr align="center">
  <th>Course Code</th>
  <th>Course Name</th>
  <th>Department</th>
  <th>Actions</th>
  </tr>
</thead>
@foreach($courses as $course)
<tbody>
    <tr align="center">
    <td>{{$course->course_code}}</td>
    <td>{{$course->course_name}}</td>
    <td>{{$course->course_department}}</td>
    <td>
    <div class="flex-parent jc-center">

        <a data-toggle="modal" class="btn btn-primary" data-target="#editCourseModal_{{$course->id}}"
        data-action="{{ route('courses.edit', $course->id) }}"><span>&#9776;</span>Edit</a>

        <a data-toggle="modal" class="btn btn-danger" data-target="#deleteCourseModal_{{$course->id}}"
        data-action="{{ route('courses.destroy', $course->id) }}"><i class="fa fa-trash"></i></a>
    </div> 
    </td>
  </tr>
</tbody>


  <!-- Delete Modal -->
  <div class="modal fade" id="deleteCourseModal_{{$course->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteCoursModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteCourseModalLabel">Are you sure you want to delete this course?</h5>
            
          </div>
          <form action="{{ route('courses.destroy', $course->id) }}" method="GET">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete {{$course->course_name}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
</div>

<!-- Edit Keyword Modal -->
<div class="modal fade" id="editCourseModal_{{$course->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editCourseModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKeywordModalLabel">Edit Course Details</h5>
      </div>
      <form action="{{ route('courses.update', $course->id) }}" method="PUT">
          <div class="modal-body">
          {{ csrf_field() }}

          <div class="form-group">
        <label class="required">Course Name</label>
        <input class="form-control @error('course_name') is-invalid @enderror" type="text" name="course_name" id="course_name" value="{{$course->course_name}}"required>
        @error('course_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
        <label class="required">Course Code</label>
        <input class="form-control @error('course_code') is-invalid @enderror" type="text" name="course_code" id="course_code" value="{{$course->course_code}}" required>
        @error('course_code')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
        <label class="required">Department</label>
            <select class="form-control" name="course_department" id="course_department" value="{{$course->course_department}}" required> 
            <option value="SBAA" {{ old('course_department') == "SBAA" || $course->course_department == "SBAA" ? 'selected' : '' }}>SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD" {{ old('course_department') == "SOD" || $course->course_department == "SOD" ? 'selected' : '' }}>SOD - School of Dentistry</option>
            <option value="SIT" {{ old('course_department') == "SIT" || $course->course_department == "SIT" ? 'selected' : '' }}>SIT - School of Information Technology</option>
            <option value="SIHTM" {{ old('course_department') == "SIHTM" || $course->course_department == "SIHTM" ? 'selected' : '' }}>SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA" {{ old('course_department') == "SEA" || $course->course_department == "SEA" ? 'selected' : '' }}>SEA - School of Engineering & Architecture</option>
            <option value="SCJPS" {{ old('course_department') == "SCJPS" || $course->course_department == "SCJPS" ? 'selected' : '' }}>SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL" {{ old('course_department') == "SOL" || $course->course_department == "SOL" ? 'selected' : '' }}>SOL - School of Law</option>
            <option value="SNS" {{ old('course_department') == "SNS" || $course->course_department == "SNS" ? 'selected' : '' }}>SNS - School of Natural Sciences</option>
            <option value="SON" {{ old('course_department') == "SON" || $course->course_department == "SON" ? 'selected' : '' }}>SON - School of Nursing</option>
            <option value="STELA" {{ old('course_department') == "STELA" || $course->course_department == "STELA" ? 'selected' : '' }}>STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School" {{ old('course_department') == "Graduate School" || $course->course_department == "Graduate School" ? 'selected' : '' }}>Graduate School</option>
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

<!-- Create Course Modal -->
<div class="modal fade" id="createCourseModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createCourseModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Add New Course</h5>
      </div>
        <form action="{{ route('courses.store') }}" method="POST">
          <div class="modal-body">
          {{ csrf_field() }}

        <div class="form-group">
        <label class="required">Course Name</label>
        <input class="form-control  @error('course_name') is-invalid @enderror" type="text" name="course_name" id="course_name" required>
        @error('course_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
        <label class="required">Course Code</label>
        <input class="form-control  @error('course_code') is-invalid @enderror" type="text" name="course_code" id="course_code" required>
        @error('course_code')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
        <label class="required">Department</label>
            <select class="form-control" name="course_department" id="course_department" required>
            <option value="">--Select Department--</option>
            <option value="SBAA">SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD">SOD - School of Dentistry</option>
            <option value="SIT">SIT - School of Information Technology</option>
            <option value="SIHTM">SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA">SEA - School of Engineering & Architecture</option>
            <option value="SCJPS">SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL">SOL - School of Law</option>
            <option value="SNS">SNS - School of Natural Sciences</option>
            <option value="SON">SON - School of Nursing</option>
            <option value="STELA">STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School">Graduate School</option>
            
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




<style>
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}

</style>


@endsection