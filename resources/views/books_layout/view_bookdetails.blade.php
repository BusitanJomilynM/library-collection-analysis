@extends('master_layout.master')
@section('Title', 'Book Details')
@section('content')
<h2 style="text-align: center;">Books Details</h2>

<div class="panel panel-default">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('success') }}
        </div>
    @endif
</div>

<a class="btn btn-primary my-2 my-sm-0" href="{{ route('books.index') }}">Return</a>

    <table class="table table-bordered" style="width:100%">
        <thead class="thead-dark">
            <tr align="center">
                <th>Book Title</th>
                <th>Author</th>
                <th>Copyright Year</th>
                <th>Sublocation</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        @if($book->status == 0)
            <tbody>
                <tr align="center">
                    <td>{{ $book->book_title }}</td>
                    <td>{{ $book->book_author }}</td>
                    <td>{{ $book->book_copyrightyear }}</td>
                    <td>{{ $book->book_sublocation }}</td>
                    <td>
                        <?php
                        $t = $book->book_subject;
                        $a = explode(" ", $t);
                        echo implode(", ", $a);
                        ?>
                    </td>
                    <td>
                        <!-- <a class="btn btn-primary" href="{{ route('books.edit', ['book' => $book->id]) }}" role="button">Edit</a> -->

                        <a data-toggle="modal" class="btn btn-primary" data-target="#editBookModal" data-action="{{ route('books.edit', $book->id) }}"><span>&#9776;</span> Edit</a>
                        <a data-toggle="modal" class="btn btn-success" data-target="#createCopyModal" data-action="{{ route('books.book_createcopy', $book->id) }}"><span>&#43;</span>Add Copy</a>
                        <!-- <a class="btn btn-success" href="{{ route('books.book_createcopy', ['book' => $book->id]) }}" role="button"><span>&#43;</span>Add Copy</a> -->
                        <!-- <a data-toggle="modal" class="btn btn-danger" data-target="#archiveBookModal_{{$book->id}}"
                           data-action="{{ route('archiveBook', $book->id) }}">Archive</a> -->

                           <!-- <a class="btn btn-warning" href="{{ route('archiveBook', ['book' => $book->id]) }}" role="button">Archive</a> -->
                           <a data-toggle="modal" class="btn btn-warning" data-target="#archiveBookModal" data-action="{{ route('archiveBook', $book->id) }}">Archive</a>
                    </td>
                </tr>
            </tbody>
           
        @endif
<div>

<!-- Book Modal -->
<div class="modal fade" id="editBookModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editBookModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Edit Book Details</h5>
      </div>
      <form action="{{ route('books.update', $book->id) }}" method="POST">
          <div class="modal-body">
          @csrf
    @method('PUT')
    <div class="form-group">
        <label>Book Name</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$book->book_title}}" minlength="1" maxlength="60" required>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" value="{{$book->book_callnumber}}" minlength="4" maxlength="25" required>
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Bar Code</label>
        <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{$book->book_barcode}}" minlength="4" maxlength="25" required> 
        @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author" value="{{$book->book_author}}" minlength="2" maxlength="40" required>
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen" value="{{$book->book_purchasedwhen}}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="text" name="book_volume" id="book_volume" value="{{$book->book_volume}}" minlength="2" maxlength="40" required>
        @error('book_volume')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Sublocation</label>
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation" value="{{$book->book_sublocation}}" required>
            <option value="A Building" {{ old('book_sublocation') == "A Building" || $book->book_sublocation == "A Building" ? 'selected' : '' }}>A Building</option>
            <option value="F Building" {{ old('book_sublocation') == "F Building" || $book->book_sublocation == "F Building" ? 'selected' : '' }}>F Building</option>
            <option value="H Building" {{ old('book_sublocation') == "H Building" || $book->book_sublocation == "H Building" ? 'selected' : '' }}>H Building</option>
            </select>
            @error('book_sublocation')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <div class="form-group">
        <label>Copyright Year</label>
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{ old('book_copyrightyear') }}" required>
                <option value="">--Select Year--</option>
                @for($x=1980 ; $x <= 2030 ; $x++)
                <option value="{{$x}}" {{ old('book_copyrightyear') == $x || $book->book_copyrightyear == $x ? 'selected' : '' }}>{{$x}}</option>
                @endfor
            </select>
</div>

<div class="form-group">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition" value="{{$book->book_edition}}" minlength="4" maxlength="50" required>
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


    <div class="form-group">
        <label>Tags</label>
        <input class="form-control @error('book_subject') is-invalid @enderror" type="text" name="book_subject" id="book_subject" value="{{$book->book_subject}}" minlength="4" maxlength="50" required>
        @error('book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <!--extension  -->

    <div class="form-group">
        <label>Published By</label>
        <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="{{$book->book_publisher}}" required>
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="form-group">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn" value="{{$book->book_lccn}}" minlength="4" maxlength="50" required>
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>ISBN</label>
        <input class="form-control" type="text" name="book_isbn" id="book_isbn" value="{{$book->book_isbn}}" required>
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>
</div>
<div>

<!-- Create Copy Modal -->
<div class="modal fade" id="createCopyModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createCopyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Create Book Copy</h5>
      </div>
      <form action="{{ route('books.store', ['book' => $book->id]) }}" method="POST">
          <div class="modal-body">
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
        <label>Barcode</label>
            <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{ old('book_barcode', $barcode) }}"  minlength="2" maxlength="7" readonly>
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
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>
</div>

<!-- Archive Modal -->
<div class="modal fade" id="archiveBookModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to archive this book?</h5>
            
          </div>
          <form action="{{ route('archiveUpdate', $book->id) }}" method="POST">
            <div class="modal-body">
            @csrf
    @method('GET')
    <div class="form-group">
   
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$book->book_title}}" minlength="1" maxlength="60" hidden>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <input class="form-control" type="text" name="book_callnumber" id="book_callnumber" value="{{$book->book_callnumber}}" minlength="4" maxlength="25" hidden>
      
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
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
    </table>



@endsection
