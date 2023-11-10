@extends('master_layout.master')
@section('Title', 'Add a Copy')
@section('content')

<form action="{{ route('books.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Book Title</label>
        <input class="form-control" type="text" name="book_title" id="book_title" value="{{ $book->book_title }}" minlength="1" maxlength="60" readonly>
        <input type="hidden" name="book_title" value="{{ $book->book_title }}">
    </div>

    <div class="two-col">
        <div class="col1">
            <label>Book Callnumber</label>
            <input class="form-control" type="text" name="book_callnumber" id="book_callnumber" value="{{ $book->book_callnumber }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_callnumber" value="{{ $book->book_callnumber }}">
        </div>

        <div class="col2">
            <label>Book Barcode</label>
            <input class="form-control" type="text" name="book_barcode" id="book_barcode" value="{{ $barcode }}" minlength="4" maxlength="25">
            @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control" type="text" name="book_author" id="book_author" value="{{ $book->book_author }}" minlength="1" maxlength="60" readonly>
        <input type="hidden" name="book_author" value="{{ $book->book_author }}">
    </div>

    <div class="form-group">
        <label>Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen" value="{{ $book->book_purchasedwhen}}" pattern="\d*" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control" type="text" name="book_volume" id="book_volume" value="{{ $book->book_volume }}" minlength="1" maxlength="60" readonly>
        <input type="hidden" name="book_volume" value="{{ $book->book_volume }}">
    </div>

    <div class="form-group">
        <label>Sublocation</label>
        <input class="form-control" type="text" name="book_sublocation" id="book_sublocation" value="{{ $book->book_sublocation }}" readonly>
        <input type="hidden" name="book_sublocation" value="{{ $book->book_sublocation }}">
      
    </div>


    <div class="two-col">
        <div class="col1">
            <label>Copyright Year</label>
            <input class="form-control" type="text" name="book_copyrightyear" id="book_copyrightyear" value="{{ $book->book_copyrightyear }}" readonly>
            <input type="hidden" name="book_copyrightyear" id="book_copyrightyear" value="{{ $book->book_copyrightyear }}">
        </div>

        <div class="col2">
            <label>Edition</label>
            <input class="form-control" type="text" name="book_edition" id="book_edition" value="{{ $book->book_edition }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_edition" value="{{ $book->book_edition }}">
        </div>
    </div>

    <div class="form-group">
        <label>Tags</label>
        <input class="form-control" type="text" name="book_subject" id="book_subject" value="{{ $book->book_subject }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_subject" value="{{ $book->book_subject }}">
    </div>

    
    <div class="form-group">
        <label>Published By</label>
        <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="{{ $book->book_publisher }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_publisher" value="{{ $book->book_publisher }}">
    </div>

    <div class="two-col">
        <div class="col1">
            <label>LCCN</label>
            <input class="form-control" type="text" name="book_lccn" id="book_lccn" value="{{ $book->book_lccn }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_lccn" value="{{ $book->book_lccn }}">
        </div>
        <div class="col2">
            <label>ISBN</label>
            <input class="form-control" type="text" name="book_isbn" id="book_isbn" value="{{ $book->book_isbn }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_isbn" value="{{ $book->book_isbn }}">
        </div>
    </div>

    <br>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="nav-link" href="{{ route('books.index') }}">Cancel</a>

</form>

<style> 
.two-col {
    overflow: hidden; /* Makes this div contain its floats */
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
