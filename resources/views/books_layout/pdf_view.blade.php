@section('Title', 'Books')

<!-- pdf_view.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pdfTitle ?? 'Booklist Report' }}</title>
    <!-- Add any additional stylesheets or styles here -->
</head>
<body>
    <div style="text-align: center;">
        <h2>{{ $pdfTitle ?? 'Booklist Report' }}</h2>
    </div>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr align="center">
                @if($showBookTitle)
                    <th>Title</th>
                @endif
                @if($showBookCallnumber)
                    <th>Call Number</th>
                @endif
                @if($showBookAuthor)
                    <th>Author</th>
                @endif
                @if($showBookCopyrightYear)
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
</body>
</html>
