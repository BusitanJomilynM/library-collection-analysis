@section('Title', 'Books')



<table class="table table-bordered" style="width:100%">
    <thead class="thead-dark">
        <tr align="center">
            @if(isset($showBookTitle) && $showBookTitle)
                <th>Book Title</th>
            @endif
            @if(isset($showBookCallnumber) && $showBookCallnumber)
                <th>Book Callnumber</th>
            @endif
            @if(isset($showBookAuthor) && $showBookAuthor)
                <th>Author</th>
            @endif
            @if(isset($showBookCopyrightYear) && $showBookCopyrightYear)
                <th>Copyright Year</th>
            @endif
            <th>Copy Count</th>
        </tr>
    </thead>

    <tbody>
    @forelse($data as $book)
        <tr align="center">
            @if($showBookTitle)
                <td>{{$book['title']}}</td>
            @endif
            @if($showBookCallnumber)
                <td>{{$book['callnumber']}}</td>
            @endif
            @if($showBookAuthor)
                <td>{{$book['author']}}</td>
            @endif
            @if($showBookCopyrightYear)
                <td>{{$book['copyrightyear']}}</td>
            @endif
            <td>{{$book['copy_count']}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No data available</td>
        </tr>
    @endforelse
</tbody>

</table>
</table>

