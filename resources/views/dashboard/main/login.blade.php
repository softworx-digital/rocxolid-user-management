@extends('rocXolid:user-management::layouts.unauthorized')

@section('content')
<section class="login_content">
    <form method="post" action="{{ route('rocXolid.auth.login') }}">
        {{ csrf_field() }}

        <h1>{{ $component->translate('text.login', false) }}</h1>
    @if ($errors->has('email'))
        <p class="alert alert-danger"><strong style="text-shadow: none;">{{ $errors->first('email') }}</strong></p>
    @endif
        <div><input type="text" name="email" class="form-control" placeholder="{{ $component->translate('field.username', false) }}" required="required"/></div>
        <div><input type="password" name="password" class="form-control" placeholder="{{ $component->translate('field.password', false) }}" required="required"/></div>
        <div><label><input type="checkbox" name="remember"/> {{ $component->translate('field.remember-me', false) }}</label></div><br />
        <div>
            <button class="btn btn-default submit" type="submit">{{ $component->translate('button.login', false) }}</button>
        @if (false)
            <a class="reset_pass">{{ $component->translate('text.forgot-password', false) }}</a>
        @endif
        </div>
    </form>
</section>
@endsection