@extends('master_layout.master')
@section('Title', 'Home')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header text-white" style="background-color: black">{{ __('Dashboard') }}</div>
                <div class="card-body">

                Welcome, Teacher {{$user->first_name}} {{$user->last_name}}. 

            

                <div class="float-container">
                    <div class="float-child">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                            <a class="btn btn-danger" href="{{ route('requisitions.index') }}">Create New Requisition</a>   
                            </div>
                        </div>
                    </div>
                    <div class="float-child">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                                <a class="btn btn-danger" href="{{ route('books.index') }}">Create Subject Request</a>   
                            </div>
                        </div>
                    </div>
                </div>
             </div>    
        </div>
    </div>
</div>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Edit Acount</h5>
        </div>
      <form action="{{ route('users.update', Auth::user()->id) }}" method="POST">
          <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
                    <input class="form-control" type="text" name="id" id="id" value="{{Auth::user()->id}}" hidden>
            </div>

            <div class="form-group">
                <label>First Name</label>
                <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" minlength="2" maxlength="30" readonly> 
                @error('first_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Middle Name</label>
                    <input class="form-control" type="text" name="middle_name" id="middle_name" value="{{Auth::user()->middle_name}}" minlength="2" maxlength="30" readonly>
                </div>

                <div class="form-group">
                <label>Last Name</label>
                <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" minlength="2" maxlength="30" readonly>
                @error('last_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>


            <div class="form-group">
                <label>ID Number</label>
                <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" value="{{Auth::user()->school_id}}" type="text" pattern="\d*" minlength="8" maxlength="8" readonly>
                @error('school_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{Auth::user()->email}}">
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input class="form-control @error('contact_number') is-invalid @enderror" type="text" name="contact_number" id="contact_number" value="{{Auth::user()->contact_number}}" pattern="\d*" minlength="11" maxlength="11" placeholder="09XX-XXX-XXXX">
                @error('contact_number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                    <select class="form-control" name="type" id="type" value="{{Auth::user()->type}}" hidden>
                        <option value="0" {{ old('type') == "technicna librarian" || $user->type == "technicna librarian" ? 'selected' : '' }}>Technician Librarian</option>
                        <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Staff Librarian</option>
                        <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Department Representative</option>
                        <option value="3" {{ old('type') == "teacher" || $user->type == "teacher" ? 'selected' : '' }}>Teacher</option>

                    </select>
            </div>
          
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
        </form>
    </div>
  </div>
</div>

</div>
<!-- Edit Password Modal -->
<div class="modal fade" id="editPasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPasswordModalLabel">Change Password</h5>
        </div>
      <form action="{{ route('users.update', Auth::user()->id) }}" method="POST">
          <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input class="form-control" type="text" name="id" id="id" value="{{Auth::user()->id}}" hidden>
            </div>
            <div class="form-group">
                <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" minlength="2" maxlength="30" hidden> 
                @error('first_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="middle_name" id="middle_name" value="{{Auth::user()->middle_name}}" minlength="2" maxlength="30" hidden>
            </div>

            <div class="form-group">
                <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" minlength="2" maxlength="30" hidden>
                @error('last_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <input class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school_id" value="{{Auth::user()->school_id}}" type="text" pattern="\d*" minlength="8" maxlength="8" hidden>
                @error('school_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{Auth::user()->email}}" hidden>
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <input class="form-control @error('contact_number') is-invalid @enderror" type="text" name="contact_number" id="contact_number" value="{{Auth::user()->contact_number}}" pattern="\d*" minlength="12" maxlength="12" hidden>
                @error('contact_number')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                    <select class="form-control" name="type" id="type" value="{Auth::user()->type}}" hidden>
                        <option value="0" {{ old('type') == "technician librarian" || $user->type == "technician librarian" ? 'selected' : '' }}>Technical Librarian</option>
                        <option value="1" {{ old('type') == "staff librarian" || $user->type == "staff librarian" ? 'selected' : '' }}>Staff Librarian</option>
                        <option value="2" {{ old('type') == "department representative" || $user->type == "department representative" ? 'selected' : '' }}>Department Representative</option>
                        <option value="3" {{ old('type') == "teacher" || $user->type == "teacher" ? 'selected' : '' }}>Teacher</option>

                    </select>
            </div>

            <div class="form-group">
            <label>New Password</label>
                <input class="form-control" type="password" name="password" id="password" required>
            </div>

            
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>

<style>
.float-container {
    border: 3px solid #fff;
    padding: 20px;
}

.float-child {
    width: 50%;
    float: left;
    padding: 20px;
   
}
</style>

@endsection