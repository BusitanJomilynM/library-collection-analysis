@extends('master_layout.master')
@section('Title', 'Users')
@section('content')
<h2 style="text-align: center;">Users</h2>

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
    <input type="text" class="form-control mr-sm-2" placeholder="Search Users" name="search"  value="{{ request('search') }}">
    <input class="button btn-primary my-2 my-sm-0" type="submit" value="Search">
</form>
</div>

<a class="btn btn-primary" href="{{ route('users.create') }}">Create New User</a>
<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>ID</th>
    <th>School ID Number</th>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Actions</th>
  </tr>
</thead>
@forelse($users as $user)
<tbody>
  <tr align="center">
    <td>{{$user->id}}</td>
    <td>{{$user->school_id}}</td>
    <td>{{$user->first_name}}</td>
    <td>{{$user->middle_name}}</td>
    <td>{{$user->last_name}}</td>
    <td>{{$user->email}}</td>
    <td>
    @if($user->type == 'technician librarian')  
      Technician Librarian
    @elseif($user->type == 'staff librarian')
      Staff  Librarian
    @elseif($user->type == 'department representative')
      Department Representative
    @endif</td>
    <td><a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}" role="button">Edit</a>
    <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$user->id}}"
              data-action="{{ route('users.destroy', $user->id) }}">Delete</a>
    </td>
  </tr>
</tbody>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal_{{$user->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this user?</h5>
            
          </div>
          <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete user {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}} ?
               
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
</table>
<div class="d-flex">
    <div class="mx-auto">
<?php echo $users->render(); ?>
  </div>
</div>

<style> 
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}
</style>
@endsection