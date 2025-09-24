<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h1>New Message from your Website</h1>
    <p><strong>Name:</strong> {{ $details['name'] }}</p>
    <p><strong>Email:</strong> {{ $details['email'] }}</p>
    <p><strong>Subject:</strong> {{ $details['subject'] }}</p>
    <hr>
    <h3>Message:</h3>
    <p>{{ $details['message'] }}</p>
</body>
</html>