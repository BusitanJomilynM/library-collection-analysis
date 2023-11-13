@extends('master_layout.master')
@section('Title', 'Create User')
@section('content')

<form action="{{ route('users.store') }}" method="POST">
    @csrf
<div class="three-col">
    <div class="col1">
        <label>First Name</label>
        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name"  minlength="2" maxlength="30" required>
        @error('first_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Middle Name</label>
            <input class="form-control" type="text" name="middle_name" id="middle_name" minlength="2" maxlength="30">
    </div>

    <div class="col3">
        <label>Last Name</label>
        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" minlength="2" maxlength="30" required>
        @error('last_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<br>
    <div class="form-group">
        <label>ID Number</label>
        <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" type="text" pattern="\d*" minlength="8" maxlength="8" required>
        @error('school_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" required>
        @error('email')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Contact Number</label>
        <input class="form-control @error('email') is-invalid @enderror" type="text" name="contact_number" id="contact_number"  pattern="\d*" minlength="11" maxlength="11" placeholder="09XX-XXX-XXXX" required>
        @error('contact_number')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
    <div class="form-group">
        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" minlength="8" maxlength="25" hidden>
        @error('password')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Role</label>
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
            <option value="">--Select Role--</option>
            <option value="0">Technician Librarian</option>
            <option value="1">Staff Librarian</option>
            <option value="2">Department Representative</option>
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <button type="submit" class="btn btn-danger">Submit</button>
<a class="btn btn-primary" href="{{ route('users.index') }}">Cancel</a>

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
}</style>
@endsection