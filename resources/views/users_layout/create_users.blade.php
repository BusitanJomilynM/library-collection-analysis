@extends('master_layout.master')
@section('Title', 'Create User')
@section('content')

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>First Name</label>
        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name"  minlength="2" maxlength="30">
        @error('first_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Middle Name</label>
            <input class="form-control" type="text" name="middle_name" id="middle_name" minlength="2" maxlength="30">
    </div>

    <div class="form-group">
        <label>Last Name</label>
        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" minlength="2" maxlength="30">
        @error('last_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ID Number</label>
        <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" type="text" pattern="\d*" minlength="8" maxlength="8">
        @error('school_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email">
        @error('email')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Contact Number</label>
        <input class="form-control @error('email') is-invalid @enderror" type="text" name="contact_number" id="contact_number"  pattern="\d*" minlength="12" maxlength="12">
        @error('contact_number')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" minlength="8" maxlength="25" hidden>
        @error('password')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Role</label>
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
            <option value="">--Select Role--</option>
            <option value="0">Technician Librarian</option>
            <option value="1">Staff Librarian</option>
            <option value="2">Department Representative</option>
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

<button type="submit" class="btn btn-primary">Submit</button>
<a class="nav-link" href="{{ route('users.index') }}">Cancel</a>

</form>

@endsection