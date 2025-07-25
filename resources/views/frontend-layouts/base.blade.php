<html>
<!-- Custom fonts for this template-->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Tempus Dominus (Datetime Picker) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.5.2/css/tempus-dominus.min.css"
        rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/svg+xml"
        href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtYhTOo8RKwTyZAdalKXh6r00XtSVmeRpvXQ&s" />

    <title>Dashboard</title>
    
   
</head>

<body id="page-top">
 

    {{ $slot }}

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireScripts
   
</body>

</html>
