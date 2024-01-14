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
        <h2>{{ $pdfTitle ?? '' }}</h2>
        <!-- <h3>{{ $subtitle ?? '' }}</h3> -->
        <!-- <p>{{ $courseCode ?? '' }}</p> -->
        <p>As of {{ \Carbon\Carbon::now()->format('F Y') }}</p>
        <!-- <p>{{$courseCode}}: {{$courseDescription}}</p> -->
    </div>
    
<div style="margin: 20px auto; text-align: center;">
    <table border="1" cellspacing="0" cellpadding="5" align= center>
        <thead>
        <tr align="center">
                <th colspan="1">{{$courseCode}}</th>
                <th colspan="4">{{$courseDescription}}</th>
            </tr>
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
                <th>Total Copies</th>
                @if($showVolume)
                        <th>Volume</th>
                    @endif
            </tr>
        </thead>
        <tbody>
            
            @forelse($resultData as $book)
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
                    @php
                    $totalCopies += $book['copy_count'];
                @endphp
                    @if($showVolume)
                        <td>{{$book['volume']}}</td>
                        @php
                        $totalVolume += $book['volume'];
                    @endphp
                    @endif

                </tr>
            @empty
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
            @endforelse
            <tr align="center">
            <td colspan="3">Total</td>
            <td>{{$totalCopies}}</td>
            @if($showVolume)
                <td>{{$totalVolume}}</td>
            @endif
        </tr>
        </tbody>
    </table>
</div>
<div class="footer" style="position: absolute; bottom: 0; right: 0; text-align: right; font-style: italic; width: 100%;">
<p>
    <span style="margin-right: 280px;">As of {{ \Carbon\Carbon::now()->format('F Y') }}</span>
    Prepared by: {{$user->last_name}} {{$user->first_name}}  {{$user->middle_name}}
</p></div>
</body>
</html>