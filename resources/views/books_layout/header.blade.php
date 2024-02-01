

<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Header</title>
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
            font-size: 11px; /* Replace with your desired font size */
            margin-top: 5px;
        }

        .header hr {
            width:100%; /* Adjust the width of the lines */
            margin-top:1px; /* Add margin to center the lines */
            border: 1px solid #000;
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
</body>
</html>
