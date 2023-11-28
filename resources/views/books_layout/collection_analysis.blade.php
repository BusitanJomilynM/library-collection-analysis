@extends('master_layout.master')

@section('Title', 'Collection Analysis')
@section('content')
<h2 style="text-align: center;">Collection Analysis</h2>

<div class="panel panel-default">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('success') }}
        </div>
    @endif
</div>

<div class="row justify-content-center">
            <div class="col-md-6" style="background-color: white; black: white; padding: 20px;">

<!-- booklist_pdf.blade.php -->
<form method="GET" action="{{ route('collection_analysis') }}">
    @csrf
    <label for="pdfTitle">Title:</label>
    <input type="text" id="pdfTitle" name="pdfTitle" placeholder="Enter PDF title">
    <br>
    <label for="courseCode">Course Code:</label>
    <input type="text" id="courseCode" name="courseCode" placeholder="Enter course code">
    <br>
    <label for="courseDescription">Course Description:</label>
    <textarea id="courseDescription" name="courseDescription" placeholder="Enter course description"></textarea>
    <br>

    <br>
    <label for="copy">
        <input type="checkbox" id="copy" name="copy"> Number of Titles
    </label>
    <br> 
    <label for="volume">
        <input type="checkbox" id="volume" name="volume"> Volume
    </label>a
    <br>
    <p>Filters:</p>
    <label for="includeYearRange">
        <input type="checkbox" id="includeYearRange" name="includeYearRange"> Include Year Range
    </label>
    <label for="startYear">Start Year:</label>
    <input type="text" id="startYear" name="startYear" placeholder="Enter start year">

    <label for="endYear">End Year:</label>
    <input type="text" id="endYear" name="endYear" placeholder="Enter end year">
    <br>
    <label for="subject">
        <input type="checkbox" id="subject" name="subject"> Subject
    </label>
    <input type="text" id="subjectText" name="subjectText" placeholder="Enter subject">
    <br>


    <label for="callNumberPrefix">
        Include Call Number:
        <select id="callNumberPrefix" name="callNumberPrefix">
            <option value="">-- Select Subject Head --</option>
            <option value="COM">COM</option>
            <option value="EDUC">EDUC</option>
            <option value="ENG">ENG</option>
            <option value="LAHS">LAHS</option>
            <option value="GRAD">GRAD</option>
            <option value="THES">THES</option>
            <option value="CD">CD</option>
            <option value="FIC">FIC</option>
            <option value="LAW">LAW</option>
            <option value="REL">REL</option>
            <option value="AMS">AMS</option>
            <option value="ARCH">ARCH</option>
            <option value="FIL">FIL</option>
            <option value="CRIM">CRIM</option>
            <option value="ITHM">IHTM</option>
            <option value="THES">THES</option>
            <option value="PER">PER</option>
            <option value="SEF">SEF</option>
            <option value="SR">SR</option>

        </select>
    </label>



    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Generate Collection Analysis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
