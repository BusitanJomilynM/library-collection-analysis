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

<form method="POST" action="{{ route('generatePdf') }}">
    @csrf
    <label>
        <input type="checkbox" name="includeTitle" value="1"> Include Title
    </label>
    <br>
    <label>
        <input type="checkbox" name="includeAuthor" value="1"> Include Author
    </label>
    <br>
    <label>
        <input type="checkbox" name="includeCopyrightYear" value="1"> Include Copyright Year
    </label>
    <br>

    <!-- Add more checkboxes for other data to include -->

    <button type="submit">Generate PDF</button>
</form>

<!DOCTYPE html>
<html>
<head>
    <title>Generated PDF</title>
</head>
<body>
    @if(isset($book_title))
    <p>Title: {{ $book_title }}</p>
    @endif

    @if(isset($book_author))
    <p>Author: {{ $book_author }}</p>
    @endif

    @if(isset($book_copyrightyear))
    <p>Copyright Year: {{ $book_copyrightyear }}</p>
    @endif

    <!-- Add more data as needed -->

</body>
</html>

@endsection

