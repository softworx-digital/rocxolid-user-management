<!DOCTYPE html>
<html lang="{{ env('localisation') }}">
@include('rocXolid::layouts.include.head')

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ mix('js/rocXolid.js', 'vendor/softworx/rocXolid') }}"></script>
    @yield('script')
</body>
</html>