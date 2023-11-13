@extends('master_layout.master')
@section('Title', 'Create Book Requisition')
@section('content')

<form action="{{ route('requisitions.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Book Name</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{ old('book_title') }}" minlength="1" maxlength="60">
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Number of Copies</label>
        <input class="form-control @error('copies') is-invalid @enderror"  type="number" pattern="\d*" minlength="1" maxlength="60" name="copies" id="copies" value="{{ old('copies') }}">
        @error('copies')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


    <div class="form-group">
        <label for="material_type">Material Type</label>
    <select class="form-control @error('material_type') is-invalid @enderror" name="material_type" id="material_type">
        <option value="">--Select Material Type--</option>
        <option value="Book">Book</option>
        <option value="JournalMagazine">Journal/Magazine</option>
        <option value="DocumentaryFilm">Documentary Film</option>
        <option value="DVDVCD">DVD/VCD</option>
        <option value="MapsGlobes">Maps/Globes</option>
        <option value="Other">Other</option>
    </select>
    <label>Other</label>
    <input class="form-control @if(old('material_type') == 'Other') is-invalid @endif" type="text" name="other_material_type" id="other_material_type" value="{{ old('other_material_type') }}" minlength="2" maxlength="40">
    @error('material_type')
        <span class="text-danger">{{$message}}</span>
    @enderror

    @error('other_material_type')
        <span class="text-danger">{{$message}}</span>
    @enderror
    </div>
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('author') is-invalid @enderror" type="text" name="author" id="author" value="{{ old('author') }}"  minlength="2" maxlength="40">
        @error('author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ISBN</label>
        <input class="form-control @error('material_type') is-invalid @enderror" type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"  minlength="2" maxlength="25">
        @error('isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control @error('publisher') is-invalid @enderror" type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"  minlength="2" maxlength="25">
        @error('publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Edition/Year</label>
        <input class="form-control @error('edition') is-invalid @enderror" type="text" pattern="\d*" minlength="4" maxlength="4" name="edition" id="edition" value="{{ old('edition') }}">
        @error('edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Source</label>
        <input class="form-control @error('source') is-invalid @enderror" type="text" name="source" id="source" value="{{ old('source') }}"  minlength="2" maxlength="25">
        @error('source')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
        <input class="form-control" type="string" value="{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}" readonly>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select class="form-control" name="type" id="type" value="{{$user->type}}" disabled>
                <option value="0" {{ old('type') == "technicna librarian" || $user->type == "technicna librarian" ? 'selected' : '' }}>Technician Librarian</option>
                <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Staff Librarian</option>
                <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Department Representative</option>
            </select>
        <input class="form-control" type="text" name="type" id="type" value="{{$user->type}}" hidden>
    </div>

    <div class="form-group">
        <label>Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department">
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
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

<button type="submit" class="btn btn-danger">Submit</button>
<a class="btn btn-primary" href="{{ route('requisitions.index') }}">Cancel</a>


</form>

@endsection