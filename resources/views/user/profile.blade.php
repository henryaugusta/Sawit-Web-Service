@extends('layouts.template')

@section('script')
    <script>
        window.onload = function () {
            CKEDITOR.replace('content', {
                filebrowserImageBrowseUrl: '/filemanager?type=Images',
                filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/filemanager?type=Files',
                filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
            })

            // jQuery and everything else is loaded
            var el = document.getElementById('input-image');
            el.onchange = function () {
                var fileReader = new FileReader();
                fileReader.readAsDataURL(document.getElementById("input-image").files[0])
                fileReader.onload = function (oFREvent) {
                    document.getElementById("pot1").src = oFREvent.target.result;
                    document.getElementById("pot2").src = oFREvent.target.result;
                };
            }

        }
    </script>
@endsection

@section('main')

    <div class="panel-header">
        <div class="page-inner border-bottom pb-0 mb-3">
            <div class="d-flex align-items-left flex-column">
                <h2 class="pb-2 fw-bold">Profile Saya</h2>
            </div>
        </div>
    </div>
    <div class="page-inner">
        <div class="container-fluid">
            @include('layouts.error')
        </div>
        @if($user->status==0)
            <div class="container-fluid">
                <div class="alert alert-danger fade show" role="alert">
                    <strong> Akun user ini sedang dalam status suspend </strong>
                </div>
            </div>
        @endif
        <h1 class="page-title">User Profile</h1>
        <div class="row">
            <div class="col-md-7">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="row row-nav-line">
                            <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab"
                                       href="#home"
                                       role="tab" aria-selected="true">Profile</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('user/profile/update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control "
                                       name="nama_pengguna" placeholder="Nama Lengkap"
                                       value="{{old('nama_pengguna',$user->name)}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control "
                                       value="{{old('email',$user->email)}}"
                                       name="email"
                                       placeholder="Email">
                                <small class="text-muted">Email ini akan digunakan Untuk Login</small>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control "
                                       value="{{old('contact',$user->contact)}}"
                                       name="contact"
                                       placeholder="contact">
                                <small class="text-muted">Nomor Ini Akan Digunakan Untuk Login</small>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control "
                                       value="{{old('tanggal_lahir',$user->date_birth)}}"
                                       name="tanggal_lahir"
                                       placeholder="Tanggal Lahir">
                            </div>

                            @php
                                $gender = $user->gender;
                            @endphp
                            <div class="form-group">
                                <label for="">Jenis Kelamin</label>
                                <select class="form-control" name="gender" id="">
                                    <option value="1" {{$gender==1 ? 'selected' : ''}}>Laki-Laki</option>
                                    <option value="2" {{$gender==2 ? 'selected' : ''}}>Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Ganti Foto Profile</label>
                                <input type="file" class="form-control-file" name="image" id="input-image" placeholder=""
                                       aria-describedby="fileHelpId">
                                <small id="fileHelpId" class="form-text text-muted">Klik Disini Untuk
                                    Upload/Ganti Foto
                                    Profile</small>
                            </div>
                            <div class="text-right mt-3 mb-3">
                                <button class="btn btn-success">Save</button>
                                <button class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-with-nav col-md-12 col-12">
                    <form action="{{url('user/change_user_password')}}" method="post">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="card-header">
                            <div class="row row-nav-line">
                                <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#settings"
                                           role="tab"
                                           aria-selected="false">Ganti Password</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password Lama</label>
                                        <input type="text"
                                               class="form-control "
                                               name="old_password" placeholder="Password Lama">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <input type="text"
                                               class="form-control "
                                               name="new_password" placeholder="Password Baru">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Ulangi Password Baru</label>
                                        <input
                                            type="text"
                                            class="form-control "
                                            name="confirm_password"
                                            placeholder="Masukan Ulang Password Baru">
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-3 mb-3">
                                <button type="submit" class="btn btn-outline-primary">Ganti Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-profile">
                    <div class="card-header"
                         style="background-image: url('https://mk0oneearthbodyj0l9s.kinstacdn.com/wp-content/uploads/2015/02/oil-palm.-www.foodnavigator.com_-1170x660.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <div class="avatar-xl float-left mr-2">
                                    <img id="pot1" src='{{asset('photo/profile'."/".$user->profile_url)}}?{{time()}}'
                                         alt="..."
                                         class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{$user->name}}</div>
                        </div>
                    </div>
                    @php
                        $status = $user->status;
                        $role = $user->role;
                    @endphp
                    <div class="card-footer">
                        <form action="{{url('user/change_status')}}" method="post">
                            @method('post')
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="row user-stats text-center">
                                <div class="form-group col-md-6 col-12">
                                    <label for="">Status Akun</label>
                                    <select class="form-control" name="status" id="">
                                        <option value="0" {{$status==0 ? 'selected' : ''}}>Suspend</option>
                                        <option value="1" {{$role==1 ? 'selected' : ''}}>Active</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="">Tipe Akun</label>
                                    <select class="form-control" name="role" id="">
                                        <option value="3" {{$role==3 ? 'selected' : ''}}>Customer</option>
                                        <option value="2" {{$role==2 ? 'selected' : ''}}>Staff</option>
                                        <option value="1" {{$role==1 ? 'selected' : ''}}>Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-right mt-3 mb-3">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <div class="avatar-xl float-left mr-2">
                                    <img id="pot2" src='{{asset('photo/profile'."/".$user->profile_url)}}?{{time()}}'
                                         alt="..."
                                         class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{$user->name}}</div>
                        </div>
                    </div>
                    <div class="card-footer d-none">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number">125</div>
                                <div class="title">Post</div>
                            </div>
                            <div class="col">
                                <div class="number">25K</div>
                                <div class="title">Followers</div>
                            </div>
                            <div class="col">
                                <div class="number">134</div>
                                <div class="title">Following</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

