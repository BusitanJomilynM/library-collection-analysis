@extends('master_layout.master')
@section('Title', 'Edit Requisition')
@section('content')

<form action="{{ route('requisitions.update', $requisition->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Book Name</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$requisition->book_title}}" minlength="1" maxlength="60">
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Number of Copies</label>
        <input class="form-control @error('copies') is-invalid @enderror" type="text" pattern="\d*" minlength="1" maxlength="3" name="copies" id="copies" value="{{$requisition->copies}}">
        @error('copies')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Material Type</label>
        <input class="form-control @error('material_type') is-invalid @enderror" type="text" name="material_type" id="material_type" value="{{$requisition->material_type}}">
        @error('material_type')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('author') is-invalid @enderror" type="text" name="author" id="author" value="{{$requisition->author}}" minlength="2" maxlength="40">
        @error('author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ISBN</label>
        <input class="form-control @error('material_type') is-invalid @enderror" type="text" name="isbn" id="isbn" value="{{$requisition->isbn}}" minlength="2" maxlength="25">
        @error('isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control @error('publisher')is-invalid @enderror" type="text" name="publisher" id="publisher" value="{{$requisition->publisher}}" minlength="2" maxlength="25">
        @error('publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Edition/Year</label>
        <input class="form-control @error('edition') is-invalid @enderror" type="text" pattern="\d*" minlength="4" maxlength="4" name="edition" id="edition" value="{{$requisition->edition}}">
        @error('edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Source</label>
        <input class="form-control @error('source') is-invalid @enderror" type="text" name="source" id="source" value="{{$requisition->source}}" minlength="2" maxlength="25">
        @error('source')
            <span class="text-danger">{{$message}}</span>
        @enderror</div>

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
        <input class="form-control" type="string" value="{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}" readonly>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select class="form-control" name="type" id="type" value="{{$user->type}}" disabled>
                <option value="0" {{ old('type') == "technicna librarian" || $user->type == "technicna librarian" ? 'selected' : '' }}>Technical Librarian</option>
                <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Staff Librarian</option>
                <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Department Representative</option>
            </select>
        <input class="form-control" type="text" name="type" id="type" value="{{$user->type}}" hidden>
    </div>

    <div class="form-group">
        <label>Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" value="{{$requisition->department}}">
            <option value="SBAA" {{ old('department') == "SBAA" || $requisition->department == "SBAA" ? 'selected' : '' }}>SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD" {{ old('department') == "SOD" || $requisition->department == "SOD" ? 'selected' : '' }}>SOD - School of Dentistry</option>
            <option value="SIT" {{ old('department') == "SIT" || $requisition->department == "SIT" ? 'selected' : '' }}>SIT - School of Information Technology</option>
            <option value="SIHTM" {{ old('department') == "SIHTM" || $requisition->department == "SIHTM" ? 'selected' : '' }}>SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA" {{ old('department') == "SEA" || $requisition->department == "SEA" ? 'selected' : '' }}>SEA - School of Engineering & Architecture</option>
            <option value="SCJPS" {{ old('department') == "SCJPS" || $requisition->department == "SCJPS" ? 'selected' : '' }}>SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL" {{ old('department') == "SOL" || $requisition->department == "SOL" ? 'selected' : '' }}>SOL - School of Law</option>
            <option value="SNS" {{ old('department') == "SNS" || $requisition->department == "SNS" ? 'selected' : '' }}>SNS - School of Natural Sciences</option>
            <option value="SON" {{ old('department') == "SON" || $requisition->department == "SON" ? 'selected' : '' }}>SON - School of Nursing</option>
            <option value="STELA" {{ old('department') == "STELA" || $requisition->department == "STELA" ? 'selected' : '' }}>STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School" {{ old('department') == "Graduate School" || $requisition->department == "Graduate School" ? 'selected' : '' }}>Graduate School</option>
            </select>   
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror 
    </div>

    <button type="submit" class="btn btn-danger">Submit</button>
<a class="btn btn-primary" href="{{ route('requisitions.index') }}">Cancel</a>


</form>

@endsection