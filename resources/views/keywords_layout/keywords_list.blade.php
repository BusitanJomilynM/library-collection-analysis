@extends('master_layout.master')
@section('Title', 'Keywords')
@section('content')

<h2 style="text-align: center;">Keywords</h2>

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
    <input type="text" class="form-control mr-sm-2" placeholder="Search Keywords" name="search"  value="{{ request('search') }}">
    <button type="submit" class="btn btn-danger">
    <i class="fa fa-search"></i>
    </button>
</form>
</div>

<a data-toggle="modal" class="btn btn-primary" data-target="#createKeywordModal"><span>&#43;</span></i>Add New Keyword</a>
<br>
<br>

<table class="table table-hover table-bordered" style="width:100%">
<thead class="thead-dark" >
  <tr align="center">
  <th>Keyword Name</th>
  <th>Actions</th>
  </tr>
</thead>
@foreach($keywords as $keyword)
<tbody>
    <tr align="center">
    <td>{{$keyword->keyword}}</td>
    <td>
        
    <div class="flex-parent jc-center">

            <a data-toggle="modal" class="btn btn-primary" data-target="#editKeywordModal_{{$keyword->id}}"
            data-action="{{ route('keywords.edit', $keyword->id) }}"><span>&#9776;</span>Edit</a>

            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteKeywordModal_{{$keyword->id}}"
            data-action="{{ route('keywords.destroy', $keyword->id) }}"><i class="fa fa-trash"></i></a>
    </div> 
    
    </td>
  </tr>
</tbody>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteKeywordModal_{{$keyword->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteKeywordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteKeywordModalLabel">Are you sure you want to delete this keyword?</h5>
            
          </div>
          <form action="{{ route('keywords.destroy', $keyword->id) }}" method="GET">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete keyword {{$keyword->keyword}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
</div>


<!-- Edit Keyword Modal -->
<div class="modal fade" id="editKeywordModal_{{$keyword->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editKeywordModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKeywordModalLabel">Edit Keyword</h5>
      </div>
      <form action="{{ route('keywords.update', $keyword->id) }}" method="PUT">
          <div class="modal-body">
          {{ csrf_field() }}

        <div class="form-group">
        <label>Keyword Name</label>
        <input class="form-control" type="text" name="keyword" id="keyword" value="{{$keyword->keyword}}" required>
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

@endforeach

<!-- Create Keyword Modal -->
<div class="modal fade" id="createKeywordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createKeywordModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Add New Keyword</h5>
      </div>
        <form action="{{ route('keywords.store') }}" method="POST">
          <div class="modal-body">
          {{ csrf_field() }}

        <div class="form-group">
        <label>Keyword Name</label>
        <input class="form-control" type="text" name="keyword" id="keyword" required>
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




<style>
form { 
  display: flex; 
}
input[type=text] 
{ flex-grow: 1; 
}

</style>

@endsection