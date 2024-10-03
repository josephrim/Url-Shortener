<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>URL Shortener</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <h1>URL Shortener Service</h1>

        <!-- Encode URL Section -->
        <h2>Encode a URL</h2>
        <form id="encode-form">
            @csrf
            <label for="url">Enter URL to encode:</label>
            <input type="text" id="url" name="url" required>
            <button type="submit">Encode</button>
        </form>

        <p>Encoded URL: <span id="encoded-url"></span></p>

        <!-- Decode URL Section -->
        <h2>Decode a URL</h2>
        <form id="decode-form">
            @csrf
            <label for="short-url">Enter shortened URL:</label>
            <input type="text" id="short-url" name="short_url" required>
            <button type="submit">Decode</button>
        </form>

        <p>Original URL: <span id="decoded-url"></span></p>

        <script>
            $(document).ready(function () {
                // Handle encoding form submission
                $('#encode-form').submit(function (event) {
                    event.preventDefault();
                    let url = $('#url').val();
                    $.ajax({
                        url: '/encode',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { url: url },
                        success: function (response) {
                            $('#encoded-url').text(response.short_url);
                        },
                        error: function () {
                            alert('Error encoding URL.');
                        }
                    });
                });

                // Handle decoding form submission
                $('#decode-form').submit(function (event) {
                    event.preventDefault();
                    let shortUrl = $('#short-url').val();
                    $.ajax({
                        url: '/decode',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { short_url: shortUrl },
                        success: function (response) {
                            $('#decoded-url').text(response.original_url);
                        },
                        error: function () {
                            alert('Error decoding URL.');
                        }
                    });
                });
            });
        </script>
    </body>
</html>