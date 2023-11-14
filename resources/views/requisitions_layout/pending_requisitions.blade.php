@extends('master_layout.master')
@section('Title', 'Book Requisitions')
@section('content')

<h2 style="text-align: center;">Book Requisitions</h2>

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

<a class="btn btn-primary my-2 my-sm-0" href="{{ route('requisitions.index') }}">Back to list</a><br><br>

<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Number of Copies</th>
    <th>Material Type</th>
    <th>Author</th>
    <th>ISBN</th>
    <th>Publisher</th>
    <th>Edition/Year</th>
    <th>Source</th>
    <th>Requested By</th>
    <th>Role</th>
    <th>Department</th>
    <th>Status</th>
    <th>Actions</th>
  </tr>
</thead>

@forelse($pending as $pendingr)
<tbody>
  <tr align="center">
    <td>{{$pendingr->book_title}}</td>
    <td>{{$pendingr->copies}}</td>
    <td>{{$pendingr->material_type}}</td>
    <td>{{$pendingr->author}}</td>
    <td>{{$pendingr->isbn}}</td>
    <td>{{$pendingr->publisher}}</td>
    <td>{{$pendingr->edition}}</td>
    <td>{{$pendingr->source}}</td>
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
  

    <!-- Accept/Decline-->
    <div class="flex-parent jc-center">
    <form action="{{ route('changeStatus', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span></button>
            </form>
   

    
            <form action="{{ route('changeStatus2', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
            </form>

            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingr->id}}"
            data-action="{{ route('requisitions.destroy', $pendingr->id) }}"><i class="fa fa-trash"></i></a>
    </div>
        
        
       

    @else
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingr->id}}"
            data-action="{{ route('requisitions.destroy', $pendingr->id) }}"><i class="fa fa-trash"></i></a>
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
          <form action="{{ route('requisitions.destroy', $pendingr->id) }}" method="POST">
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
  <li class="list-group-item list-group-item-danger">No Pending Requisitions</li>  
@endforelse

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $pending->render(); ?>
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