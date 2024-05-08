@extends('master_layout.master')
@section('Title', 'Keywords Suggestion')
@section('content')
<h2 style="text-align: center;">Keyword Suggest</h2>

<div class="panel panel-default">
@if (session('success'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {{ session('success') }}
</div>
@endif
</div>

<div style="margin:auto;max-width:300px">
    <form class="form-inline">
        <div class="input-group">
            <input type="text" class="form-control mr-sm-2" placeholder="Search Books" name="search" value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>


<br>
<div style="margin:auto;max-width:300px">
<form class="form-inline">
<div class="input-group">
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
</div>
</form>
</div>

<br>

<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Requested by</th>
    <th>Department</th>
    <th>Book Barcode</th>
    <th>Current Keyword/s</th>
    <th>Suggested Keyword/s</th>
    <th>Suggested Action</th>
    <th>Status</th>
    <th>Actions</th>
  </tr>
</thead>

@if(Auth::user()->type == 'department representative' || Auth::user()->type == 'teacher') 
@forelse($keywordsuggest as $kws)
<tbody>
@if($kws->user_id == Auth::user()->id)
    <tr align="center">
        <td>@foreach($users as $user)
            @if($user->id == $kws->user_id)
                {{$user->first_name}} {{$user->last_name}}
            @endif
            @endforeach</td>
        <td>{{$kws->department}}</td>
        <td>{{$kws->book_barcode}}</td>
        <td>@foreach($books as $book)
                @if($book->book_barcode == $kws->book_barcode)
                <?php  
                        $x = $book->book_keyword;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($keywords as $keyword){
                            foreach ($words as  $key => $word) {
                                if( $word == $keyword->id){
                                echo $keyword->keyword;
                                echo '<br>'; 
                                }
                                                // if ($key < $count - 1) {
                                                //     echo " ,";
                                                //   } 
                                                // }
                            }
                        }
                                
                ?>
                @endif
            @endforeach
        </td>
        <td><?php  
                        $x = $kws->suggest_book_keyword;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($keywords as $keyword){
                            foreach ($words as  $key => $word) {
                                if( $word == $keyword->id){
                                echo $keyword->keyword;
                                echo '<br>'; 
                                }
                            }
                        }
            ?>
        </td>
        <td>
            @if($kws->action == 1)
            Append
            @elseif($kws->action == 2)
            Replace
            @endif
            </td>
            <td>
            @if($kws->status == 0)
            Pending
            @elseif($kws->status == 1)
            Approved
            @elseif($kws->status == 2)
            Disapproved
            @else 
            Cancelled 
            @endif
        </td>
      
       <td>
            @if($kws->status == 0)
            <div class="flex-parent jc-center">
            <a data-toggle="modal" class="btn btn-primary" data-target="#editTagModal_{{$kws->id}}" data-action="{{ route('keywordsuggest.edit', $kws->id) }}"><span>&#9776;</span> </a>

                <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$kws->id}}"
                data-action="{{ route('keywordsuggest.destroy', $kws->id) }}"><i class="fa fa-trash"></a></td>
            </div>

            @else
            <div class="flex-parent jc-center">
            <form action="{{ route('declinekeyword', $kws->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <!-- <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button> -->
                        <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$kws->id}}"
                data-action="{{ route('keywordsuggest.destroy', $kws->id) }}"><i class="fa fa-trash"></a></td>

                    </form>
            </div>
            @endif
        </td>
    </tr>

    
<!-- Delete -->
<div class="modal fade" id="deleteUserModal_{{$kws->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('keywordsuggest.destroy', $kws->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('GET')
              <h5 class="text-center">Delete request for {{$kws->book_barcode}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>

<!-- Edit Keyword Request Modal -->
<div class="modal fade" id="editTagModal_{{$kws->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editTagModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Edit Keyword Request</h5>
      </div>
      <form action="{{ route('keywordsuggest.update', $kws->id) }}" method="POST">
          <div class="modal-body">
          @csrf
    @method('PUT')

    <div class="form-group">
        <label>Requested By</label>
        <input class="form-control" type="number" name="user_id" id="user_id" value="{{Auth::user()->id}}" hidden> 
        <input class="form-control" type="string" value="{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}" readonly>
    </div>

    <div class="form-group">
        <label class="required">Department</label>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" value="{{$kws->department}}" required>
            <option value="SBAA" {{ old('department') == "SBAA" || $kws->department == "SBAA" ? 'selected' : '' }}>SBAA - School of Business Administration & Accountancy</option>
            <option value="SOD" {{ old('department') == "SOD" || $kws->department == "SOD" ? 'selected' : '' }}>SOD - School of Dentistry</option>
            <option value="SIT" {{ old('department') == "SIT" || $kws->department == "SIT" ? 'selected' : '' }}>SIT - School of Information Technology</option>
            <option value="SIHTM" {{ old('department') == "SIHTM" || $kws->department == "SIHTM" ? 'selected' : '' }}>SIHTM - School of International Tourism and Hospitality</option>
            <option value="SEA" {{ old('department') == "SEA" || $kws->department == "SEA" ? 'selected' : '' }}>SEA - School of Engineering & Architecture</option>
            <option value="SCJPS" {{ old('department') == "SCJPS" || $kws->department == "SCJPS" ? 'selected' : '' }}>SCJPS - School of Criminal Justice & Public Safety</option>
            <option value="SOL" {{ old('department') == "SOL" || $kws->department == "SOL" ? 'selected' : '' }}>SOL - School of Law</option>
            <option value="SNS" {{ old('department') == "SNS" || $kws->department == "SNS" ? 'selected' : '' }}>SNS - School of Natural Sciences</option>
            <option value="SON" {{ old('department') == "SON" || $kws->department == "SON" ? 'selected' : '' }}>SON - School of Nursing</option>
            <option value="STELA" {{ old('department') == "STELA" || $kws->department == "STELA" ? 'selected' : '' }}>STELA - School of Teacher Education & Liberal Arts</option>
            <option value="Graduate School" {{ old('department') == "Graduate School" || $kws->department == "Graduate School" ? 'selected' : '' }}>Graduate School</option>
            </select>   
            @error('department')
            <span class="text-danger">{{$message}}</span>
            @enderror 
    </div>    

    <div class="form-group">
    <label>Current Keyword/s</label>
    <select class="js-responsive" name="book_keyword[]" id="book_keyword_{{ $kws->book_barcode }}" multiple="multiple" style="width: 100%" disabled>
    @foreach($books as $book)
        @if($book->book_barcode == $kws->book_barcode)
            @foreach($keywords as $keyword)
                <?php
                    $selected = in_array($keyword->id, json_decode($book->book_keyword, true));
                ?>
                <option value="{{ $keyword->id }}" {{ $selected ? 'selected' : '' }}>
                    {{ $keyword->keyword }}
                </option>
                
            @endforeach
        @endif
    @endforeach
    </select>
</div>


<div class="form-group">
    <label>Suggested Keyword/s</label>
    <select class="js-responsive2" name="suggest_book_keyword[]" id="keyword_{{$kws->book_barcode}}" multiple="multiple" style="width: 100%">
        @foreach($keywords as $keyword)
            <?php
                // Check if the current keyword ID exists in the selected keywords array of the book
                $selected = in_array($keyword->id, json_decode($kws->suggest_book_keyword, true));
                // Check if the keyword is already in the current tags
                $disabled = in_array($keyword->id, json_decode($book->book_keyword, true));
            ?>
            <option value="{{ $keyword->id }}" {{ $selected ? 'selected' : '' }} {{ $disabled ? 'disabled' : '' }}>
                {{ $keyword->keyword }}
            </option>
        @endforeach
    </select>
</div>

<!-- <div class="form-group">
    <label class="required">Suggested Keywords</label>
    <select class="js-responsive" name="suggest_book_keyword[]" id="suggest_book_keyword{{$book->book_barcode}}" multiple="multiple" style="width: 100%" required>
        @foreach($keywords as $keyword)
            <?php
                // Check if the subject is not in the current tags
                $currentKeywords = json_decode($book->book_keyword, true);
                $isCurrentKeyword = in_array($keyword->id, $currentKeywords);
            ?>
            <option value="{{ $keyword->id }}" {{ $isCurrentKeyword ? 'disabled' : '' }}>
                {{ $keyword->keyword }}
            </option>
        @endforeach
    </select>
</div> -->
            
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
</tbody>

@empty
<tr align="center"> <td colspan="13"><h3>No Entry Found</h3></td></tr> 
@endforelse


<!-- Technical and Staff -->
@else
@forelse($keywordsuggest as $kws)
<tbody>

    <tr align="center">
        <td>@foreach($users as $user)
            @if($user->id == $kws->user_id)
            {{$user->first_name}} {{$user->last_name}}
            @endif
        @endforeach</td>
        <td>{{$kws->department}}</td>
        <td>{{$kws->book_barcode}}</td>
        <td>@foreach($books as $book)
                @if($book->book_barcode == $kws->book_barcode)
                <?php  
                        $x = $book->book_keyword;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($keywords as $keyword){
                            foreach ($words as  $key => $word) {
                                if( $word == $keyword->id){
                                echo $keyword->keyword;
                                echo '<br>'; 
                                }
                                                // if ($key < $count - 1) {
                                                //     echo " ,";
                                                //   } 
                                                // }
                            }
                        }
                                
                ?>
                @endif
            @endforeach
        </td>
        <td><?php  
                        $x = $kws->suggest_book_keyword;
                        $charactersToRemove = ['"', "[", "]"];
                        $s = str_replace($charactersToRemove, "", $x);

                        $words = explode(',', $s);

                        $count = count($words);

                        foreach ($keywords as $keyword){
                            foreach ($words as  $key => $word) {
                                if( $word == $keyword->id){
                                echo $keyword->keyword;
                                echo '<br>'; 
                                }
                            }
                        }
            ?>
        </td>
        <td>
            @if($kws->action == 1)
            Append
            @elseif($kws->action == 2)
            Replace
            @endif
            </td>
            <td>
            @if($kws->status == 0)
            Pending
            @elseif($kws->status == 1)
            Approved
            @elseif($kws->status == 2)
            Disapproved
            @else 
            Cancelled 
            @endif
        </td>

        @if(Auth::user()->type == 'technician librarian' || Auth::user()->type == 'staff librarian')            
        <td>
            @if($kws->status == 0)
            <div class="flex-parent jc-center">
                    @foreach($books as $book)
                        @if($kws->book_barcode == $book->book_barcode)
                            @if($kws->action == 1)
                                <form action="{{ route('appendkeyword', ['keywordsuggest' => $kws->id, 'book' => $book->id]) }}" method="POST">
                                @csrf 
                                @method('post')
                                <button type="submit" class="btn btn-success">Append</button>   
                                </form>
                            @else
                                <form action="{{ route('replacekeyword', ['keywordsuggest' => $kws->id, 'book' => $book->id]) }}" method="POST">
                                @csrf 
                                @method('post')
                                <button type="submit" class="btn btn-success">Replace</button>  
                                </form>
                            @endif
                        @endif
                    @endforeach
        
                    <form action="{{ route('declinekeyword', $kws->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
                    </form>
                </td>
            </div>

            @else
            <div class="flex-parent jc-center">
                    <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$kws->id}}"
                    data-action="{{ route('keywordsuggest.destroy', $kws->id) }}"><i class="fa fa-trash"></i></a>
            </div>  
            @endif
        </td>

        @elseif(Auth::user()->type == 'department representative' || Auth::user()->type == 'teacher')  
        <td>
            @if($kws->status == 0)
            <div class="flex-parent jc-center">
               

                <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$kws->id}}"
                data-action="{{ route('keywordsuggest.destroy', $kws->id) }}"><i class="fa fa-trash"></a></td>
            </div>

            @else
            <div class="flex-parent jc-center">
            <form action="{{ route('declinekeyword', $kws->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <button type="submit" class="btn btn-warning" role="button"><span>&#10005;</span></button>
                    </form>
            </div>
            @endif
        </td>
        @endif
    </tr>
</tbody>

<div class="modal fade" id="deleteUserModal_{{$kws->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('keywordsuggest.destroy', $kws->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('GET')
              <h5 class="text-center">Delete request for {{$kws->book_barcode}}?
               
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
@endif

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $keywordsuggest->render(); ?>
    </div>
</div>

<script>

var placeholder = "Select Keyword";
    $(".mySelect").select2({
        placeholder: placeholder,
        allowClear: false,
        minimumResultsForSearch: 5
    });

    $(".js-responsive").select2({});
    $(".js-responsive2").select2({});

</script>

@endsection