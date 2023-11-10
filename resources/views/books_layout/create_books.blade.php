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

<div class="two-col">
    <div class="col1">
        <label>Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" value="{{ old('book_callnumber') }}" minlength="4" maxlength="25">
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Barcode</label>
        <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{ old('book_barcode') }}" minlength="2" maxlength="7">
        @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author" value="{{ old('book_author') }}" minlength="2" maxlength="40">
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen" value="{{ old('book_purchasedwhen') }}" pattern="\d*" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="number" name="book_volume" id="book_volume" value="{{ old('book_volume') }}" pattern="\d*" minlength="1" maxlength="60">
        @error('book_volume')
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

<div class="two-col">
    <div class="col1">
        <label>Copyright Year</label>
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{ old('book_copyrightyear') }}">
                <option value="">--Select Year--</option>
                @for($x=1980 ; $x <= 2030 ; $x++)
                <option value="{{$x}}">{{$x}}</option>
                @endfor
            </select>
</div>

    <div class="col2">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition" value="{{ old('book_edition') }}" minlength="1" maxlength="10">
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
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

<div class="two-col">
    <div class="col1">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn" value="{{ old('book_lccn') }}" minlength="5" maxlength="13">
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>ISBN</label>
        <input class="form-control @error('book_isbn') is-invalid @enderror" type="text" name="book_isbn" id="book_isbn" value="{{ old('book_isbn') }}" minlength="10" maxlength="13">
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
}
</style>

@endsection