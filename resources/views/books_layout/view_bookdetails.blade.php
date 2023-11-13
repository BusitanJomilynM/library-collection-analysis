@extends('master_layout.master')
@section('Title', 'Book Details')
@section('content')
<h2 style="text-align: center;">Books Details</h2>

<div class="panel panel-default">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('success') }}
        </div>
    @endif
</div>

<a class="btn btn-primary my-2 my-sm-0" href="{{ route('books.index') }}">Return</a>

    <table class="table table-bordered" style="width:100%">
        <thead class="thead-dark">
            <tr align="center">
                <th>Book Title</th>
                <th>Author</th>
                <th>Copyright Year</th>
                <th>Sublocation</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        @if($book->status == 0)
            <tbody>
                <tr align="center">
                    <td>{{ $book->book_title }}</td>
                    <td>{{ $book->book_author }}</td>
                    <td>{{ $book->book_copyrightyear }}</td>
                    <td>{{ $book->book_sublocation }}</td>
                    <td>
                        <?php
                        $t = $book->book_subject;
                        $a = explode(" ", $t);
                        echo implode(", ", $a);
                        ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('books.edit', ['book' => $book->id]) }}" role="button">Edit</a>
                        <a class="btn btn-success" href="{{ route('books.book_createcopy', ['book' => $book->id]) }}" role="button"><span>&#43;</span>Add Copy</a>
                        <!-- <a data-toggle="modal" class="btn btn-danger" data-target="#archiveBookModal_{{$book->id}}"
                           data-action="{{ route('archiveBook', $book->id) }}">Archive</a> -->

                           <a class="btn btn-warning" href="{{ route('archiveBook', ['book' => $book->id]) }}" role="button">Archive</a>
                    </td>
                </tr>
            </tbody>
           
        @endif
    </table>



@endsection
