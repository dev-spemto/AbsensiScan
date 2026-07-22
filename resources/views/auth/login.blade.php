<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Sistem Presensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card border-0 shadow-lg">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <i class="fa-solid fa-school fa-4x text-success mb-3"></i>

                        <h3 class="fw-bold">

                            Sistem Presensi Siswa

                        </h3>

                        <p class="text-muted mb-0">

                            SMP Muhammadiyah Tonjong

                        </p>

                    </div>

                    @if(session('error'))

                        <div class="alert alert-danger">

                            {{ session('error') }}

                        </div>

                    @endif

                    <form method="POST"
                          action="{{ route('login.proses') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Username

                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}"
                                required
                                autofocus>

                            @error('username')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required>

                            @error('password')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="form-check mb-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember">

                            <label class="form-check-label"
                                   for="remember">

                                Ingat Saya

                            </label>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-success w-100">

                            <i class="fa-solid fa-right-to-bracket"></i>

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>