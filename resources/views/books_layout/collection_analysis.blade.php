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

    <label for="booktitle">
        <input type="checkbox" id="booktitle" name="booktitle"> Book Title
    </label>
    <br>
    <label for="bookcallnumber">
        <input type="checkbox" id="bookcallnumber" name="bookcallnumber"> Book Callnumber
    </label>
    <br>
    <label for="bookauthor">
        <input type="checkbox" id="bookauthor" name="bookauthor"> Author
    </label>
    <!-- <br>
    <label for="bookcopyrightyear">
        <input type="checkbox" id="bookcopyrightyear" name="bookcopyrightyear"> Copyright Year
    </label> -->
    <br>
    <label for="copy">
        <input type="checkbox" id="copy" name="copy"> Number of Copies
    </label>
    <br> 
    <label for="volume">
        <input type="checkbox" id="volume" name="volume"> Volume
    </label>
    <br>
    <p>Filters:</p>

    <label for="subject">
        <input type="checkbox" id="subject" name="subject"> Subject
    </label>
    <input type="text" id="subjectText" name="subjectText" placeholder="Enter subject">
    <br>


    <label for="callNumberPrefix">
        <select id="callNumberPrefix" name="callNumberPrefix">
            <option value="">-- Filter by Subject Head --</option>
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
