@section('Title', 'Books')

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Author</th>
    <th>Copyright Year</th>
    <th>Sublocation</th>
    <th>Book Subject</th>
  </tr>
</thead>

@forelse($books as $book)
<tbody>
  <tr align="center">
    <td>{{$book->book_title}}</td>
    <!-- <td>{{$book->book_barcode}}</td> -->
    <td>{{$book->book_author}}</td>
    <td>{{$book->book_copyrightyear}}</td>
    <td>{{$book->book_sublocation}}</td>
    <td><?php $t = $book->book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?>
    </td>
    
@empty
<li class="list-group-item list-group-item-danger">Entry not found</li>   

@endforelse