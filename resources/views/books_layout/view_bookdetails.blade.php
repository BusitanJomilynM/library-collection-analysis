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
<br><br>

    <table class="table table-bordered" style="width:100%" border="0">


        
      
       <tr>
        <td> <div class="form"><h5>Book title: {{ $book->book_title }}</h5></div> 
        <br>
        <div class="form"><h5>Author: {{ $book->book_author }}</h5></div> 
        <br>
        <div class="form"><h5>Copyright Year: {{ $book->book_copyrightyear}}</h5></div> 
        <br>
        <div class="form"><h5>Sublocation: {{ $book->book_sublocation}}</h5></div> 
        <br>
        <!-- <div class="form"><h5>Volume: {{ $book->book_volume}}</h5></div>
        <br> -->
        <div class="form">
    <h5>Subjects:
        <?php  
        $bookSubjects = json_decode($book->book_subject);

        foreach ($subjects as $subject) {
            if (in_array($subject->id, $bookSubjects)) {
                echo $subject->subject_name;
                echo ", ";
            }
        }
        ?>
    </h5>
</div> 
        

        <td>
        <div class="form"><h5>Barcode: {{ $book->book_barcode}}</h5></div> 
        <br>
        <div class="form"><h5>Call Number: {{ $book->book_callnumber}} {{$book->book_callnumberdescription}}</h5></div> 
        <br>
        <div class="form"><h5>Publisher: {{ $book->book_publisher}}</h5></div> 
        <br>
        <div class="form"><h5>Date of Purchase: {{ $book->book_purchasedwhen}}</h5></div> 
        <br>
        <div class="form"><h5>Edition: {{ $book->book_edition}}</h5></div> 
        <br>
        <div class="form"><h5>LCCN: {{ $book->book_lccn}}</h5></div> 
        <br>
        <div class="form"><h5>ISBN: {{ $book->book_isbn}}</h5></div> 
        <br>
        <div class="form">
    <h5>Keyword:
        <?php  
        $bookKeywords = json_decode($book->book_keyword);

        foreach ($keywords as $keyword) {
            if (in_array($keyword->id, $bookKeywords)) {
                echo $keyword->keyword;
                echo ", ";
            }
        }
        ?>
    </h5>
</div> 


<<<<<<< HEAD
<<<<<<< HEAD
@if ($canSuggest)
    <!-- <a data-toggle="modal" class="btn btn-primary" data-target="#createTagModal_{{$book->book_barcode}}" data-action="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}"><span>&#43;</span> Suggest Subjects</a>

    <a data-toggle="modal" class="btn btn-primary" data-target="#createKeywordSuggestModal_{{$book->book_barcode}}" data-action="{{ route('keywordsuggest.create', ['book_barcode' => $book->book_barcode]) }}"><span>&#43;</span> Suggest Keywords</a> -->
@else
=======
@if ($user->type == 'teacher' && $user->type == 'department representative')
>>>>>>> parent of fe7c657 (allduplicateswillbeupdated)
=======
@if ($user->type == 'teacher' && $user->type == 'department representative')
>>>>>>> parent of fe7c657 (allduplicateswillbeupdated)
    <tr>
        <td colspan="2" class="center">
            <a data-toggle="modal" class="btn btn-primary" data-target="#editBookModal" data-action="{{ route('books.edit', $book->id) }}"><span>&#9776;</span> Edit</a>
            <a data-toggle="modal" class="btn btn-success" data-target="#createCopyModal" data-action="{{ route('books.book_createcopy', $book->id) }}"><span>&#43;</span>Add Copy</a>
            <a data-toggle="modal" class="btn btn-warning" data-target="#archiveBookModal" data-action="{{ route('archiveBook', $book->id) }}">Archive</a>
        </td>
    </tr>
@endif

    </tr>

<<<<<<< HEAD
   
          
                <!-- <tr align="center">
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
           

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
                        <a data-toggle="modal" class="btn btn-primary" data-target="#editBookModal" data-action="{{ route('books.edit', $book->id) }}"><span>&#9776;</span> Edit</a>
                        <a data-toggle="modal" class="btn btn-success" data-target="#createCopyModal" data-action="{{ route('books.book_createcopy', $book->id) }}"><span>&#43;</span>Add Copy</a>
                        
                           <a data-toggle="modal" class="btn btn-warning" data-target="#archiveBookModal" data-action="{{ route('archiveBook', $book->id) }}">Archive</a>
                    </td>
                </tr> -->
            </tbody>
           
       
<div>

>>>>>>> parent of fe7c657 (allduplicateswillbeupdated)
=======
<!-- Suggest Keyword -->
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
                          $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
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
>>>>>>> parent of 6d07c62 (deletion:keywords)
=======

>>>>>>> parent of 7190691 (viewbookdetails/deptrep and teacher)
=======
=======
   
          
                <!-- <tr align="center">
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
           

                        <a data-toggle="modal" class="btn btn-primary" data-target="#editBookModal" data-action="{{ route('books.edit', $book->id) }}"><span>&#9776;</span> Edit</a>
                        <a data-toggle="modal" class="btn btn-success" data-target="#createCopyModal" data-action="{{ route('books.book_createcopy', $book->id) }}"><span>&#43;</span>Add Copy</a>
                        
                           <a data-toggle="modal" class="btn btn-warning" data-target="#archiveBookModal" data-action="{{ route('archiveBook', $book->id) }}">Archive</a>
                    </td>
                </tr> -->
            </tbody>
           
       
<div>
>>>>>>> parent of fe7c657 (allduplicateswillbeupdated)

>>>>>>> parent of 7190691 (viewbookdetails/deptrep and teacher)
<!-- Edit Book Modal -->
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
        <label class="required">Book Name</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$book->book_title}}" minlength="1" maxlength="60" required>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
        <label class="required">Call Number</label>
        <input class="form-control @error('book_callnumber') is-invalid @enderror" type="text" name="book_callnumber" id="book_callnumber" value="{{$book->book_callnumber}}" minlength="4" maxlength="25" required>
        @error('book_callnumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

<div class="col-md-6">
    <div class="row">
        <div class="col-md-8">
            <label class="required">Barcode</label>
            <div class="input-group">
                <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" minlength="2" maxlength="7" value="{{$book->book_barcode}}" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="generateBarcodeButton">Generate Barcode</button>
                </div>
            </div>
            @error('book_barcode')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
</div>


    <div class="form-group">
        
    </div>

    <div class="form-group">
        <label class="required">Author</label>
        <input class="form-control @error('book_author') is-invalid @enderror" type="text" name="book_author" id="book_author" value="{{$book->book_author}}" minlength="2" maxlength="40" required>
        @error('book_author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="required">Purchase Date</label>
        <input class="form-control @error('book_purchasedwhen') is-invalid @enderror" type="date" name="book_purchasedwhen" id="book_purchasedwhen" value="{{$book->book_purchasedwhen}}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        @error('book_purchasedwhen')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <!-- <div class="col-md-6">
        <label>Volume</label>
        <input class="form-control @error('book_volume') is-invalid @enderror" type="text" name="book_volume" id="book_volume" value="{{$book->book_volume}}" minlength="2" maxlength="40">
        @error('book_volume')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div> -->
<br>
    <div class="form-group">
        <label class="required">Sublocation</label>
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
        <label class="required">Copyright Year</label>
            <select class="form-control @error('type') is-invalid @enderror" type="number" name="book_copyrightyear" id="book_copyrightyear" value="{{ old('book_copyrightyear') }}" required>
                <option value="">--Select Year--</option>
                @for($x=1980 ; $x <= 2030 ; $x++)
                <option value="{{$x}}" {{ old('book_copyrightyear') == $x || $book->book_copyrightyear == $x ? 'selected' : '' }}>{{$x}}</option>
                @endfor
            </select>
</div>

<div class="form-group">
        <label>Edition</label>
        <input class="form-control @error('book_edition') is-invalid @enderror" type="text" name="book_edition" id="book_edition" value="{{$book->book_edition}}" minlength="4" maxlength="50">
        @error('book_edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<<<<<<< HEAD

    <div class="form-group">
        <label class="required">Subjects</label>
=======
<div class="form-group">
        <label class="required">Course Subject the Book is Associated to:</label>
>>>>>>> parent of a0e42c6 (continuation deletion)
        <select class="js-responsive" name="book_subject[]" id="book_subject" multiple="multiple" style="width: 100%" required>
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

    <!--extension  -->

    <div class="form-group">
        <label class="required">Published By</label>
        <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="{{$book->book_publisher}}" required>
        @error('book_publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="row">
        <div class="col-md-6">
        <label>LCCN</label>
        <input class="form-control @error('book_lccn') is-invalid @enderror" type="text" name="book_lccn" id="book_lccn" value="{{$book->book_lccn}}" minlength="4" maxlength="50" required>
        @error('book_lccn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="required">ISBN</label>
        <input class="form-control" type="text" name="book_isbn" id="book_isbn" value="{{$book->book_isbn}}" required>
        @error('book_isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
                    </div>
    <div class="form-group">
        <div class="col2">
        <label class="required">Keyword</label>
            <select class="js-responsive" name="book_keyword[]" id="book_keyword" multiple="multiple" style="width: 100%" required>
                
                <option value="{{$keyword->id}}"></option>
                @foreach($keywords as $keyword)
                <?php
                   $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
               ?>
               <option value="{{$keyword->id}}" {{ $selected ? 'selected' : '' }}>
               {{$keyword->keyword}}
                </option>
            @endforeach
            </select>
            </div>
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

    <div class="row">
        <div class="col-md-4">
            <label>Book Callnumber</label>
            <input class="form-control" type="text" name="book_callnumber" id="book_callnumber" value="{{ $book->book_callnumber }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_callnumber" value="{{ $book->book_callnumber }}">
        </div>
        <div class="col-md-2">
            <label>Description</label>
            <input class="form-control" type="text" name="book_callnumberdescription" id="book_callnumberdescription" minlength="1" maxlength="20" required placeholder="copy number">
        </div>

        <div class="col-md-4">
        <label>Barcode</label>
            <input class="form-control @error('book_barcode') is-invalid @enderror" type="text" name="book_barcode" id="book_barcode" value="{{$book->book_barcode}}"  minlength="2" maxlength="7" required>
            @error('book_barcode')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
    </div>
    <br>
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
<!-- 
    <div class="col-md-6">
        <label>Volume</label>
        <input class="form-control" type="text" name="book_volume" id="book_volume" value="{{ $book->book_volume }}" minlength="1" maxlength="60" readonly>
        <input type="hidden" name="book_volume" value="{{ $book->book_volume }}">
    </div> -->
<br>
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
        <br>
        <div class="col2">
            <label>Edition</label>
            <input class="form-control" type="text" name="book_edition" id="book_edition" value="{{ $book->book_edition }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_edition" value="{{ $book->book_edition }}">
        </div>
    </div>
    <br>
    <div class="form-group">
        <label>Subjects</label>
        <select class="js-responsive2" name="book_subject[]" id="book_subject2" multiple="multiple" style="width: 100%" hidden >
            @foreach($subjects as $subject)
            <?php
                $selected = in_array($subject->id, json_decode($book->book_subject, true));
            ?>
               <option value="{{ $subject->id }}" {{ $selected ? 'selected' : '' }}>
                   {{ $subject->subject_name }}
                </option>
            @endforeach
        </select>

        <select class="js-responsive2" name="book_subject[]" id="book_subject2" multiple="multiple" style="width: 100%" disabled >
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
        <label>Published By</label>
        <input class="form-control" type="text" name="book_publisher" id="book_publisher" value="{{ $book->book_publisher }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_publisher" value="{{ $book->book_publisher }}">
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>LCCN</label>
            <input class="form-control" type="text" name="book_lccn" id="book_lccn" value="{{ $book->book_lccn }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_lccn" value="{{ $book->book_lccn }}">
        </div>
        <div class="col-md-6">
            <label>ISBN</label>
            <input class="form-control" type="text" name="book_isbn" id="book_isbn" value="{{ $book->book_isbn }}" minlength="1" maxlength="60" readonly>
            <input type="hidden" name="book_isbn" value="{{ $book->book_isbn }}">
        </div>
    </div>
<br>
    <div class="form-group">
        <div class="col2">
        <label>Keyword</label>
            <select class="js-responsive2" name="book_keyword[]" id="book_keyword2" multiple="multiple" style="width: 100%" hidden> 
                <option value="{{$keyword->id}}"></option>
                @foreach($keywords as $keyword)
                <?php
                   $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
               ?>
               <option value="{{$keyword->id}}" {{ $selected ? 'selected' : '' }}>
               {{$keyword->keyword}}
                </option>
            @endforeach
            </select>
            <select class="js-responsive2" name="book_keyword[]" id="book_keyword2" multiple="multiple" style="width: 100%" disabled >
                
                <option value="{{$keyword->id}}"></option>
                @foreach($keywords as $keyword)
                <?php
                   $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
               ?>
               <option value="{{$keyword->id}}" {{ $selected ? 'selected' : '' }}>
               {{$keyword->keyword}}
                </option>
            @endforeach
            </select>

            
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

<style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    button {
      padding: 10px;
      margin-top: 10px;
    }

    td.center {
      text-align: center;
    }
</style>

<script>

var placeholder = "Select Keyword";
$(".mySelect-for").select2({
    placeholder: placeholder,
    allowClear: false,
    minimumResultsForSearch: 5
});

$(".js-responsive").select2({
    
});

$(".js-responsive2").select2({
    
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
@endsection
