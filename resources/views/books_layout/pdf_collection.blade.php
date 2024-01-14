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
        <h3>{{ $subtitle ?? '' }}</h3>
        <p>As of {{ \Carbon\Carbon::now()->format('F Y') }}</p>
        <p>Course Code: {{$courseCode}}</p>
        <p>Course Description: {{$courseDescription}}</p>
    </div>
    
    <div style="margin: 20px auto; text-align: center;">
        <table border="1" cellspacing="0" cellpadding="5" align="center">
            <thead>
                <tr align="center">
                    <th colspan="1">Year</th>
                    <th colspan="1">Total Titles</th>
                    @if($showVolume)
                        <th colspan="1">Total Volumes</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($resultData as $year => $data)
                    <tr align="center">
                        <td>{{$year}}</td>
                        <td>{{ $data['totalTitles'] }}</td>
                        @if($showVolume)
                            <td>{{ $data['totalVolumes'] }}</td>
                        @endif
                    </tr>
                @endforeach

                @if(count($resultData) === 0)
                    <tr>
                        <td colspan="3">No data available</td>
                    </tr>
                @endif

                <tr align="center">
                    <td colspan="2">Total</td>
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
        </p>
    </div>
</body>
</html>
