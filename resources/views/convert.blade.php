<!DOCTYPE html>
<html>
<head>
    <title>Convert MP4 to WAV</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
   
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script src="{{ asset('js/convert.js') }}" defer></script>
</head>
<body class="container mt-5">
    <div class="header">
        <h2>conversion</h2>
    </div><br>
    <h1 class="mb-4">Convert MP4 to WAV</h1>
    <form id="convertForm" action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose MP4 file:</label>
            <input type="file" id="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Convert</button>
    </form>
    <p id="statusMessage" class="hidden mt-3 alert alert-info">Converting...</p>
    <div id="downloadLink" class="hidden mt-3">
        <p>Conversion complete. <a id="convertedFileLink" href="#" class="btn btn-success">Download WAV file</a></p>
    </div>
</body>
</html>
