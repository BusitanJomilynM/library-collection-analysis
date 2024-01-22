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
      Technical Librarian
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
                {{ method_field('POST') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span></button>
            </form>

            <form action="{{ route('changeStatus2', $pendingr->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#disapproveModal_{{$pendingr->id}}"><span>&#10005;</span></button>
            </form>

           
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

    <!-- Disapprove Modal -->
<div class="modal fade" id="disapproveModal_{{$pendingr->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="disapproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disapproveModalLabel">Disapprove Requisition</h5>
            </div>
            <form action="{{ route('changeStatus2', $pendingr->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }} <!-- Change method to POST -->
                <div class="modal-body">
                    <p>Are you sure you want to disapprove this requisition?</p>
                    <div class="form-group">
                        <label for="reason">Disapproval Reason:</label>
                        <input type="text" class="form-control" id="disapproval_reason" name="disapproval_reason" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="file_upload">Upload Disapproval Document:</label>
                        <input type="file" class="form-control-file" id="file_upload" name="file_upload" accept=".pdf, .doc, .docx" >
                    </div>   -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Disapprove</button>
                </div>
            </form>
        </div>
    </div>
</div>

@empty
<tr align="center"> <td colspan="13"><h3>No Pending Requisition</h3></td></tr> 
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