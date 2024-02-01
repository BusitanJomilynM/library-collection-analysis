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

@if($user->type == 'technician librarian' || $user->type ==  'staff librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('archive') }}">Archived Books</a>
<!-- <a class="btn btn-primary" href="{{ route('books.create') }}" ><span>&#43;</span> Add Book</a> -->

<a data-toggle="modal" class="btn btn-primary" data-target="#createBookModal"><span>&#43;</span></i> Add New Book</a>
<a class="btn btn-danger" href="{{ route('booklist_pdf') }}">Collection Analysis</a>
<!-- <a class="btn btn-danger" href="{{ route('collection_analysis') }}">Collection Analysis</a> -->

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
     
    <a class="btn btn-primary" href="{{ route('books.view_bookdetails', $book->id) }}" role="button"><span>&#9783;</span></a>

       
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
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 

@endforelse

<!-- Department Representative & Teacher -->
@elseif($user->type == 'department representative' || $user->type == 'teacher')
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
    <td>
      <!-- <a class="btn btn-primary" href="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}" role="button">Suggest Subject</a> -->
        <a data-toggle="modal" class="btn btn-primary" data-target="#createTagModal_{{$book->book_barcode}}" data-action="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}"><span>&#43;</span></i> Suggest Subjects</a>
    </td>
  </tr>
  </tbody>

<!-- Suggest Subject Modal -->
<div class="modal fade" id="createTagModal_{{$book->book_barcode}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="dcreateTagModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Suggest Subjects to book</h5>
      </div>
      <form action="{{ route('tags.store') }}" method="POST">
          <div class="modal-body">
          @csrf
   
       
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
 
 

<div class="form-group">
    <label>Barcode</label>
    <input class="form-control" type="text" name="book_barcode" id="book_barcode" value="{{$book->book_barcode }}" readonly> 
</div>
    <div class="form-group">
        <label class="required">Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" required>
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
        <label>Current Subjects</label>
        <select class="js-responsive" name="book_subject[]" id="book_subject_{{$book->book_barcode}}" multiple="multiple" style="width: 100%" disabled>
            @foreach($subjects as $subject)
            <?php
                   $selected = in_array($subject->id, json_decode($book->book_subject, true));
               ?>
               <option value="{{ $subject->id }}" {{ $selected ? 'selected' : '' }}>
                   {{ $subject->subject_name }}
                </option>
            @endforeach
        </select>
        
    </div>

    <div class="form-group">
        <label class="required">Suggested Subjects</label>
      <select class="js-responsive" name="suggest_book_subject[]" id="suggest_book_subject_{{$book->book_barcode}}" multiple="multiple" style="width: 100%" required>
      @foreach($subjects as $subject)
      <?php $subjs = json_decode($book->book_subject, true);
      if ($subjs !== null) {
        foreach ($subjs as $subj) {
          if ($subj != $subject->id){
            echo '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>'; 
        }
    }  } ?>

      @endforeach
      </select>
    </div>

    <div class="form-group">
        <label class="required">Action</label>
            <select class="form-control" name="action" id="action" required>
            <option value="">--Select Action--</option>
            <option value=1>Append</option>
            <option value=2>Replace</option>

            </select>
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>
    <div class="form-group">
   <i>Textboxes marked with an asterisk are required.</i>
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
@endif

@empty
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
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
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
@endforelse

@endif


<!-- Create Book Modal -->
<div class="modal fade" id="createBookModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createBookModal" aria-hidden="true" >
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createBookModalLabel">Add New Book</h5>
      </div>
        <form action="{{ route('books.store') }}" method="POST" >
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="form-group">
        <label class="required">Book Title</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title"  minlength="1" maxlength="60" required>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


    <div class="row">
        <div class="col-md-6">
        <label class="required">Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" minlength="4" maxlength="25" required>
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


    <div class="col-md-6">
    <div class="row">
      <div class="col-md-9">
        <label class="required">Barcode</label>
        <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" minlength="2" maxlength="7" required>
        @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="col-md-1">
        <button class="btn btn-primary" type="button" id="generateBarcodeBtn" onclick="generateBarcode()">Generate Barcode</button>
      </div>
</div>
</div>
</div>

    <div class="form-group">
        <label class="required">Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author"  minlength="2" maxlength="150" required>
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
        <label class="required">Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen"  pattern="\d*" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="number" name="book_volume" id="book_volume"  pattern="\d*" minlength="1" maxlength="60">
        @error('book_volume')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>

    <div class="form-group">
        <label class="required">Sublocation</label>
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation" required>
            <option value="">--Select Sublocation--</option>
            <option value="A Building">Main Library - A Building</option>
            <option value="F Building">Centennial Library - F Building</option>
            <option value="H Building">FGB Library - H Building</option>
            </select>
            @error('book_sublocation')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <div class="form-group">
        <label class="required">Copyright Year</label>
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" required>
                <option value="">--Select Year--</option>
                @for($x=1980 ; $x <= 2030 ; $x++)
                <option value="{{$x}}">{{$x}}</option>
                @endfor
            </select>
</div>

<div class="form-group">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition"  minlength="1" maxlength="10" >
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
    <label>Subject</label>
      <select class="mySelect for" name="book_subject[]" id="book_subject" multiple="multiple" style="width: 100%" required>
      <option value="0">--NO SUBJECT--</option>
      @foreach($subjects as $subject)
      <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
      @endforeach
      </select>
    </div>


    <div class="form-group">
        <label class="required">Published By</label>
        <input class="form-control @error('book_publisher') is-invalid @enderror" type="text" name="book_publisher" id="book_publisher"minlength="4" maxlength="50" required>
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn"  minlength="5" maxlength="13">
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="required">ISBN</label>
        <input class="form-control @error('book_isbn') is-invalid @enderror" type="text" name="book_isbn" id="book_isbn"  minlength="10" maxlength="20" required>
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>


<div class="form-group">

<label class="required">Keyword</label>
      <select class="mySelect for" name="book_keyword[]" id="book_keyword" multiple="multiple" style="width: 100%" required>
      @foreach($keywords as $keyword)
      <option value="{{$keyword->id}}">{{$keyword->keyword}}</option>
      @endforeach
      </select>
    </div>

    <div class="form-group">
   <i>Textboxes marked with an asterisk are required.</i>
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

<script>

var placeholder = "Select Keyword";
$(".mySelect").select2({
  
    placeholder: placeholder,
    allowClear: false,
    minimumResultsForSearch: 5
});


$(".js-responsive").select2({

    
    
});





</script>

<style> 
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}
</style>
@endsection