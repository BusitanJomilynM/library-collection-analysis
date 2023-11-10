@extends('master_layout.master')
@section('Title', 'Edit Book')
@section('content')

<form action="{{ route('books.update', $book->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Book Name</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$book->book_title}}" minlength="1" maxlength="60">
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" value="{{$book->book_callnumber}}" minlength="4" maxlength="25">
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Bar Code</label>
        <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{$book->book_barcode}}" minlength="4" maxlength="25"> 
        @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author" value="{{$book->book_author}}" minlength="2" maxlength="40">
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen" value="{{$book->book_purchasedwhen}}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="text" name="book_volume" id="book_volume" value="{{$book->book_volume}}" minlength="2" maxlength="40">
        @error('book_volume')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Sublocation</label>
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation" value="{{$book->book_sublocation}}">
            <option value="A Building" {{ old('book_sublocation') == "A Building" || $book->book_sublocation == "A Building" ? 'selected' : '' }}>A Building</option>
            <option value="F Building" {{ old('book_sublocation') == "F Building" || $book->book_sublocation == "F Building" ? 'selected' : '' }}>F Building</option>
            <option value="H Building" {{ old('book_sublocation') == "H Building" || $book->book_sublocation == "H Building" ? 'selected' : '' }}>H Building</option>
            </select>
            @error('book_sublocation')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>Copyright Year</label>
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{ old('book_copyrightyear') }}">
                <option value="">--Select Year--</option>
                @for($x=1980 ; $x <= 2030 ; $x++)
                <option value="{{$x}}" {{ old('book_copyrightyear') == $x || $book->book_copyrightyear == $x ? 'selected' : '' }}>{{$x}}</option>
                @endfor
            </select>
</div>

    <div class="col2">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition" value="{{$book->book_edition}}" minlength="4" maxlength="50">
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>  

    <div class="form-group">
        <label>Tags</label>
        <input class="form-control @error('book_subject') is-invalid @enderror" type="text" name="book_subject" id="book_subject" value="{{$book->book_subject}}" minlength="4" maxlength="50">
        @error('book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <!--extension  -->

    <div class="form-group">
        <label>Published By</label>
        <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="{{$book->book_publisher}}">
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
<div class="two-col">
    <div class="col1">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn" value="{{$book->book_lccn}}" minlength="4" maxlength="50">
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col2">
        <label>ISBN</label>
        <input class="form-control" type="text" name="book_isbn" id="book_isbn" value="{{$book->book_isbn}}">
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
    
<br>

<button type="submit" class="btn btn-primary">Submit</button>
<a class="nav-link" href="{{ route('books.index') }}">Cancel</a>

</form>

<style> 
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