<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Idea Box</title>

    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js" defer></script>

    <style>
        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        #gauss-wrapper {
            width: 800px;
            height: 500px;
        }
    </style>
</head>
<body>
    <div id="root">
        <div class="flex-center">
            <div id="gauss-wrapper">
                <gauss-wrapper></gauss-wrapper>
            </div>
        </div>
    </div>
</body>
</html>