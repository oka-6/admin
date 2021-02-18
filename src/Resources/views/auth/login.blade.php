@extends('Admin::layouts.backend.login-tpl')

@section('content')

    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
             style="background-color: #f1f1f1;">
            <div class="auth-box"
                 style="background: {{\Illuminate\Support\Facades\Config::get('admin.background_login')}}">
                <div class="logo">
                    <span class="db"><img src="{{\Illuminate\Support\Facades\Config::get('admin.logo')}}" alt="logo"
                                          style="max-width: 200px;padding-bottom: 20px"></span>

                </div>
                <div id="loginform">
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" id="loginform" method="POST"
                                  action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{$path}}" name="path">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="email" id="email" class="form-control form-control-lg" name="email"
                                           value="{{ old('email') }}" placeholder="Email" required autofocus
                                           aria-describedby="basic-addon1">
                                </div>
                                @if ($errors->has('email'))
                                    <label class="text-danger" for="email">{{ $errors->first('email') }}</label>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i
                                                    class="ti-pencil"></i></span>
                                    </div>
                                    <input id="password" type="password"
                                           class="form-control-lg form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required placeholder="Senha" aria-describedby="basic-addon1">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <a href="{{ route('password.request') }}" id="to-recover"
                                               class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Esqueceu
                                                sua senha?</a>
                                            <input type="checkbox" class="custom-control-input" name="remember"
                                                   id="customCheck1" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck1">Lembrar de
                                                mim</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-dark" type="submit">Entrar</button>
                                    </div>

                                    <div class="mt-2"></div>
                                    <p>Ou</p>
                                    <div class="mt-2"></div>

                                    <div class="col-xs-12 " >
                                        <a href="/" class="btn  btn-secondary text-white" type="submit">Criar conta</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>


@endsection

