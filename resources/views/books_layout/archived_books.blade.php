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
    <input class="button btn-primary my-2 my-sm-0" type="submit" value="Search">
</form>
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

@foreach($archives as $archive)
<tbody>
  <tr align="center">
    <td>{{$archive->book_title}}</td>
    <td>{{$archive->book_author}}</td>
    <td>{{$archive->book_copyrightyear}}</td>
    <td>{{$archive->book_sublocation}}</td>
    <td><?php $t = $archive->book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?>
    </td>
    <td>
            <form action="{{ route('restoreBook', $archive->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button">Restore</button>
            </form>
    </td>
  </tr>
</tbody>

<style> 
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}
</style>


@endforeach

@endsection