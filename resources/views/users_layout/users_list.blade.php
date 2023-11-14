@extends('master_layout.master')
@section('Title', 'Users')
@section('content')
<h2 style="text-align: center;">Users</h2>
<div class="panel panel-default">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>

<div>
<form style="margin:auto;max-width:300px">
    <input type="text" class="form-control mr-sm-2" placeholder="Search Users" name="search"  value="{{ request('search') }}">
    <button type="submit" class="btn btn-danger">
    <i class="fa fa-search"></i>
    </button>
</form>
</div>

<!-- <a class="btn btn-primary" href="{{ route('users.create') }}"><span>&#43;</span> Create New User</a>  -->

<a data-toggle="modal" class="btn btn-primary" data-target="#createUserModal"><span>&#43;</span></i> Create New User</a>
<br><br>


<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>School ID Number</th>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Contact Number</th>
    <th>Role</th>
    <th>Actions</th>
  </tr>
</thead>
@forelse($users as $user)
<tbody>
  <tr align="center">
    <td>{{$user->school_id}}</td>
    <td>{{$user->first_name}}</td>
    <td>{{$user->middle_name}}</td>
    <td>{{$user->last_name}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->contact_number}}</td>
    <td>
    @if($user->type == 'technician librarian')  
      Technician Librarian
    @elseif($user->type == 'staff librarian')
      Staff  Librarian
    @elseif($user->type == 'department representative')
      Department Representative
    @endif</td>
    <td>
    <div class="btn-group">
        <a data-toggle="modal" class="btn btn-primary" data-target="#editUserModal_{{$user->id}}" data-action="{{ route('users.edit', $user->id) }}"><span>&#9776;</span> </a>
        <a class="btn btn-success" href="{{ route('restorePassword', $user->id) }}" role="button"><span>&#9733;</span></a>

        @if($user->type == 'technician librarian')  
            @if($techcount>1 && $user->id != $userId)
                <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$user->id}}" data-action="{{ route('confirmDestroy', $user->id) }}"><i class="fa fa-trash"></i></a>
            @else
                <!-- Handle the case where $techcount is not greater than 1 or $user->id is equal to $userId -->
            @endif
        @else
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$user->id}}" data-action="{{ route('users.destroy', $user->id) }}"><i class="fa fa-trash"></i> </a>
        @endif
    </div>
</td>
  </tr>
</tbody>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal_{{$user->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this user?</h5>
      </div>
        <form action="{{ route('confirmDestroy', $user->id) }}" method="POST">
          <div class="modal-body">
            {{ csrf_field() }}
              Enter password to confirm account deletion 
                <input type="password" class="form-control" name="password" required>
                <input type="hidden" name="id" value="{{$user->id}}">
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
    </div>
  </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createUserModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Create New User</h5>
      </div>
        <form action="{{ route('users.store') }}" method="POST">
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="three-col">
    <div class="col1">
        <label>First Name</label>
        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name"  minlength="2" maxlength="30" required> 
        @error('first_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Middle Name</label>
            <input class="form-control" type="text" name="middle_name" id="middle_name" minlength="2" maxlength="30" >
    </div>

    <div class="col3">
        <label>Last Name</label>
        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" minlength="2" maxlength="30" required>
        @error('last_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<br>
    <div class="form-group">
        <label>ID Number</label>
        <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" type="text" pattern="\d*" minlength="8" maxlength="8" required>
        @error('school_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" required>
        @error('email')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Contact Number</label>
        <input class="form-control @error('email') is-invalid @enderror" type="text" name="contact_number" id="contact_number"  pattern="\d*" minlength="12" maxlength="12" placeholder="639XX-XXX-XXXX" required>
        @error('contact_number')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
    <div class="form-group">
        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" minlength="8" maxlength="25" hidden>
        @error('password')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Role</label>
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
            <option value="">--Select Role--</option>
            <option value="0">Technician Librarian</option>
            <option value="1">Staff Librarian</option>
            <option value="2">Department Representative</option>
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal_{{$user->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
      </div>
      <form action="{{ route('users.update', $user->id) }}" method="POST">
          <div class="modal-body">
          @csrf
    @method('PUT')
    <div class="form-group">

            <input class="form-control" type="text" name="id" id="id" value="{{$user->id}}" hidden>
    </div>
    <div class="three-col">
    <div class="col1">
        <label>First Name</label>
        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name" value="{{$user->first_name}}" minlength="2" maxlength="30" required>
        @error('first_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Middle Name</label>
            <input class="form-control" type="text" name="middle_name" id="middle_name" value="{{$user->middle_name}}" minlength="2" maxlength="30">
        </div>

    <div class="col3">
        <label>Last Name</label>
        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" value="{{$user->last_name}}" minlength="2" maxlength="30" required>
        @error('last_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<br>

    <div class="form-group">
        <label>ID Number</label>
        <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" value="{{$user->school_id}}" type="text" pattern="\d*" minlength="8" maxlength="8" required>
        @error('school_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

<div class="two-col">
    <div class="col1">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{$user->email}}" required>
        @error('email')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col2">
        <label>Contact Number</label>
        <input class="form-control @error('contact_number') is-invalid @enderror" type="text" name="contact_number" id="contact_number" value="{{$user->contact_number}}" pattern="\d*" minlength="12" maxlength="12" placeholder="639XX-XXX-XXXX" required>
        @error('contact_number')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<br>
    <div class="form-group">
        <label>Role</label>
            <select class="form-control" name="type" id="type" value="{{$user->type}}" required>
                <option value="0" {{ old('type') == "technicna librarian" || $user->type == "technicna librarian" ? 'selected' : '' }}>Technician Librarian</option>
                <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Staff Librarian</option>
                <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Department Representative</option>
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

.three-col {
    overflow: hidden;/* Makes this div contain its floats */
}

.three-col .col1,
.three-col .col2,
.three-col .col3 {
    width: 32%;
}

.three-col .col1 {
    float: left;
}
.three-col .col2 {
    display: block;
    display: inline-block;
   
    float: left;
     margin-left: 10px;
}
.three-col .col3 {
    float: right;
}

.three-col label {
    display: block;
}

.two-col {
    overflow: hidden;/* Makes this div contain its floats */
}

.two-col .col1,
.two-col .col2 {
    width: 49%;
}

.two-col .col1 {
    float: left;
}

.two-col .col2 {
    float: right;
}

.two-col label {
    display: block;
}




</style>
@endsection