<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/login/dist/output.css') }}">
    <title>Register Page</title>
</head>

<body>
    <div class="flex py-10 md:py-20 px-5 md:px-32 bg-gray-200 min-h-screen">
        <div class="flex shadow w-full flex-col-reverse lg:flex-row">
            <div class="w-full lg:w-1/2 bg-white p-10 px-5 md:px-20">
                <h1 class="font-bold text-xl text-gray-700">Register Page</h1>
                <p class="text-gray-600">Please fill all column to create your account!</p>
                @if (Session::has('errors'))
                    <ul>
                        @foreach (Session::get('errors') as $error)
                            <li style="color: red">{{ $error[0] }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="register_member" method="POST" class="mt-10">
                    @csrf
                    <div class="my-3">
                        <label class="font-semibold" for="nama_member">Nama Member</label>
                        <input required type="text" placeholder="nama member" name="nama_member" id="nama_member"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full">
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="no_hp">Nomor HP</label>
                        <input required type="text" placeholder="no_hp" name="no_hp" id="no_hp"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full">
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="email">Email</label>
                        <input required type="email" placeholder="email" name="email" id="email"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full">
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="password">password</label>
                        <input required type="password" placeholder="password" name="password" id="password"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full">
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="konfirmasi_password">Konfirmasi Passsword</label>
                        <input required type="password" placeholder="konfirmasi_password" name="konfirmasi_password"
                            id="konfirmasi_password" class="block border-2 rounded-full mt-2 py-2 px-5 w-full">
                    </div>
                    <div class="my-5">
                        <button type="submit"
                            class="w-full rounded-full bg-blue-400 hover:bg-blue-600 text-white py-2">REGISTER</button>
                    </div>
                </form>
                <span>Have an account? <a href="/login_member" class="text-blue-400 hover:text-blue-600">Login
                        here.</a></span>
            </div>
            <div class="w-full lg:w-1/2 bg-blue-400 flex justify-center items-center">
                <img src="{{ asset('assets/login/src/register.svg') }}" alt="Login Image" class="w-full">
            </div>
        </div>
    </div>
    <script src=" {{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
</body>

</html>
