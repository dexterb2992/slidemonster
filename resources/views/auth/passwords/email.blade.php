@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="section"></div>
    <div class="container col-md-6">
        <div class="col content-center">
            <div class="card container">
                <div class="header header-primary text-center" style="padding-top: 15px;">
                    <h5>Reset Password</h5>
                </div>

                <div class="content">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <small class="help-block text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </small>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $("body").removeClass('navbar-transparent').removeAttr("color-on-scroll");
    </script>
@endsection