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
            <input class="form-control" type="text" name="book_barcode" id="book_barcode" value="{{ $book->book_barcode }}" minlength="4" maxlength="25">
        </div>
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control" type="text" name="book_author" id="book_author" value="{{ $book->book_author }}" minlength="1" maxlength="60" readonly>
        <!-- <input type="hidden" name="book_author" value="{{ $book->book_author }}"> -->
    </div>

    <div class="form-group">
        <label>Number of Copies</label>
        <input class="form-control" type="text" name="book_copynumber" id="book_copynumber" value="{{ $book->book_copynumber }}" minlength="1" maxlength="60" readonly>
        <input type="hidden" name="book_copynumber" value="{{ $book->book_copynumber }}">
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control" type="text" name="book_volume" id="book_volume" value="{{ $book->book_volume }}" minlength="1" maxlength="60" readonly>
        <input type="hidden" name="book_volume" value="{{ $book->book_volume }}">
    </div>

    <div class="form-group">
        <label>Sublocation</label>
        <input type="hidden" name="book_sublocation" value="{{ $book->book_sublocation }}">
        <span>{{ $book->book_sublocation }}</span>
    </div>


    <div class="two-col">
        <div class="col1">
                <label>Copyright Year</label>
            <select class="form-control" name="book_copyrightyear" id="book_copyrightyear" style="display: none;">
                @for ($x = 1980; $x <= 2030; $x++)
                    <option value="{{ $x }}" {{ old('book_copyrightyear') == $x || $book->book_copyrightyear == $x ? 'selected' : '' }}></option>
                @endfor
            </select>
            <span id="selected_copyright_year">
                {{ old('book_copyrightyear', $book->book_copyrightyear) }}
            </span>        
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
