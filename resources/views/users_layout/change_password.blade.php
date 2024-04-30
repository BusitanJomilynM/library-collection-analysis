@extends('master_layout.master')
@section('Title', 'Change Password')
@section('content')

<form action="{{ route('updatePassword', $user->id) }}" method="POST">
    @csrf
    @method('GET')
    <div class="form-group">

            <input class="form-control" type="text" name="id" id="id" value="{{$user->id}}" hidden>
    </div>
    <div class="form-group">
     
        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name" value="{{$user->first_name}}" minlength="2" maxlength="30" hidden> 
        @error('first_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
     
            <input class="form-control" type="text" name="middle_name" id="middle_name" value="{{$user->middle_name}}" minlength="2" maxlength="30" hidden>
        </div>

    <div class="form-group">
     
        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" value="{{$user->last_name}}" minlength="2" maxlength="30" hidden>
        @error('last_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
       
        <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" value="{{$user->school_id}}" type="text" pattern="\d*" minlength="8" maxlength="8" hidden>
        @error('school_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{$user->email}}" hidden>
        @error('email')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
      
        <input class="form-control @error('contact_number') is-invalid @enderror" type="text" name="contact_number" id="contact_number" value="{{$user->contact_number}}" pattern="\d*" minlength="12" maxlength="12" hidden>
        @error('contact_number')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
            <select class="form-control" name="type" id="type" value="{{$user->type}}" hidden>
                <option value="0" {{ old('type') == "technician librarian" || $user->type == "technician librarian" ? 'selected' : '' }}>Technical Librarian</option>
                <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Staff Librarian</option>
                <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Department Representative</option>
            </select>
    </div>

    <div class="form-group">
    <label>New Password</label>
        <input class="form-control" type="password" name="password" id="password" required>
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



@endsection