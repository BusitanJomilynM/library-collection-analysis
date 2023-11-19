@extends('master_layout.master')
@section('Title', 'Book Subject')
@section('content')

<h2 style="text-align: center;">Pending Subject Suggestion</h2>

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

<a class="btn btn-primary my-2 my-sm-0" href="{{ route('tags.index') }}">Back to list</a> <br><br>

<table class="table table-hover table-bordered" style="width:100%">
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

@forelse($pending2 as $pendingt)
<tbody>
  <tr align="center">
     <td>@foreach($users as $user)
      @if($user->id == $pendingt->user_id)
      {{$user->first_name}} {{$user->last_name}}
      @endif
      @endforeach
    </td>    
    <td>{{$pendingt->department}}</td>
    <td>{{$pendingt->book_barcode}}</td>
    <td>{{$pendingt->suggest_book_subject}} </td>
    <td>
    @if($pendingt->status == 0)
     Pending
    @endif
    </td>

    <td>
    @if($pendingt->status == 0)
    <div class="flex-parent jc-center">
    @foreach($books as $book)
                @if($pendingt->book_barcode == $book->book_barcode)
                
                  @if($pendingt->action == 1)
                    <form action="{{ route('append', ['tag' => $pendingt->id, 'book' => $book->id]) }}" method="POST">
                      @csrf 
                      @method('post')
                      <button type="submit" class="btn btn-success">Append</button>   
                      </form>
                  @else
                    <form action="{{ route('replace', ['tag' => $pendingt->id, 'book' => $book->id]) }}" method="POST">
                      @csrf 
                      @method('post')
                      <button type="submit" class="btn btn-success">Replace</button>  
                      </form>
                  @endif
                @endif
            @endforeach

        <form action="{{ route('decline', $pendingt->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
        </form>

            <!-- <form action="{{ route('accept', $pendingt->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span></button>
            </form>

            <form action="{{ route('decline', $pendingt->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
            </form> -->
      </div>
        
    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingt->id}}"
            data-action="{{ route('tags.destroy', $pendingt->id) }}"><i class="fa fa-trash"></i>Delete</a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>
  <!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal_{{$pendingt->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $pendingt->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$pendingt->book_title}}?
               
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

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $pending2->render(); ?>
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