@extends('master_layout.master')

@section('Title', 'Books PDF')
@section('content')
<h2 style="text-align: center;">Generate Booklist</h2>

<div class="panel panel-default">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('success') }}
        </div>
    @endif
</div>

<h2>Generate PDF</h2>

<!-- booklist_pdf.blade.php -->
<form method="GET" action="{{ route('booklist_pdf') }}">
    @csrf
    <label for="booktitle">
        <input type="checkbox" id="booktitle" name="booktitle"> Book Title
    </label>
    <br>
    <label for="bookcallnumber">
        <input type="checkbox" id="bookcallnumber" name="bookcallnumber"> Book Callnumber
    </label>
    <br>
    <label for="bookauthor">
        <input type="checkbox" id="bookauthor" name="bookauthor"> Author
    </label>
    <br>
    <label for="bookcopyrightyear">
        <input type="checkbox" id="bookcopyrightyear" name="bookcopyrightyear"> Copyright Year
    </label>
    <br>
    <label for="copy">
        <input type="checkbox" id="copy" name="copy"> Number of Copies
    </label>






    <button type="submit">Submit</button>
</form>

<!-- 
@if(isset($data))
    <h2>Retrieved Data:</h2>
    <ul>
        @foreach($data as $item)
            <li>{{ $item->book_title }}</li>
            <li>{{ $item->book_callnumber }}</li>
        @endforeach
    </ul>
@endif -->
@endsection

