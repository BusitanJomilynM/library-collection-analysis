@extends('master_layout.master')
@section('Title', 'Subject Suggestions')
@section('content')
<h2 style="text-align: center;">Subject Suggestions</h2>

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

@if($user->type == 'technician librarian' || 'staff librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingTags') }}">Filter Pending Subject Request</a> 
@endif

@if($user->type == 'technician librarian') 
<br>
@endif

<br>
<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Requested by</th>
    <th>Department</th>
    <th>Book Barcode</th>
    <th>Current Tags</th>
    <th>Suggested Tags</th>
    <th>Suggested Action</th>
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
    <td>@foreach($books as $book)
@if($book->book_barcode == $tag->book_barcode)
<?php  
                        $x = $book->book_subject;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($subjects as $subject){
                            foreach ($words as  $key => $word) {
                                if( $word == $subject->id){
                                echo $subject->subject_name;
                                echo '<br>'; }
                                // if ($key < $count - 1) {
                                //     echo " ,";
                                //   } 
                                // }
                            }
                        }
                   
                        ?>
@endif
    @endforeach</td>
    <td> <?php  
                        $x = $tag->suggest_book_subject;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($subjects as $subject){
                            foreach ($words as  $key => $word) {
                                if( $word == $subject->id){
                                echo $subject->subject_code;
                                echo '<br>';
                                // if ($key < $count - 1) {
                                //     echo " ,";
                                //   } 
                                }
                            }
                        }
                   
                        ?></td>
    <td>
      @if($tag->action == 1)
      Append
      @elseif($tag->action == 2)
      Replace
      @endif
    </td>
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
            <!-- <form action="{{ route('accept', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button"><span>&#10003;</span></button>
            </form> -->
            @foreach($books as $book)
                @if($tag->book_barcode == $book->book_barcode)
                
                  @if($tag->action == 1)
                    <form action="{{ route('append', ['tag' => $tag->id, 'book' => $book->id]) }}" method="POST">
                      @csrf 
                      @method('post')
                      <button type="submit" class="btn btn-success">Append</button>   
                      </form>
                  @else
                    <form action="{{ route('replace', ['tag' => $tag->id, 'book' => $book->id]) }}" method="POST">
                      @csrf 
                      @method('post')
                      <button type="submit" class="btn btn-success">Replace</button>  
                      </form>
                  @endif
                @endif
            @endforeach
 
            <form action="{{ route('decline', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
            </form>
          
          
          </td>
      </div>


           
    @else
    <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
            data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash"></i></a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>

  <!-- delete Modal -->
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
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
@endforelse

<!-- Department Representative & Teacher -->
@elseif($user->type == 'department representative' || $user->type == 'teacher')
<br>
@forelse($tags as $tag)
  @foreach($users as $user)
    @if($tag->user_id == $user->id)
    <tr align="center">
      <td>{{$user->first_name}} {{$user->last_name}}</td>
      <td>{{$tag->department}}</td>
      <td>{{$tag->book_barcode}}</td>
      <td>
@foreach($books as $book)
@if($book->book_barcode == $tag->book_barcode)
                        <?php  
                        $x = $book->book_subject;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($subjects as $subject){
                            foreach ($words as  $key => $word) {
                                if( $word == $subject->id){
                                echo $subject->subject_code;
                                echo '<br>'; }
                                // if ($key < $count - 1) {
                                //     echo " ,";
                                //   } 
                                // }
                            }
                        }
                   
                        ?>
@endif
@endforeach</td>
    
<td>
                        <?php  
                        $x = $tag->suggest_book_subject;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($subjects as $subject){
                            foreach ($words as  $key => $word) {
                                if( $word == $subject->id){
                                echo $subject->subject_code;
                                echo '<br>';}
                                // if ($key < $count - 1) {
                                //     echo " ,";
                                //   } 
                                // }
                            }
                        }
                   
                        ?>
</td>
<td>
      @if($tag->action == 1)
      Append
      @elseif($tag->action == 2)
      Replace
      @endif
    </td>
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
      <!-- <a class="btn btn-primary" href="{{ route('tags.edit', $tag->id) }}" role="button"><span>&#9776;</span>Edit</a> -->

      <a data-toggle="modal" class="btn btn-primary" data-target="#editTagModal_{{$tag->id}}" data-action="{{ route('tags.edit', $tag->id) }}"><span>&#9776;</span> </a>

      <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
      data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash">Delete</a></td>
    </div>

    @else
    <div class="flex-parent jc-center">
    <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
      data-action="{{ route('tags.destroy', $tag->id) }}"><i class="fa fa-trash">Delete</a></td>
    </div>
    @endif
  </td>
  </tr>

  <!-- Delete Modal -->
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

    <!-- Edit Tag Modal -->
<div class="modal fade" id="editTagModal_{{$tag->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editTagModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Edit Tag Request</h5>
      </div>
      <form action="{{ route('tags.update', $tag->id) }}" method="POST">
          <div class="modal-body">
          @csrf
    @method('PUT')

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{$user->id}}" hidden> 
        <input class="form-control" type="string" value="{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}" readonly>
    </div>

    <div class="form-group">
        <label>Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" value="{{$tag->department}}" required>
            <option value="SBAA" {{ old('department') == "SBAA" || $tag->department == "SBAA" ? 'selected' : '' }}>SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD" {{ old('department') == "SOD" || $tag->department == "SOD" ? 'selected' : '' }}>SOD - School of Dentistry</option>
            <option value="SIT" {{ old('department') == "SIT" || $tag->department == "SIT" ? 'selected' : '' }}>SIT - School of Information Technology</option>
            <option value="SIHTM" {{ old('department') == "SIHTM" || $tag->department == "SIHTM" ? 'selected' : '' }}>SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA" {{ old('department') == "SEA" || $tag->department == "SEA" ? 'selected' : '' }}>SEA - School of Engineering & Architecture</option>
            <option value="SCJPS" {{ old('department') == "SCJPS" || $tag->department == "SCJPS" ? 'selected' : '' }}>SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL" {{ old('department') == "SOL" || $tag->department == "SOL" ? 'selected' : '' }}>SOL - School of Law</option>
            <option value="SNS" {{ old('department') == "SNS" || $tag->department == "SNS" ? 'selected' : '' }}>SNS - School of Natural Sciences</option>
            <option value="SON" {{ old('department') == "SON" || $tag->department == "SON" ? 'selected' : '' }}>SON - School of Nursing</option>
            <option value="STELA" {{ old('department') == "STELA" || $tag->department == "STELA" ? 'selected' : '' }}>STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School" {{ old('department') == "Graduate School" || $tag->department == "Graduate School" ? 'selected' : '' }}>Graduate School</option>
            </select>   
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror 
    </div>    

    <div class="form-group">
    <label>Current Tags</label>
    <input class="form-control @error('suggest_book_subject') is-invalid @enderror" type="text" name="book_subject" id="book_subject" value="{{($book->book_subject) }}" readonly>
    </div>
    
    <div class="form-group">
        <label>Suggested Subject</label>
        <input class="form-control @error('suggest_book_subject') is-invalid @enderror" type="text" name="suggest_book_subject" id="suggest_book_subject" value="{{($tag->suggest_book_subject) }}" minlength="1" maxlength="60" required>
        @error('suggest_book_subject')
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
      <td>@foreach($books as $book)
@if($book->book_barcode == $tag->book_barcode)
<?php  
                        $x = $book->book_subject;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($subjects as $subject){
                            foreach ($words as  $key => $word) {
                                if( $word == $subject->id){
                                echo $subject->subject_code;
                                echo '<br>';}
                                // if ($key < $count - 1) {
                                //     echo " ,";
                                //   } 
                                // }
                            }
                        }
                   
                        ?>
@endif
    @endforeach</td>
      <td> <?php  
                        $x = $tag->suggest_book_subject;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($subjects as $subject){
                            foreach ($words as  $key => $word) {
                                if( $word == $subject->id){
                                echo $subject->subject_code;
                                echo '<br>';
                                }
                                // if ($key < $count - 1) {
                                //     echo " ,";
                                //   } 
                                // }
                            }
                        }
                   
                        ?></td>

<td>
      @if($tag->action == 1)
      Append
      @elseif($tag->action == 2)
      Replace
      @endif
    </td>
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
          @foreach($books as $book)
                @if($tag->book_barcode == $book->book_barcode)
                
                  @if($tag->action == 1)
                    <form action="{{ route('append', ['tag' => $tag->id, 'book' => $book->id]) }}" method="POST">
                      @csrf 
                      @method('post')
                      <button type="submit" class="btn btn-success">Append</button>   
                      </form>
                  @else
                    <form action="{{ route('replace', ['tag' => $tag->id, 'book' => $book->id]) }}" method="POST">
                      @csrf 
                      @method('post')
                      <button type="submit" class="btn btn-success">Replace</button>  
                      </form>
                  @endif
                @endif
            @endforeach

        <form action="{{ route('decline', $tag->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
        </form>

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
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
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