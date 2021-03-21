<div class="card">
    <div class="card-header bg-amber">
        <h6 class="m-b-0 text-black font-weight-bolder">Seus dados</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 form-group {{$errors->has('name') ? 'has-error' : ''}} ">
                <label for="title">Nome</label>
                <input type="text" class="form-control" value="{{old('name',$user->exists() ? $user->name : '')}}"
                       name="name"
                       id="name">
                @if($errors->has('name'))
                    <span class="text-danger">{{$errors->first('name')}}</span>
                @endif
            </div>

            <div class="col-md-4 form-group {{$errors->has('lastname') ? 'has-error' : ''}}">
                <label for="slug">Sobrenome</label>
                <input type="text" value="{{old('lastname',$user->exists() ? $user->lastname : '')}}" name="lastname"
                       class="form-control"
                       id="lastname">
                @if($errors->has('lastname'))
                    <span class="text-danger">{{$errors->first('lastname')}}</span>
                @endif
            </div>

            <div class="col-md-4 form-group {{$errors->has('cell_phone') ? 'has-error' : ''}}">
                <label for="slug">Celular</label>
                <input type="text" value="{{old('slug',$user->exists() ? $user->cell_phone : '')}}" name="cell_phone"
                       class="form-control"
                       id="cell_phone">
                @if($errors->has('cell_phone'))
                    <span class="text-danger">{{$errors->first('cell_phone')}}</span>
                @endif
            </div>
            <div class="col-md-4 form-group {{$errors->has('email') ? 'has-error' : ''}}">
                <label for="slug">E-mail</label>
                <input type="email" value="{{old('email',$user->email)}}" name="email" class="form-control"
                       id="email">
                @if($errors->has('email'))
                    <span class="text-danger">{{$errors->first('email')}}</span>
                @endif
            </div>

            <div class="col-md-4 form-group">
                <label for="active">Meu Perfil</label>
                <input type="text" value="{{$profiles[Auth::User()->profile_id]}}" name="onlyInfo" class="form-control"
                       id="onlyInfo" disabled>
            </div>

            <div class="col-md-4 form-group {{$errors->has('resource_defautl_id') ? 'has-error' : ''}}">
                <label for="active">Página incial</label>
                <select class="form-control" id="selectResourceDefault" name="resource_default_id"> </select>
            </div>

            <div class="col-md-4 form-group {{$errors->has('password') ? 'has-error' : ''}}">
                <label for="slug">Senha</label>
                <input type="password" name="password" class="form-control"
                       id="password" value="">
                @if($errors->has('password'))
                    <span class="text-danger">{{$errors->first('password')}}</span>
                @endif
            </div>

            <div class="col-md-4 form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
                <label for="slug">Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control"
                       id="password_confirmation" value="">
                @if($errors->has('password_confirmation'))
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                @endif
            </div>

            <div class="col-md-4 form-group {{$errors->has('old_password') ? 'has-error' : ''}}">
                <label for="old_password">Senha atual</label>
                <input type="password" name="old_password" class="form-control"
                       id="old_password" value="">
                @if($errors->has('old_password'))
                    <span class="text-danger">{{$errors->first('old_password')}}</span>
                @endif
            </div>

            <div class="col-md-3 form-group">
                <label for="title">Foto Perfil</label>
                <div class="user-avatar">
                    <div onclick="document.getElementById('image_user').click()"
                         class="user-avatar-overlay">
                        @if (isset($user->picture) && $user->picture)
                            <img class="src-image-user" src="{{$user->picture}}" alt="">
                        @else
                            <img class="src-image-user"
                                 src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y&s=400"
                                 alt="">
                        @endif
                    </div>
                </div>
            </div>
            <input style="display: none" type="file"  readonly accept="image/*" name="image_user" id="image_user">
            <input type="hidden" name="picture" value="{{$user->picture ? $user->picture : ''}}" id="image_user_url">

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </div>
</div>
@section('style_head')
    <link rel="stylesheet" href="{{mix('/vendor/oka6/admin/css/select2.css')}}">
    <style>
        .user-avatar {
            width: 160px;
            height: 150px;
            position: relative;
            margin: 0 auto;
        }

        .user-avatar .user-avatar-overlay {
            display: none;
        }

        .user-avatar .user-avatar-overlay:hover {
            cursor: pointer;
            transform: scale(1.01);
            opacity: 0.7;
            transition: all 1s;
        }

        .user-avatar .user-avatar-overlay {
            position: absolute;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            fill: #205488;
        }

        .user-avatar .user-avatar-overlay img {
            width: 156px;
            height: 156px;
            border-radius: 50%;
            object-fit: cover;
            border: 7px solid #e9ecef;
            box-shadow: 0px 2px 5px #c7c7c7;
            margin-top: 6px;
        }
    </style>
@endsection
@section('script_footer_end')
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/select2.js')}}></script>
    <script>
        var selectedOption = "{{$user->exists ? $user->profile_id : 1}}";
        var resource_default_id = "{{$user->exists ? $user->resource_default_id : null}}";

        $(document).ready(function () {
            $('#selectResourceDefault').select2({width: '100%'});
            getResourcesByProfileId(selectedOption);
            $(document).on('change', '#selectProfile', function () {
                var valueProfile = this.value;
                getResourcesByProfileId(valueProfile);
            }).trigger('change');

            function getResourcesByProfileId($id) {
                var url = '{{route('admin.users.resourcesDefault', [':id'])}}';
                url = url.replace(':id', $id)
                $.ajax({
                    url: url,
                    type: "get",
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (data) {
                        populateResourcesDefault(data);
                    },
                    error: function (erro) {
                        console.log(erro.responseJSON.message);
                        toastr["error"](erro.responseJSON.message, "Error");
                    }
                })
            }

            function prepareImageBase64(data, quality){
                return new Promise(async (resolve, reject) => {
                    let url = await URL.createObjectURL(data),
                        canvas = document.createElement('canvas'),
                        ctx = canvas.getContext("2d"),
                        img = new Image;
                    img.src = url;
                    img.onload = () => {
                        canvas.height = img.height;
                        canvas.width = img.width;
                        ctx.drawImage(img, 0, 0);
                        let dataURL = canvas.toDataURL("image/jpeg", quality);
                        resolve(dataURL)
                    };

                })
            }

            $('#image_user').on('change', function(e){
                prepareImageBase64(e.target.files[0], 0.4).then((url) => {
                    $('.src-image-user').attr('src', url);
                    $('#image_user_url').val(url);
                });
            });

            function populateResourcesDefault(arrayResources) {
                var jsonData = arrayResources;
                var selectResources = $('#selectResourceDefault');
                selectResources.empty();
                jsonData.forEach((function (element) {
                    selectResources.append(`<option ${element.id == resource_default_id ? 'selected="selected"' : ''} value="${element.id}">${element.menu}</option>`);
                }))
            }

        });
    </script>

@endsection
