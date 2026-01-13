<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-bottom: 5px; }
        .meta { margin-bottom: 10px; font-size: 10px; color: #555; }
        .content { margin-top: 10px; }
    </style>
</head>
<body>

<h2>{{ $document->title }}</h2>

<div class="meta">
    Type: {{ ucfirst($document->type) }} <br>
    Privacy: {{ $document->is_private ? 'Private' : 'Shared' }} <br>
    Created: {{ $document->created_at->format('d M Y H:i') }}
</div>

<hr>

<div class="content">
    {!! $document->body !!}
</div>

</body>
</html>
