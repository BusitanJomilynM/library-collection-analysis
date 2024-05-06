@extends('master_layout.master')
@section('Title', 'Edit Account')
@section('content')

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
            <input class="form-control" type="text" name="id" id="id" value="{{$user->id}}" hidden>
    </div>

<div class="three-col">
    <div class="col1">
        <label class="required">First Name</label>
        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name" value="{{$user->first_name}}" minlength="2" maxlength="30" readonly> 
        @error('first_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Middle Name</label>
            <input class="form-control" type="text" name="middle_name" id="middle_name" value="{{$user->middle_name}}" minlength="2" maxlength="30" required>
        </div>

    <div class="col3">
        <label class="required">Last Name</label>
        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" value="{{$user->last_name}}" minlength="2" maxlength="30" required>
        @error('last_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<br>
<div class="two-col">
    <div class="col1">
        <label class="required">ID Number</label>
        <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" value="{{$user->school_id}}" type="text" pattern="\d*" minlength="8" maxlength="8" readonly>
        @error('school_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label class="required">Email</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{$user->email}}">
        @error('email')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<br>
    <div class="form-group">
        <label class="required">Contact Number</label>
        <input class="form-control @error('contact_number') is-invalid @enderror" type="text" name="contact_number" id="contact_number" value="{{$user->contact_number}}" pattern="\d*" minlength="11" maxlength="11" placeholder="09XX-XXX-XXXX">
        @error('contact_number')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
            <select class="form-control" name="type" id="type" value="{{$user->type}}" hidden>
                <option value="0" {{ old('type') == "technician librarian" || $user->type == "technician librarian" ? 'selected' : '' }}>Technical Librarian</option>
                <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Section Librarian</option>
                <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Program Chairman</option>
                <option value="3" {{ old('type') == "teacher" || $user->type == "teacher" ? 'selected' : '' }}>Faculty Staff</option>

            </select>
    </div>

    <button type="submit" class="btn btn-danger">Submit</button>
@if($user->type == 'technician librarian')
<a class="btn btn-primary" href="{{ route('technician.home') }}">Cancel</a>

@elseif($user->type  == 'staff librarian')
<a class="btn btn-primary" href="{{ route('staff.home') }}">Cancel</a>

@elseif($user->type  == 'teacher')
<a class="btn btn-primary" href="{{ route('teacher.home') }}">Cancel</a>


@else 
<a class="btn btn-primary" href="{{ route('representative.home') }}">Cancel</a>

@endif


</form>

<style> 
.three-col {
    overflow: hidden;/* Makes this div contain its floats */
}

.three-col .col1,
.three-col .col2,
.three-col .col3 {
    width: 33%;
}

.three-col .col1 {
    float: left;
}
.three-col .col2 {
    display: block;
    display: inline-block;
   
    float: left;
     margin-left: 10px;
}
.three-col .col3 {
    float: right;
}

.three-col label {
    display: block;
}

.two-col {
    overflow: hidden;/* Makes this div contain its floats */
}

.two-col .col1,
.two-col .col2 {
    width: 49%;
}

.two-col .col1 {
    float: left;
}

.two-col .col2 {
    float: right;
}

.two-col label {
    display: block;
}
</style>



@endsection