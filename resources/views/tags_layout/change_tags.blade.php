@extends('master_layout.master')
@section('Title', 'Create Subject Suggestion')
@section('content')

<form action="{{ route('append',$book->id, $tag->id) }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
        <input class="form-control" type="string" value="{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}" readonly>
    </div>

    <div class="form-group">
    <label>Barcode</label>
    <input class="form-control" type="text" name="book_barcode" id="book_barcode" value="{{ $bookBarcode }}" readonly> 
</div>

    <div class="form-group">
        <label>Suggested Subject</label>
        <input class="form-control @error('suggest_book_subject') is-invalid @enderror" type="text" name="suggest_book_subject" id="suggest_book_subject" value="{{$tag->suggest_book_subject}}" minlength="1" maxlength="60">
        @error('suggest_book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

@endsection