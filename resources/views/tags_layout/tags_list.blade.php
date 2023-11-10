@extends('master_layout.master')
@section('Title', 'Book Subject')
@section('content')
<h2 style="text-align: center;">Book Subjects</h2>

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
    <a class="btn btn-danger" type="submit"><i class="fa fa-search"></i></a>
</form>
</div>

@if($user->type == 'technician librarian' || 'staff librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingTags') }}">Filter Pending Subject Request</a>
@endif

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Requested by</th>
    <th>Department</th>
    <th>Book Barcode</th>
    <th>Suggested Tags</th>
    <th>Status</th>
    <th>Actions</th>
  </tr>
</thead>

@if($user->type == 'technician librarian')
@forelse($tags as $tag)
<tbody>
  <tr align="center">
    <td>@foreach($users as $user)
          @if($user->id == $tag->user_id)
          {{$user->first_name}} {{$user->last_name}}
          @endif
      @endforeach</td>
    <td>{{$tag->department}}</td>
    <td>{{$tag->book_barcode}}</td>
    <td><?php $t = $tag->suggest_book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?></td>
    <td>
      @if($tag->status == 0)
      Pending
      @elseif($tag->status == 1)
      Approved
      @elseif($tag->status == 2)
      Disapproved
      @else 
      Cancelled 
      @endif
    </td>

    <td>
    @if($tag->status == 0)
    <div class="flex-parent jc-center">
            <form action="{{ route('accept', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span>Approve</button>
            </form>
 
            <form action="{{ route('decline', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span>Disapprove</button>
            </form>
      </div><br>
      <div class="flex-parent jc-center">        
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
            data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash"></i>Delete</a>
      </div>

    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
            data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash"></i>Delete</a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>
  <!-- Modal -->
<div class="modal fade" id="deleteUserModal_{{$tag->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$tag->book_barcode}}?
               
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
  <li class="list-group-item list-group-item-danger">Entry not found</li>  
@endforelse

<!-- Department Representative -->
@elseif($user->type == 'department representative')
<br>
@forelse($tags as $tag)
  @foreach($users as $user)
    @if($tag->user_id == $user->id)
    <tr align="center">
      <td>{{$user->first_name}} {{$user->last_name}}</td>
      <td>{{$tag->department}}</td>
      <td>{{$tag->book_barcode}}</td>
      <td><?php $t = $tag->suggest_book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?></td>

   
    <td>@if($tag->status == 0)
      Pending
      @elseif($tag->status == 1)
      Approved
      @elseif($tag->status == 2)
      Disapproved
      @else 
      Cancelled 
      @endif</td>

    <td>
    @if($tag->status == 0)
    <div class="flex-parent jc-center">
      <a class="btn btn-primary" href="{{ route('tags.edit', $tag->id) }}" role="button"><span>&#9776;</span>Edit</a>

      <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
      data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash">Delete</a></td>
    </div>

    @else
    <div class="flex-parent jc-center">
      <a data-toggle="modal" class="btn btn-danger" disabled>No Actions Available</a></td>
    </div>
    @endif
  </td>
  </tr>

  <!-- Modal -->
  <div class="modal fade" id="deleteUserModal_{{$tag->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$tag->book_barcode}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  @endif 
@endforeach

@empty
  <li class="list-group-item list-group-item-danger">Entry not found</li>  
  
@endforelse


<!-- STAFF LIBRARIAN -->
@elseif($user->type == 'staff librarian')
<br>
@forelse($tags as $tag)
  @foreach($users as $user)
    @if($tag->user_id == $user->id)
    <tr align="center">
      <td>{{$user->first_name}} {{$user->last_name}}</td>
      <td>{{$tag->department}}</td>
      <td>{{$tag->book_barcode}}</td>
      <td><?php $t = $tag->suggest_book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?></td>

   
    <td>@if($tag->status == 0)
      Pending
      @elseif($tag->status == 1)
      Approved
      @elseif($tag->status == 2)
      Disapproved
      @else 
      Cancelled 
      @endif
    </td>
    <td>

@if($tag->status == 0)
<div class="flex-parent jc-center">
        <form action="{{ route('accept', $tag->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span>Approve</button>
        </form>
</div>

<div class="flex-parent jc-center">
        <form action="{{ route('decline', $tag->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span>Disapprove</button>
        </form>
</div>

<div class="flex-parent jc-center">
        <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
        data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash"></i>Delete</a>
</div>

@else
<div class="flex-parent jc-center">
    
<div class="flex-parent jc-center">
        <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
        data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash"></i>Delete</a>
</div>  
@endif

</td>
  </tr>

  <!-- Modal -->
  <div class="modal fade" id="deleteUserModal_{{$tag->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$tag->book_barcode}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  @endif 
@endforeach

@empty
  <li class="list-group-item list-group-item-danger">Entry not found</li>  
@endforelse
@endif

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $tags->render(); ?>
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

@endsection