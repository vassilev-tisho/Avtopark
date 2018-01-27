@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Форма за регистрация</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Име</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus>

                                @if ($errors->has('firstName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Фамилия</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus>

                                @if ($errors->has('lastName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Парола</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Потвърди паролата</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role_id" class="col-md-4 control-label">Фирма/Физическо лице</label>
                            <div class="col-md-6">
                                <select class="form-control" data-style="btn btn-primary btn-round" title="Роля на потребител" data-size="2" name="client_type" id="role_id">
                                    <option value="">--Без избор--</option>

                                        <option data-code="NOFIRM">Физическо лице </option>
                                        <option data-code="FIRM">Фирма</option>

                                </select>
                                @if($errors->has('role_id'))
                                    <span class="danger" style="margin-top: 7px;">
                                            {{$errors->first('role_id')}}
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div id="NOFIRM_only" style="display: none;" class="hiddenfield">
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label class="control-label">ЕГН</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="egn" value="{{old('egn')}}">
                                    @if($errors->has('egn'))
                                        <span class="danger">
                                            {{$errors->first('egn')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label class="control-label">Адрес на клиента</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="customerAddress">
                                    @if($errors->has('customerAddress'))
                                        <span class="danger">
                                            {{$errors->first('customerAddress')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label class="control-label">Телефон</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="customerPhone">
                                    @if($errors->has('customerPhone'))
                                        <span class="danger">
                                            {{$errors->first('customerPhone')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="FIRM_only" style="display: none;" class="hiddenfield">
                            <div class="form-group">
                                <div class="col-md-4 control-label" >
                                    <label class="control-label">БУЛСТАТ/ЕИК</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="bulstat">
                                    @if($errors->has('bulstat'))
                                        <span class="danger">
                                            {{$errors->first('bulstat')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label class="control-label">Адрес на фирмата</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="customerAddress">
                                    @if($errors->has('customerAddress'))
                                        <span class="danger">
                                            {{$errors->first('customerAddress')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label>Телефон</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="customerPhone">
                                    @if($errors->has('customerPhone'))
                                        <span class="danger">
                                            {{$errors->first('customerPhone')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Регистрирай
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
@section('scripts')
    <script>
        $('#role_id').on('change', function () {
            $('.hiddenfield').css('display', 'none')
            var code = $(this).find('option:selected').data('code');
            $('#' + code + '_only').css('display', 'block');
        });
    </script>

@endsection