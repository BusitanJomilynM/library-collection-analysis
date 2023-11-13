@extends('master_layout.master')
@section('Title', 'Books')
@section('content')
<h2 style="text-align: center;">Books</h2>

<div class="panel panel-default">
@if (session('success'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {{ session('success') }}
</div>
@endif
</div>

<div>
<form style="margin:auto;max-width:300px">
    <input type="text" class="form-control mr-sm-2" placeholder="Search Books" name="search"  value="{{ request('search') }}">
    <button type="submit" class="btn btn-danger">
    <i class="fa fa-search"></i>
    </button>
</form>
</div>

<br>

@if($user->type == 'technician librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('archive') }}">Archived Books</a>
<!-- <a class="btn btn-primary" href="{{ route('books.create') }}" ><span>&#43;</span> Add Book</a> -->

<a data-toggle="modal" class="btn btn-primary" data-target="#createBookModal"><span>&#43;</span></i> Add New Book</a>
<a class="btn btn-danger" href="{{ route('booklist_pdf') }}">Export to PDF</a>
<br><br>

<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Call Number</th>
    <th>Barcode</th>
    <th>Author</th>
    <th>Actions</th>
  </tr>
</thead>

@forelse($books as $book)
@if($book->status == 0)
<tbody>
  <tr align="center">
    <td>{{$book->book_title}}</td>
    <td>{{$book->book_callnumber}}</td>
    <td>{{$book->book_barcode}}</td>
    <td>{{$book->book_author}}</td>

    <td>
     
    <a class="btn btn-primary" href="{{ route('books.view_bookdetails', $book->id) }}" role="button"><span>&#9783;</span>Details</a>

       
    </td>
  </tr>
  </tbody>

<!-- Archive Modal -->
<div class="modal fade" id="archiveBookModal_{{$book->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to archive this book?.</h5>
          </div>
          <form action="{{ route('archiveBook', $book->id) }}" method="POST">
            <div class="modal-body">
              {{ csrf_field() }}
              {{ method_field('GET') }}
              <h5 class="text-center">Archive {{$book->book_title}} ?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Archive</button>
            </div>
        </form>
        </div>
      </div>
</div>


@endif 

@empty
<li class="list-group-item list-group-item-danger">Entry not found</li>  

@endforelse

<!-- Department Representative -->
@elseif($user->type == 'department representative')
<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Author</th>
    <th>Action</th>

  </tr>
</thead>

@forelse($books as $book)
@if($book->status == 0)
<tbody>
  <tr align="center">
    <td>{{$book->book_title}}</td>
    <td>{{$book->book_author}}</td>

    </td>
    <td><a class="btn btn-primary" href="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}" role="button">Suggest Subject</a></td>

    
  </tr>
  </tbody>
@endif
@empty
<li class="list-group-item list-group-item-danger">Entry not found</li> 
@endforelse

<!-- staff librarian -->
@elseif($user->type == 'staff librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('archive') }}">Archived Books</a> <br><br>
<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Author</th>
    <th>Action</th>

  </tr>
</thead>

@forelse($books as $book)
@if($book->status == 0)
<tbody>
  <tr align="center">
    <td>{{$book->book_title}}</td>
    <td>{{$book->book_author}}</td>

    </td>
    <td><a class="btn btn-warning" href="{{ route('archiveBook', ['book' => $book->id]) }}" role="button">Archive</a> </td>
    </td>
  </tr>
  </tbody>

<!-- Archive Modal -->
<div class="modal fade" id="archiveBookModal_{{$book->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to archive this book?.</h5>
          </div>
          <form action="{{ route('archiveBook', $book->id) }}" method="POST">
            <div class="modal-body">
              {{ csrf_field() }}
              {{ method_field('GET') }}
              <h5 class="text-center">Archive {{$book->book_title}} ?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Archive</button>
            </div>
        </form>
        </div>
      </div>
</div>
@endif

@empty
<li class="list-group-item list-group-item-danger">Entry not found</li> 
@endforelse

@endif


<!-- Create User Modal -->
<div class="modal fade" id="createBookModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createBookModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createBookModalLabel">Add New Book</h5>
      </div>
        <form action="{{ route('books.store') }}" method="POST">
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="form-group">
        <label>Book Title</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title"  minlength="1" maxlength="60" required>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" minlength="4" maxlength="25" required>
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
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
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author"  minlength="2" maxlength="40" required>
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen"  pattern="\d*" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="number" name="book_volume" id="book_volume"  pattern="\d*" minlength="1" maxlength="60" required>
        @error('book_volume')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


    <div class="form-group">
        <label>Sublocation</label>
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation" required>
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
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" required>
                <option value="">--Select Year--</option>
                @for($x=1980 ; $x <= 2030 ; $x++)
                <option value="{{$x}}">{{$x}}</option>
                @endfor
            </select>
</div>

    <div class="col2">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition"  minlength="1" maxlength="10" required>
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
    <br>
    <div class="form-group">
        <label>Subject</label>
        <input class="form-control @error('book_subject') is-invalid @enderror" type="text" name="book_subject" id="book_subject"  minlength="4" maxlength="50" required>
        @error('book_subject')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Published By</label>
        <input class="form-control @error('book_publisher') is-invalid @enderror" type="text" name="book_publisher" id="book_publisher"minlength="4" maxlength="50" required>
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn"  minlength="5" maxlength="13" required
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>ISBN</label>
        <input class="form-control @error('book_isbn') is-invalid @enderror" type="text" name="book_isbn" id="book_isbn"  minlength="10" maxlength="13" required>
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
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
</table>

<div class="d-flex">
    <div class="mx-auto">
      <?php echo $books->render(); ?>
    </div>
</div>

<br>


<style> 
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}
</style>
@endsection