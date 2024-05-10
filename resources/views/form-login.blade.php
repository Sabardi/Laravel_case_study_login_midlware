<!DOCTYPE html>
 <html lang="en">
     <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     {{-- <link href="/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

     <title>Sistem Informasi Mahasiswa</title>
 </head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{url('/daftarMahasiswa')}}">
                        Daftar Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/tabelMahasiswa')}}">
                    Tabel Mahasiswa
                </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/blogMahasiswa')}}">
                    Blog Mahasiswa
                </a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="my-4">Form Login</h2>
        <hr>


        @if(session()->has('pesan'))

        <div class="alert alert-info w-50">
            {{ session()->get('pesan') }}
        </div>
        @endif
        <form action="{{url('/login')}}" method="POST">
            @csrf
                <div class="mb-3">

                    <label for="username" class="form-label">Username</label>

                <input type="text" class="form-control w-50" id="username"

                name="username" value="{{ old('username') }}">

                @error('username')

                <div class="text-danger">{{ $message }}</div>

                @enderror

                </div>

            <button type="submit" class="btn btn-primary my-2">Login</button>

        </form>

    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>

</body>
</html>
