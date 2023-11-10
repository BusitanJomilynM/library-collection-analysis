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
    <a class="btn btn-primary" type="submit"><i class="fa fa-search"></i></a>
</form>
</div>
<br>

@if($user->type == 'technician librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingRequisitions') }}">Filter Pending Requisitions</a>
@endif

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark" >
  <tr align="center">
    <th>Book Title</th>
    <th>Volume</th>
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
@if($user->type == 'technician librarian')
@forelse($requisitions as $requisition)
<tbody>
  <tr align="center">
    <td>{{$requisition->book_title}}</td>
    <td>{{$requisition->copies}}</td>
    <td>{{$requisition->material_type}}</td>
    <td>{{$requisition->author}}</td>
    <td>{{$requisition->isbn}}</td>
    <td>{{$requisition->publisher}}</td>
    <td>{{$requisition->edition}}</td>
    <td>{{$requisition->source}}</td>
    <td>@foreach($users as $user)
      @if($user->id == $requisition->user_id)
      {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
      @endif
      @endforeach
    </td>
    <td>
      @if($requisition->type == 'technician librarian')
      Technician Librarian
      @elseif($requisition->type == 'staff librarian')
      Staff Librarian
      @elseif($requisition->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$requisition->department}}</td>
    <td>
      @if($requisition->status == 0)
      Pending
      @elseif($requisition->status == 1)
      Approved
      @elseif($requisition->status == 2)
      Disapproved
      @else 
      Cancelled 
      @endif
    </td>

    <td>
    @if($requisition->status == 0)
    <div class="flex-parent jc-center">
            <form action="{{ route('changeStatus', $requisition->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span>Approve</button>
            </form>
    </div>

    <div class="flex-parent jc-center">
            <form action="{{ route('changeStatus2', $requisition->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span>Disapprove</button>
            </form>
    </div>
  <br>
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
            data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i>Delete</a>
    </div>

    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
            data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i>Delete</a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>

  <!-- Modal -->
<div class="modal fade" id="deleteUserModal_{{$requisition->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('requisitions.destroy', $requisition->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$requisition->book_title}}?
               
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


@elseif($user->type == 'department representative')
<a class="btn btn-primary" href="{{ route('requisitions.create') }}">Add New Requisition</a>

@forelse($requisitions as $requisition)
  @foreach($users as $user)
    @if($requisition->user_id == $user->id)

  <tr align="center">
    <td>{{$requisition->book_title}}</td>
    <td>{{$requisition->copies}}</td>
    <td>{{$requisition->material_type}}</td>
    <td>{{$requisition->author}}</td>
    <td>{{$requisition->isbn}}</td>
    <td>{{$requisition->publisher}}</td>
    <td>{{$requisition->edition}}</td>
    <td>{{$requisition->source}}</td>
    <td>
      @foreach($users as $user)
        @if($user->id == $requisition->user_id)
          {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
        @endif
      @endforeach
    </td>
    <td> 
      @if($requisition->type == 'technician librarian')
      Technician Librarian
      @elseif($requisition->type == 'staff librarian')
      Staff Librarian
      @elseif($requisition->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$requisition->department}}</td>
    <td>@if($requisition->status == 0)
      Pending
      @elseif($requisition->status == 1)
      Approved
      @elseif($requisition->status == 2)
      Disapproved
      @else 
      Cancelled 
      @endif</td>
    <td>
      @if($requisition->status == 0)
      <a class="btn btn-primary" href="{{ route('requisitions.edit', $requisition->id) }}" role="button"><span>&#9776;</span>Edit</a>
      <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
      data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i>Delete</a></td>

      @else
      <a data-toggle="modal" class="btn btn-danger" disabled>No Actions Available</a></td>
      @endif
  </tr>


  <!-- Modal -->
  <div class="modal fade" id="deleteUserModal_{{$requisition->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('requisitions.destroy', $requisition->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$requisition->book_title}}?
               
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

<!-- staff librarian -->
@elseif($user->type == 'staff librarian')

@forelse($requisitions as $requisition)
  @foreach($users as $user)
    @if($requisition->user_id == $user->id)

  <tr align="center">
    <td>{{$requisition->book_title}}</td>
    <td>{{$requisition->copies}}</td>
    <td>{{$requisition->material_type}}</td>
    <td>{{$requisition->author}}</td>
    <td>{{$requisition->isbn}}</td>
    <td>{{$requisition->publisher}}</td>
    <td>{{$requisition->edition}}</td>
    <td>{{$requisition->source}}</td>
    <td>
      @foreach($users as $user)
        @if($user->id == $requisition->user_id)
          {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
        @endif
      @endforeach
    </td>
    <td> 
      @if($requisition->type == 'technician librarian')
      Technician Librarian
      @elseif($requisition->type == 'staff librarian')
      Staff Librarian
      @elseif($requisition->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$requisition->department}}</td>
    <td>@if($requisition->status == 0)
      Pending
      @elseif($requisition->status == 1)
      Approved
      @elseif($requisition->status == 2)
      Disapproved 
      @else 
      Cancelled 
      @endif</td>
      <td>
    @if($requisition->status == 0)
    <div class="flex-parent jc-center">
            <form action="{{ route('changeStatus', $requisition->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span>Approve</button>
            </form>
</div>
<div class="flex-parent jc-center">
            <form action="{{ route('changeStatus2', $requisition->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button"><span>&#10005;</span>Disapprove</button>
            </form>
</div>
<br>
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
            data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i>Delete</a>
    </div>

    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
            data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i>Delete</a>
    </div>  
    @endif
  
    </td>
  </tr>


  <!-- Modal -->
  <div class="modal fade" id="deleteUserModal_{{$requisition->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('requisitions.destroy', $requisition->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$requisition->book_title}}?
               
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
      <?php echo $requisitions->render(); ?>
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