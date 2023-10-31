@extends('master_layout.master')
@section('Title', 'Add Book')
@section('content')

<form action="{{ route('books.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Book Title</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{ old('book_title') }}" minlength="1" maxlength="60">
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" value="{{ old('book_callnumber') }}" minlength="4" maxlength="25">
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Barcode</label>
        <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{ old('book_barcode') }}" minlength="4" maxlength="25">
        @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author" value="{{ old('book_author') }}" minlength="2" maxlength="40">
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Number of Copies</label>
        <input class="form-control @error('book_copynumber') is-invalid @enderror" type="text" name="book_copynumber" id="book_copynumber" value="{{ old('book_copynumber') }}" minlength="2" maxlength="40">
        @error('book_copynumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


    <div class="form-group">
        <label>Sublocation</label>
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation">
            <option value="">--Select Sublocation--</option>
            <option value="A Building">A Building</option>
            <option value="F Building">F Building</option>
            <option value="H Building">H Building</option>
            </select>
            @error('book_sublocation')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <div class="form-group">
        <label>Copyright Year</label>
        <input class="form-control @error('book_copyrightyear') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{ old('book_copyrightyear') }}">
        @error('book_copyrightyear')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="form-group">
        <label>Subject</label>
        <input class="form-control @error('book_subject') is-invalid @enderror" type="text" name="book_subject" id="book_subject" value="{{ old('book_subject') }}" minlength="4" maxlength="50">
        @error('book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Published By</label>
        <input class="form-control @error('book_publisher') is-invalid @enderror" type="text" name="book_publisher" id="book_publisher" value="{{ old('book_publisher') }}" minlength="4" maxlength="50">
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn" value="{{ old('book_lccn') }}" minlength="4" maxlength="50">
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ISBN</label>
        <input class="form-control @error('book_isbn') is-invalid @enderror" type="text" name="book_isbn" id="book_isbn" value="{{ old('book_isbn') }}" minlength="4" maxlength="50">
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition" value="{{ old('book_edition') }}" minlength="4" maxlength="50">
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<button type="submit" class="btn btn-primary">Submit</button>
<a class="nav-link" href="{{ route('books.index') }}">Cancel</a>

</form>

@endsection