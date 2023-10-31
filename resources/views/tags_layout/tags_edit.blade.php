@extends('master_layout.master')
@section('title', 'Edit Subject')
@section('content')

<form action="{{ route('tags.update', $tag->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
        <input class="form-control" type="string" value="{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}" readonly>
    </div>

    <div class="form-group">
        <label>Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" value="{{$tag->department}}">
            <option value="SBAA" {{ old('department') == "SBAA" || $tag->department == "SBAA" ? 'selected' : '' }}>SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD" {{ old('department') == "SOD" || $tag->department == "SOD" ? 'selected' : '' }}>SOD - School of Dentistry</option>
            <option value="SIT" {{ old('department') == "SIT" || $tag->department == "SIT" ? 'selected' : '' }}>SIT - School of Information Technology</option>
            <option value="SIHTM" {{ old('department') == "SIHTM" || $tag->department == "SIHTM" ? 'selected' : '' }}>SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA" {{ old('department') == "SEA" || $tag->department == "SEA" ? 'selected' : '' }}>SEA - School of Engineering & Architecture</option>
            <option value="SCJPS" {{ old('department') == "SCJPS" || $tag->department == "SCJPS" ? 'selected' : '' }}>SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL" {{ old('department') == "SOL" || $tag->department == "SOL" ? 'selected' : '' }}>SOL - School of Law</option>
            <option value="SNS" {{ old('department') == "SNS" || $tag->department == "SNS" ? 'selected' : '' }}>SNS - School of Natural Sciences</option>
            <option value="SON" {{ old('department') == "SON" || $tag->department == "SON" ? 'selected' : '' }}>SON - School of Nursing</option>
            <option value="STELA" {{ old('department') == "STELA" || $tag->department == "STELA" ? 'selected' : '' }}>STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School" {{ old('department') == "Graduate School" || $tag->department == "Graduate School" ? 'selected' : '' }}>Graduate School</option>
            </select>   
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror 
    </div>    
    <div class="form-group">
        <label>Suggested Subject</label>
        <input class="form-control @error('suggest_book_subject') is-invalid @enderror" type="text" name="suggest_book_subject" id="suggest_book_subject" value="{{($tag->suggest_book_subject) }}" minlength="1" maxlength="60">
        @error('suggest_book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="nav-link" href="{{ route('tags.index') }}">Cancel</a>
</form>



@endsection