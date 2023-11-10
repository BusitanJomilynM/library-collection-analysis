@extends('master_layout.master')
@section('Title', 'Edit Book')
@section('content')

<form action="{{ route('archiveUpdate', $book->id) }}" method="POST">
    @csrf
    @method('GET')
    <div class="form-group">
   
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$book->book_title}}" minlength="1" maxlength="60" hidden>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
     
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" value="{{$book->book_callnumber}}" minlength="4" maxlength="25" hidden>
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Bar Code</label>
        <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{$book->book_barcode}}" minlength="4" maxlength="25" hidden> 
        @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
       
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author" value="{{$book->book_author}}" minlength="2" maxlength="40" hidden>
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="text" name="book_purchasedwhen" id="book_purchasedwhen" value="{{$book->book_copynumber}}" minlength="2" maxlength="40" hidden>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
       
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation" value="{{$book->book_sublocation}}" hidden>
            <option value="A Building" {{ old('book_sublocation') == "A Building" || $book->book_sublocation == "A Building" ? 'selected' : '' }}>A Building</option>
            <option value="F Building" {{ old('book_sublocation') == "F Building" || $book->book_sublocation == "F Building" ? 'selected' : '' }}>F Building</option>
            <option value="H Building" {{ old('book_sublocation') == "H Building" || $book->book_sublocation == "H Building" ? 'selected' : '' }}>H Building</option>
            </select>
            @error('book_sublocation')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <div class="form-group">
      
        <input class="form-control" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{$book->book_copyrightyear}}" hidden>
        @error('book_copyrightyear')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    

    <div class="form-group">
    
        <input class="form-control @error('book_subject') is-invalid @enderror" type="text" name="book_subject" id="book_subject" value="{{$book->book_subject}}" minlength="4" maxlength="50" hidden>
        @error('book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>



    <div class="form-group">
    
        <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="{{$book->book_publisher}}" hidden>
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="form-group">
       
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn" value="{{$book->book_lccn}}" minlength="4" maxlength="50" hidden>
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
  
        <input class="form-control" type="text" name="book_isbn" id="book_isbn" value="{{$book->book_isbn}}" hidden>
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="form-group">
     
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition" value="{{$book->book_edition}}" minlength="4" maxlength="50" hidden> 
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">

        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="status" id="status" value="1" hidden> 
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">

        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen" value="{{ $book->book_purchasedwhen}}" pattern="\d*" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" hidden>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
            <select class="form-control @error('type') is-invalid @enderror" name="archive_reason" id="archive_reason" required>
            <option value="">--Select Reason--</option>
            <option value="1">Lost</option>
            <option value="2">Old</option>
            <option value="3">Damaged</option>
            </select>
    </div>

<button type="submit" class="btn btn-primary">Submit</button>
<a class="btn" onclick="history.back()">Cancel</a>

</form>

@endsection