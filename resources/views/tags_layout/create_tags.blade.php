@extends('master_layout.master')
@section('title', 'Create Subject')
@section('content')

<form action="{{ route('tags.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
        <input class="form-control" type="string" value="{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}" readonly>
    </div>

<div class="form-group">
    <label>Barcode</label>
    <input class="form-control" type="text" name="book_barcode" id="book_barcode" value="{{ $bookBarcode }}" readonly> 
    <!-- <input class="form-control" type="string" value="{{ $bookBarcode }}" readonly> -->
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
    
    <div class="form-group">
        <label>Suggested Subject</label>
        <input class="form-control @error('suggest_book_subject') is-invalid @enderror" type="text" name="suggest_book_subject" id="suggest_book_subject" value="{{ old('suggest_book_subject') }}" minlength="1" maxlength="60">
        @error('suggest_book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Action</label>
            <select class="form-control" name="action" id="action" required>
            <option value="">--Select Action--</option>
            <option value=1>Append</option>
            <option value=2>Replace</option>
          
            
            </select>
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <button type="submit" class="btn btn-danger">Submit</button>
<a class="btn btn-primary" href="{{ route('tags.index') }}">Cancel</a>
</form>



@endsection