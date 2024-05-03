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
<style> 
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}
</style>
@endsection
