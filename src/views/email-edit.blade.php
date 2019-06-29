@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update E-Mail Address</div>

                <div class="card-body">
                    <p>Your e-mail address is currently: {{ auth()->user()->email }}.</p>
                    <p>You can update your e-mail address using the form on this page. Please note that you will receive a link to your new e-mail address which must be confirmed to complete the update of your e-mail address.</p>

                    <form method="POST" action="{{ route(config('confirm-new-email.route.update-request.name')) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="new_email" class="col-md-4 col-form-label text-md-right">New E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="new_email" type="email" class="form-control @error('new_email') is-invalid @enderror" name="new_email" value="{{ old('new_email') }}" required autocomplete="email" autofocus>

                                @error('new_email')
                                    @foreach($errors->get('new_email') as $message)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @endforeach
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update E-Mail
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
