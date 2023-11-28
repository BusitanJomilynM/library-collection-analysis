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
            <th>Year</th>
                <th>Title Count</th>
            </tr>
        </thead>
        <tbody>
            
        @php
            $totalCopies = 0;
            $totalVolume = 0;
        @endphp
            @forelse($resultData as $book)
                <tr align="center">
                <td>{{ $yearData['year'] }}</td>
                    <td>{{ $yearData['title_count'] }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
            @endforelse
            <tr align="center">
    <td colspan="3">Total</td>
    <td>{{$totalTitleCount}}</td>
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