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
    <a class="btn btn-primary" type="submit"><i class="fa fa-search"></i></a>
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
    <th>Reason for archive</th>
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
    @if($archive->archive_reason == 1)  
      Lost
    @elseif($archive->archive_reason == 2)
      Old
    @elseif($archive->archive_reason == 3)
      Damaged

    @endif
    </td>
    <td>
    <div class="flex-parent jc-center">
            <form action="{{ route('restoreBook', $archive->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button">Restore</button>

                <a data-toggle="modal" class="btn btn-danger" data-target="#deleteBookModal_{{$archive->id}}"
              data-action="{{ route('books.destroy', $archive->id) }}">Delete</a>
            </form>
</div>
    </td>
  </tr>
</tbody>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteBookModal_{{$archive->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this book?</h5>
            
          </div>
          <form action="{{ route('books.destroy', $archive->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete user {{$archive->book_title}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>

<style> 
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}

.flex-parent {
  display: flex;
}

.jc-center {
  justify-content: center;
}
</style>


@endforeach

@endsection