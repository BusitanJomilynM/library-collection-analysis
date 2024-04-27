@section('Title', 'Books')

@php
    $showCopies = true;
    $headerColspan = 0;
    $pageNumber = 1;
@endphp
<!-- pdf_view.blade.php -->



<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Booklist</title>
        <style>
        .header {
            text-align: center;
        }

        .header img {
            max-width: 30%;
            height: auto;
        }

        .header p.main-paragraph {
            font-family: 'Tahoma'; /* Replace 'YourSpecificFont' with the actual font name */
            font-size: 12px; /* Replace with your desired font size */
            font-weight: bold;
            margin-top: 0; /* Adjust the top margin as needed */
            margin-bottom: 0;         
        }
        
        .header p.another-paragraph {
            font-family: 'Tahoma'; /* Replace 'YourSpecificFont' with the actual font name */
            font-size: 13px; /* Replace with your desired font size */
            margin-top: 0;
        }

        .header p.another-another-paragraph {
            font-family: 'Tahoma'; /* Replace 'YourSpecificFont' with the actual font name */
            font-size: 12px; /* Replace with your desired font size */
            margin-top: 5px;
        }

        .header p.another-another-another-paragraph {
            font-family: 'Times New Roman'; /* Replace 'YourSpecificFont' with the actual font name */
            font-size: 12px; /* Replace with your desired font size */
            margin-top: 0px;
        }

        .header hr {
            width:100%; /* Adjust the width of the lines */
            border: 1px solid #000;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 15px;
            font-family: 'Times New Roman'; /* Replace 'Tahoma' with your desired font */
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('..\public\images\ub.png') }}" alt="Header Image">
        <p class="main-paragraph">SCHOOL OF INFORMATION TECHNOLOGY</p>
        <p class="another-paragraph">General Luna Road, Baguio City Philippines 2600</p>
        <hr>
        <hr>
        <p class="another-another-paragraph">Telefax No.: (074) 442-3071&nbsp;&nbsp;&nbsp;&nbsp;Website: www.ubaguio.edu&nbsp;&nbsp;&nbsp;&nbsp;E-mail Address: sit@e.ubaguio.edu</p>

    </div>



    <div style="text-align: center;">
        <h3>{{ $course_name ?? '' }} Booklist</h3>
        <p class="another-another-another-paragraph">As of {{ \Carbon\Carbon::now()->format('F Y') }}</p>
    </div>

<!-- Check if filtered books exist -->
@if (!empty($filteredBooksSets))
    <!-- Loop through each set of filtered books -->
    @foreach ($filteredBooksSets as $setCount => $filteredBooks)
        <div style="margin: 20px auto; text-align: center;">
            <!-- Table for each set of filtered books -->
            <table border="1" cellspacing="0" cellpadding="5" align="center">
                <!-- Table header -->
                <thead>
                <tr align="center">
                    <th colspan="1">
                        {{ isset($subjectCodesListSets[$setCount]) ? $subjectCodesListSets[$setCount][0] : '' }}
                    </th>
                    <th colspan="3">
                        {{ isset($subjectNamesListSets[$setCount]) ? $subjectNamesListSets[$setCount][0] : '' }}
                    </th>
                </tr>
                <tr align="center">
                    <th style="font-size: 12px; text-align: center;" colspan="1">Call Number</th>
                    <th style="font-size: 12px; text-align: center;" colspan="1">Title</th>
                    <th style="font-size: 12px; text-align: center;" colspan="1">Author</th>
                    <th style="font-size: 12px; text-align: center;" colspan="1">Copies</th>
                </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    @php
                        $totalCopies = 0;
                        $printedCallNumbers = [];
                    @endphp
                    @foreach ($filteredBooks as $book)
                        @if (!in_array($book->book_callnumber, $printedCallNumbers))
                            <tr align="center">
                                <td>{{ $book->book_callnumber }}</td>
                                <td>{{ $bookStatsSets[$setCount][$book->book_callnumber]['title'] }}</td>
                                <td>{{ $bookStatsSets[$setCount][$book->book_callnumber]['author'] }}</td>
                                <td>{{ $bookStatsSets[$setCount][$book->book_callnumber]['totalCopies'] }}</td>
                            </tr>
                            <!-- Update total copies for this set -->
                            @php
                                $totalCopies += $bookStatsSets[$setCount][$book->book_callnumber]['totalCopies'];
                                $printedCallNumbers[] = $book->book_callnumber;
                            @endphp
                        @endif
                    @endforeach     
                    <!-- Total row -->
                    <tr align="center">
                        <td colspan="3">Total</td>
                        <td >{{$totalCopies}}</td>
                    </tr>
                </tbody>
            </table>
            <br>
        </div>
    @endforeach
@else
    <p>No filtered books found.</p>
@endif


    <div style="text-align: left; margin-top: 10px;">
    Prepared by: <br>
    {{$user->last_name}} {{$user->first_name}}  {{$user->middle_name}}<br>
    {{ \Carbon\Carbon::now()->format('F j, Y') }}
</div>

<!-- Footer -->
<div class="footer" style="position: absolute; bottom: 0; right: 0; text-align: right; font-style: italic; width: 100%;">
    <p>
    <span style="float: left;">{{ $course_code }}</span>
<span style="display: inline-block; text-align: center; width: 70%;">{{ $pageNumber }}</span>
<span style="float: right;">As of {{ \Carbon\Carbon::now()->format('F j, Y') }}</span>
    </p>
</div>


</body>
</html>