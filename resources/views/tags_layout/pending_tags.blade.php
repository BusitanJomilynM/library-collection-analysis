@extends('master_layout.master')
@section('Title', 'Book Subject')
@section('content')

<h2 style="text-align: center;">Books Subject</h2>

<div>
<form style="margin:auto;max-width:300px">
    <input type="search" class="form-control mr-sm-2" placeholder="Search Books" name="search"  value="{{ request('search') }}">
    <input class="btn btn-primary my-2 my-sm-0" type="submit" value="Search">
</form>
</div>

<a class="btn btn-primary my-2 my-sm-0" href="{{ route('subjects.index') }}">Back to list</a>

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
  <th>Department</th>
    <th>Book Barcode</th>
    <th>Suggested Tags</th>
    <th>Actions</th>
  </tr>
</thead>

@forelse($pending as $pendingr)
<tbody>
  <tr align="center">
    <td>{{$pendingr->id}}</td>
    <td>{{$pendingr->department}}</td>
    <td>{{$pendingr->book_barcode}}</td>
    <td>{{$pendingr->suggest_book_subject}}</td>
    <td>@foreach($users as $user)
      @if($user->id == $pendingr->user_id)
      {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
      @endif
      @endforeach
    </td>
    <td>
      @if($pendingr->type == 'technician librarian')
      Technician Librarian
      @elseif($pendingr->type == 'staff librarian')
      Staff Librarian
      @elseif($pendingr->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$pendingr->department}}</td>
    <td>
    @if($pendingr->status == 0)
     Pending
    @endif
    </td>
    <td>

    @if($pendingr->status == 0)
    <div style="width: 50%;">
            <form action="{{ route('accept', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button">Accept</button>
            </form>

            <form action="{{ route('decline', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button">Decline</button>
            </form>
            <!-- <a class="btn btn-primary" href="{{ route('tags.edit', $pendingr->id) }}" role="button">Edit</a> -->
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingr->id}}"
            data-action="{{ route('tags.destroy', $pendingr->id) }}">Delete</a>
    </div>
        
        
       

    @else
    <div style="width: 50%">
            <form action="{{ route('accept', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button" disabled>Accept</button>
            </form>

            <form action="{{ route('decline', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button" disabled>Decline</button>
            </form>
            <!-- <a class="btn btn-primary" href="{{ route('tags.edit', $pendingr->id) }}" role="button" disabled>Edit</a> -->
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingr->id}}"
            data-action="{{ route('tags.destroy', $pendingr->id) }}" disabled>Delete</a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>
  <!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal_{{$pendingr->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $pendingr->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$pendingr->book_title}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>
@empty
  <li class="list-group-item list-group-item-danger">No Pending Tags</li>  
@endforelse

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $pending->render(); ?>
    </div>
</div>
@endsection