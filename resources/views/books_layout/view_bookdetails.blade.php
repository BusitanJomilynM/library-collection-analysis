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
                        <a class="btn btn-primary" href="{{ route('books.book_createcopy', ['book' => $book->id]) }}" role="button">Add Copy</a>
                        <!-- <a data-toggle="modal" class="btn btn-danger" data-target="#archiveBookModal_{{$book->id}}"
                           data-action="{{ route('archiveBook', $book->id) }}">Archive</a> -->

                           <a class="btn btn-primary" href="{{ route('archiveBook', ['book' => $book->id]) }}" role="button">Archive</a>
                    </td>
                </tr>
            </tbody>
            <!-- Archive Modal -->
            <div class="modal fade" id="archiveBookModal_{{$book->id}}" data-backdrop="static" tabindex="-1" role="dialog"
                 aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to archive this book?</h5>
                        </div>
                        <form action="{{ route('archiveBook', $book->id) }}" method="POST">
                            <div class="modal-body">
                                {{ csrf_field() }}
                                {{ method_field('GET') }}
                                <h5 class="text-center">Archive {{ $book->book_title }}?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Archive</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </table>



@endsection
