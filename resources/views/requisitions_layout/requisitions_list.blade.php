@extends('master_layout.master')
@section('Title', 'Material Requisitions')
@section('content')
<h2 style="text-align: center;">Material Requisitions</h2>

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
<br>

<div>
<form style="margin:auto;max-width:300px">
  <select class="form-control mr-sm-2" name="department" id="department" value="{{ request('department') }}">
    <option value="">Filter By Department</option>
            <option value="SBAA">SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD">SOD - School of Dentistry</option>
            <option value="SIT">SIT - School of Information Technology</option>
            <option value="SIHTM">SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA">SEA - School of Engineering & Architecture</option>
            <option value="SCJPS">SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL">SOL - School of Law</option>
            <option value="SNS">SNS - School of Natural Sciences</option>
            <option value="SON">SON - School of Nursing</option>
            <option value="STELA">STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School">Graduate School</option>
  </select>
  <button type="submit" class="btn btn-danger">Filter</button>
</form>
</div>

@if($user->type == 'technician librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingRequisitions') }}">Filter Pending Requisitions</a><br><br>
@endif

<table class="table table-hover table-bordered" style="width:100%">
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
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span></button>
            </form>

            <form action="{{ route('changeStatus2', $requisition->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
            </form>
    </div>

  </div>
    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
            data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i></a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>

  <!-- Delete Modal -->
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
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
@endforelse


@elseif($user->type == 'department representative')
<!-- <a class="btn btn-primary" href="{{ route('requisitions.create') }}">Add New Requisition</a><br><br> -->
<a data-toggle="modal" class="btn btn-primary" data-target="#createReqModal"><span>&#43;</span></i> Create New Requisition</a> <br><br>

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
      <!-- <a class="btn btn-primary" href="{{ route('requisitions.edit', $requisition->id) }}" role="button"><span>&#9776;</span>Edit</a> -->

      <a data-toggle="modal" class="btn btn-primary" data-target="#editReqModal_{{$requisition->id}}"
      data-action="{{ route('requisitions.edit', $requisition->id) }}"><span>&#9776;</span>Edit</a>
  
      <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
      data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i></a>
    </td>
</div>
      @else
      <a data-toggle="modal" class="btn btn-danger" disabled>No Actions Available</a></td>
      @endif
  </tr>




    <!-- Delete Modal -->
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

<!-- Edit req -->
<div class="modal fade" id="editReqModal_{{$requisition->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Edit</h5>
            
          </div>
          <form action="{{ route('requisitions.update', $requisition->id) }}" method="POST">
            <div class="modal-body">
            @csrf
    @method('PUT')
    <div class="form-group">
        <label>Book Name</label>
        <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{$requisition->book_title}}" minlength="1" maxlength="60" required>
        @error('book_title')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Number of Copies</label>
        <input class="form-control @error('copies') is-invalid @enderror" type="text" pattern="\d*" minlength="1" maxlength="3" name="copies" id="copies" value="{{$requisition->copies}}" required>
        @error('copies')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Material Type</label>
        <input class="form-control @error('material_type') is-invalid @enderror" type="text" name="material_type" id="material_type" value="{{$requisition->material_type}}" required>
        @error('material_type')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('author') is-invalid @enderror" type="text" name="author" id="author" value="{{$requisition->author}}" minlength="2" maxlength="40" required>
        @error('author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ISBN</label>
        <input class="form-control @error('material_type') is-invalid @enderror" type="text" name="isbn" id="isbn" value="{{$requisition->isbn}}" minlength="2" maxlength="25" required>
        @error('isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control @error('publisher')is-invalid @enderror" type="text" name="publisher" id="publisher" value="{{$requisition->publisher}}" minlength="2" maxlength="25" required>
        @error('publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Edition/Year</label>
        <input class="form-control @error('edition') is-invalid @enderror" type="text" pattern="\d*" minlength="4" maxlength="4" name="edition" id="edition" value="{{$requisition->edition}}" required>
        @error('edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Source</label>
        <input class="form-control @error('source') is-invalid @enderror" type="text" name="source" id="source" value="{{$requisition->source}}" minlength="2" maxlength="25" required>
        @error('source')
            <span class="text-danger">{{$message}}</span>
        @enderror</div>

    <div class="form-group">
    
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 

    </div>

    <div class="form-group">
       
        <input class="form-control" type="text" name="type" id="type" value="{{$user->type}}" hidden>
    </div>

    <div class="form-group">
        <label>Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" value="{{$requisition->department}}" required> 
            <option value="SBAA" {{ old('department') == "SBAA" || $requisition->department == "SBAA" ? 'selected' : '' }}>SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD" {{ old('department') == "SOD" || $requisition->department == "SOD" ? 'selected' : '' }}>SOD - School of Dentistry</option>
            <option value="SIT" {{ old('department') == "SIT" || $requisition->department == "SIT" ? 'selected' : '' }}>SIT - School of Information Technology</option>
            <option value="SIHTM" {{ old('department') == "SIHTM" || $requisition->department == "SIHTM" ? 'selected' : '' }}>SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA" {{ old('department') == "SEA" || $requisition->department == "SEA" ? 'selected' : '' }}>SEA - School of Engineering & Architecture</option>
            <option value="SCJPS" {{ old('department') == "SCJPS" || $requisition->department == "SCJPS" ? 'selected' : '' }}>SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL" {{ old('department') == "SOL" || $requisition->department == "SOL" ? 'selected' : '' }}>SOL - School of Law</option>
            <option value="SNS" {{ old('department') == "SNS" || $requisition->department == "SNS" ? 'selected' : '' }}>SNS - School of Natural Sciences</option>
            <option value="SON" {{ old('department') == "SON" || $requisition->department == "SON" ? 'selected' : '' }}>SON - School of Nursing</option>
            <option value="STELA" {{ old('department') == "STELA" || $requisition->department == "STELA" ? 'selected' : '' }}>STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School" {{ old('department') == "Graduate School" || $requisition->department == "Graduate School" ? 'selected' : '' }}>Graduate School</option>
            </select>   
            @error('department')
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

  @endif
@endforeach
   
@empty
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
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
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span></button>
            </form>
   
            <form action="{{ route('changeStatus2', $requisition->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
            </form>
    </div>

    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$requisition->id}}"
            data-action="{{ route('requisitions.destroy', $requisition->id) }}"><i class="fa fa-trash"></i></a>
    </div>  
    @endif
  
    </td>
  </tr>

  <!-- Delete Modal -->
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
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 

  
@endforelse



@endif

<div>
  <!-- Create Modal -->
<div class="modal fade" id="createReqModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="createReqModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createReqModalLabel">Create New Requisition</h5>
          </div>
          <form action="{{ route('requisitions.store') }}" method="POST">
            <div class="modal-body">
              @csrf
              <div class="form-group">
               <label>Book Name</label>
                <input class="form-control @error('book_title') is-invalid @enderror" type="text" name="book_title" id="book_title" value="{{ old('book_title') }}" minlength="1" maxlength="60" required>
                @error('book_title')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                  <label>Number of Copies</label>
                  <input class="form-control @error('copies') is-invalid @enderror"  type="number" pattern="\d*" minlength="1" maxlength="60" name="copies" id="copies" value="{{ old('copies') }}" required>
                  @error('copies')
                      <span class="text-danger">{{$message}}</span>
                  @enderror
            </div>


    <div class="form-group">
      <label for="material_type">Material Type</label>
        <select class="form-control @error('material_type') is-invalid @enderror" name="material_type" id="material_type" required>
          <option value="">--Select Material Type--</option>
          <option value="Book">Book</option>
          <option value="JournalMagazine">Journal/Magazine</option>
          <option value="DocumentaryFilm">Documentary Film</option>
          <option value="DVDVCD">DVD/VCD</option>
          <option value="MapsGlobes">Maps/Globes</option>
        </select>

    </div>
  
    <div class="form-group">
        <label>Author</label>
        <input class="form-control @error('author') is-invalid @enderror" type="text" name="author" id="author" value="{{ old('author') }}"  minlength="2" maxlength="40" required>
        @error('author')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>ISBN</label>
        <input class="form-control @error('material_type') is-invalid @enderror" type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"  minlength="2" maxlength="25" required>
        @error('isbn')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control @error('publisher') is-invalid @enderror" type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"  minlength="2" maxlength="25" required>
        @error('publisher')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Edition/Year</label>
        <input class="form-control @error('edition') is-invalid @enderror" type="text" pattern="\d*" minlength="4" maxlength="4" name="edition" id="edition" value="{{ old('edition') }}" required>
        @error('edition')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Source</label>
        <input class="form-control @error('source') is-invalid @enderror" type="text" name="source" id="source" value="{{ old('source') }}"  minlength="2" maxlength="25" required>
        @error('source')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group">
     
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
 
    </div>

    <div class="form-group">
        
        <input class="form-control" type="text" name="type" id="type" value="{{$user->type}}" hidden>
    </div>

    <div class="form-group">
        <label>Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" required>
            <option value="">--Select Department--</option>
            <option value="SBAA">SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD">SOD - School of Dentistry</option>
            <option value="SIT">SIT - School of Information Technology</option>
            <option value="SIHTM">SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA">SEA - School of Engineering & Architecture</option>
            <option value="SCJPS">SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL">SOL - School of Law</option>
            <option value="SNS">SNS - School of Natural Sciences</option>
            <option value="SON">SON - School of Nursing</option>
            <option value="STELA">STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School">Graduate School</option>
            
            </select>
            @error('department')
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
</div>


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

.three-col .col1,
.three-col .col2,
.three-col .col3 {
    width: 33%;
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
</style>


@endsection