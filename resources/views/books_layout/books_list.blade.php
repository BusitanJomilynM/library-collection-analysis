
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

    <a class="btn btn-primary" href="{{ route('books.view_bookdetails', $book->id) }}" role="button"><span>&#9783;</span></a>
      <!-- <a class="btn btn-primary" href="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}" role="button">Suggest Subject</a> -->
        <!-- <a data-toggle="modal" class="btn btn-primary" data-target="#createTagModal_{{$book->book_barcode}}" data-action="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}"><span>&#43;</span></i> Suggest Subjects</a>

        <a data-toggle="modal" class="btn btn-primary" data-target="#createKeywordSuggestModal_{{$book->book_barcode}}" data-action="{{ route('keywordsuggest.create', ['book_barcode' => $book->book_barcode]) }}"><span>&#43;</span></i> Suggest Keywords</a> -->
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======


<!-- Suggest Keyword -->
=======
=======
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
>>>>>>> parent of a0e42c6 (continuation deletion)




<<<<<<< HEAD
<<<<<<< HEAD
<!-- Suggest Keyword
<<<<<<< HEAD
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
<!-- Suggest Keyword -->
>>>>>>> parent of 6d07c62 (deletion:keywords)
=======
<!-- Suggest Keyword
>>>>>>> parent of a0e42c6 (continuation deletion)
<div class="modal fade" id="createKeywordSuggestModal_{{$book->book_barcode}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createKeywordSuggestModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Suggest Keywords to book</h5>
      </div>
      <form action="{{ route('keywordsuggest.store') }}" method="POST">
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
                <label>Current Keyword/s</label>
                <select class="js-responsive" name="book_keyword[]" id="book_keyword_{{$book->book_barcode}}" multiple="multiple" style="width: 100%" disabled>
                    @foreach($keywords as $keyword)
                    <?php
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                          $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
=======
                          // $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
                          // $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
                          $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
>>>>>>> parent of 6d07c62 (deletion:keywords)
=======
                          // $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
>>>>>>> parent of a0e42c6 (continuation deletion)
                      ?>
                      <option value="{{ $keyword->id }}" {{ $selected ? 'selected' : '' }}>
                          {{ $keyword->keyword }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
    <label class="required">Suggested Keywords</label>
    <select class="js-responsive2" name="suggest_book_keyword[]" id="suggest_book_keyword_{{$book->book_barcode}}" multiple="multiple" style="width: 100%" required>
        @foreach($keywords as $keyword)
            <?php 
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of 6d07c62 (deletion:keywords)
                $keywordsdecode = json_decode($book->book_keyword, true);
                if ($keywordsdecode !== null) {
                    $alreadyAssociated = false;
                    foreach ($keywordsdecode as $subjkey) {
                        if ($subjkey == $keyword->id){
                            $alreadyAssociated = true;
                            break;
                        }
                    }
                    if (!$alreadyAssociated) {
                        echo '<option value="'.$keyword->id.'">'.$keyword->keyword.'</option>'; 
                    }
                } else {
                    echo '<option value="'.$keyword->id.'">'.$keyword->keyword.'</option>'; 
                }
<<<<<<< HEAD
=======
=======
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
>>>>>>> parent of a0e42c6 (continuation deletion)
                // $keywordsdecode = json_decode($book->book_keyword, true);
                // if ($keywordsdecode !== null) {
                //     $alreadyAssociated = false;
                //     foreach ($keywordsdecode as $subjkey) {
                //         if ($subjkey == $keyword->id){
                //             $alreadyAssociated = true;
                //             break;
                //         }
                //     }
                //     if (!$alreadyAssociated) {
                //         echo '<option value="'.$keyword->id.'">'.$keyword->keyword.'</option>'; 
                //     }
                // } else {
                //     echo '<option value="'.$keyword->id.'">'.$keyword->keyword.'</option>'; 
                // }
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
>>>>>>> parent of a0e42c6 (continuation deletion)
=======
>>>>>>> parent of 6d07c62 (deletion:keywords)
=======
>>>>>>> parent of a0e42c6 (continuation deletion)
            ?>
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> parent of fe7c657 (allduplicateswillbeupdated)
@endif
=======
@endif 
=======
@endif
>>>>>>> parent of 6d07c62 (deletion:keywords)

>>>>>>> parent of a0e42c6 (continuation deletion)
=======
@endif 

>>>>>>> parent of a0e42c6 (continuation deletion)
@empty
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
@endforelse
=======
@endif 

@empty
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
@endforelse-->
>>>>>>> parent of a0e42c6 (continuation deletion)

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
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title"  minlength="1" maxlength="60" value="{{ old('book_title') }}" required>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-4">
        <label class="required">Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" minlength="4" maxlength="25"  value="{{ old('book_callnumber') }}" required >
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror      
    </div>

        <div class="col-md-2">
            <label>Description</label>
            <input class="form-control @error('book_callnumberdescription') is-invalid @enderror" type="text" name="book_callnumberdescription" id="book_callnumberdescription" value="{{ old('book_callnumberdescription') }}"  placeholder="copy number">
        @error('book_callnumberdescription')
            <span class="text-danger">{{$message}}</span>
        @enderror 
        </div>

        <div class="col-md-4">
        <label class="required">Barcode</label>
            <div class="input-group">
                <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" minlength="2" maxlength="7" value="{{ old('book_barcode') }}" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="generateBarcodeButton">Generate Barcode</button>
                </div>
            </div>
            @error('book_barcode')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>


    <div class="form-group">
        <label class="required">Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author"  minlength="2" maxlength="150" value="{{ old('book_author') }}" required>
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="required">Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen"  pattern="\d*" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ old('book_purchasedwhen') }}" required>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <!-- <div class="col-md-6">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="number" name="book_volume" id="book_volume"  pattern="\d*" minlength="1" maxlength="60">
        @error('book_volume')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div> -->

    <div class="form-group">
        <label class="required">Location</label>
            <select class="form-control @error('type') is-invalid @enderror" name="book_sublocation" id="book_sublocation" value="{{ old('book_sublocation') }}" required>
            <option value="">--Select Sublocation--</option>
            <option value="A Building">RCB Library - A Building</option>
            <option value="F Building">Centennial Library - H Building</option>
            <option value="H Building">FGB Library - F Building</option>
            </select>
            @error('book_sublocation')
            <span class="text-danger">{{$message}}</span>
            @enderror
    </div>

    <div class="form-group">
        <label class="required">Copyright Year</label>
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{ old('book_copyrightyear') }}"required>
                <option value="">--Select Year--</option>
                @for($x=1920 ; $x <= 2030 ; $x++)
                <option value="{{$x}}">{{$x}}</option>
                @endfor
            </select>
</div>

<div class="form-group">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition"  minlength="1" maxlength="50" value="{{ old('book_edition') }}">
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<<<<<<< HEAD
    <div class="form-group">
    <label>Subject</label>
=======
<div class="form-group">
    <label>Course Subject the Book is Associated to:</label>
>>>>>>> parent of a0e42c6 (continuation deletion)
      <select class="mySelect for" name="book_subject[]" id="book_subject" multiple="multiple" style="width: 100%" required>
      <option value="0">--NO SUBJECT--</option>
      @foreach($subjects as $subject)
      <option value="{{$subject->id}}" {{ (collect(old('book_subject'))->contains($subject->id)) ? 'selected':'' }}>{{$subject->subject_name}}</option>     
       @endforeach
      </select>
    </div>


    <div class="form-group">
        <label class="required">Published By</label>
        <input class="form-control @error('book_publisher') is-invalid @enderror" type="text" name="book_publisher" id="book_publisher"minlength="4" maxlength="50" value="{{ old('book_publisher') }}" required>
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn"  minlength="5" maxlength="13" value="{{ old('book_lccn') }}">
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="required">ISBN</label>
        <input class="form-control @error('book_isbn') is-invalid @enderror" type="text" name="book_isbn" id="book_isbn"  minlength="10" maxlength="20" value="{{ old('book_isbn') }}">
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>


<div class="form-group">

<label class="required">Keyword</label>
      <select class="mySelect for" name="book_keyword[]" id="book_keyword" multiple="multiple" style="width: 100%" required>
      @foreach($keywords as $keyword)
      <option value="{{$keyword->id}}" {{ (collect(old('book_keyword'))->contains($keyword->id)) ? 'selected':'' }}>{{$keyword->keyword}}</option>      
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

$(".js-responsive2").select2({
  
});

</script>

<script>
    // Function to generate a random barcode
    function generateBarcode() {
        var barcode = 'T' + Math.floor(10000 + Math.random() * 90000); // Generate a random number between 10000 and 99999

        // Check if the generated barcode already exists in the input field
        var barcodeInput = document.getElementById("book_barcode");
        while (barcodeInput.value === barcode) {
            barcode = 'T' + Math.floor(10000 + Math.random() * 90000); // Regenerate barcode until it's unique
        }

        return barcode;
    }

    // Event listener for the button click
    document.getElementById("generateBarcodeButton").addEventListener("click", function() {
        var barcodeInput = document.getElementById("book_barcode");
        barcodeInput.value = generateBarcode();
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