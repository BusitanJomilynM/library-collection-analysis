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
        <p class="another-paragraph">General Luna Road, Baguio City Philippines 260000  0</p>
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
    <!-- Table for all sets of filtered books -->
    <div style="margin: 20px auto; text-align: center;">
        <table border="1" cellspacing="0" cellpadding="5" align="center">
                    <!-- Table header -->
                    <thead>
                        @php
                            $currentYear = now()->year;
                            $previousYear = $currentYear - 1;
                            $anpreviousYear = $previousYear - 1; 
                            $anopreviousYear = $anpreviousYear - 1; 
                            $anotpreviousYear = $anopreviousYear - 1; 
                            $anothpreviousYear = $anotpreviousYear - 1; 
                        @endphp

                        <tr align="center">
                            <th style="font-size: 12px; width: 20px;" colspan="1">Subject Code</th>
                            <th style="font-size: 12px; width: 20px;" colspan="4">Subject Description</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">{{$currentYear}}</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">{{$previousYear}}</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">{{$anpreviousYear}}</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">{{$anopreviousYear}}</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">{{$anotpreviousYear}}</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">{{$anothpreviousYear}} & Below</th>
                            <th style="font-size: 12px; width: 20px;" colspan="2">Total</th>
                        </tr>
                        
                        <tr align="center">
                            <th style="font-size: 12px; text-align: center;" colspan="1"></th>
                            <th style="font-size: 12px; text-align: center;" colspan="4"></th>                    

                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    
 
                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    

                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    

                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    

                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    

                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    

                            <th style="font-size: 12px; text-align: center;" colspan="1">Cop.</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">Vol.</th>                    
                        </tr>
                    </thead>
                    <tbody>
                <!-- Loop through each set of filtered books -->
                @foreach ($filteredBooksSets as $setCount => $filteredBooks)
                    <tr>
                        <th colspan="1">{{ isset($subjectCodesListSets[$setCount]) ? $subjectCodesListSets[$setCount][0] : '' }}</th>
                        <th colspan="4">{{ isset($subjectNamesListSets[$setCount]) ? $subjectNamesListSets[$setCount][0] : '' }}</th>

                        @php
                            // Initialize arrays to store counts for each year
                            $yearBooksCounts = [
                                $currentYear => ['books' => 0, 'volumes' => 0],
                                $previousYear => ['books' => 0, 'volumes' => 0],
                                $anpreviousYear => ['books' => 0, 'volumes' => 0],
                                $anopreviousYear => ['books' => 0, 'volumes' => 0],
                                $anotpreviousYear => ['books' => 0, 'volumes' => 0],
                                $anothpreviousYear => ['books' => 0, 'volumes' => 0]
                            ];
                            $totalBooks = 0;
                            $totalVolumes = 0;

                            // Loop through the filtered books to count books and volumes for each year
                            foreach ($filteredBooks as $book) {
                                $matched = false; // Flag to track if the year matches any specified year

                                // Check if the book's copyright year matches any of the specified years
                                foreach ($yearBooksCounts as $year => &$counts) {
                                    if ($book->book_copyrightyear == $year) {
                                        $counts['books']++; // Increment book count for the current year

                                        // Increment volume count if the volume is not empty
                                        if (!empty($book->book_volume)) {
                                            $counts['volumes']++;
                                        }

                                        $matched = true; // Set the flag to true since a match occurred
                                        break; // No need to check other years if a match is found
                                    }
                                }

                                // If no match is found, increment count for $anothpreviousYear
                                if (!$matched) {
                                    $yearBooksCounts[$anothpreviousYear]['books']++;
                                    if (!empty($book->book_volume)) {
                                        $yearBooksCounts[$anothpreviousYear]['volumes']++;
                                    }
                                }

                                // Increment total counts
                                $totalBooks++;
                                if (!empty($book->book_volume)) {
                                    $totalVolumes++;
                                }
                            }
                        @endphp
                        
                        @foreach ([$currentYear, $previousYear, $anpreviousYear, $anopreviousYear, $anotpreviousYear, $anothpreviousYear] as $year)
                            <th style="font-size: 12px; text-align: center;" colspan="1">{{ $yearBooksCounts[$year]['books'] }}</th>
                            <th style="font-size: 12px; text-align: center;" colspan="1">{{ $yearBooksCounts[$year]['volumes'] }}</th>
                        @endforeach   

                        {{-- Display total copyright count and volume count for the first set of years --}}
                        <th style="font-size: 12px; text-align: center;" colspan="1">{{ $totalBooks }}</th>
                        <th style="font-size: 12px; text-align: center;" colspan="1">{{ $totalVolumes }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>No filtered books found.</p>
@endif    <div style="text-align: left; margin-top: 10px;">
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