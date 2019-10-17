<div id="login-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content ajax-overlay">
            <form id="login-modal-form" method="POST" action="{{ route('rocXolid.auth.login', ['modal' => true]) }}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-hourglass-end text-danger margin-right-10"></i>Prihlásenie vypršalo</h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                    @if (false)
                        @if ($errors->has('email'))
                            <p class="alert alert-danger"><strong style="text-shadow: none;">{{ $errors->first('email') }}</strong></p>
                        @endif
                    @endif
                        @if (isset($error))
                            <p class="alert alert-danger">Nesprávne prihlasovacie údaje</p>
                        @endif

                        <div class="form-group">
                            <div class="control-group"><input type="text" name="email" class="form-control" placeholder="Login (e-mail)" required="required"/></div>
                        </div>

                        <div class="form-group">
                            <div class="control-group"><input type="password" name="password" class="form-control" placeholder="Heslo" required="required"/></div>
                        </div>
                        <div class="form-group"><label><input type="checkbox" name="remember"/> Zapamätať v tomto prehliadači</label></div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-ajax-submit-form="#login-modal-form">Prihlásiť sa</button>
                </div>
            </form>
        </div>
    </div>
</div>