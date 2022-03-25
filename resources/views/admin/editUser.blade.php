@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('user.update', [$user->id])}}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <fieldset>
        <legend>Ubah Data User</legend>
        <div class="form-group">
            <label class="col-lg-3 control-label">Nama User</label>
            <div class="col-lg">
                <input type="text" name="username" value="{{ $user->name }}" readonly required class="form-control">
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Email User</label>
                <div class="col-lg">
                    <input type="email" name="email" value="{{ $user->email }}" readonly required class="form-control">
                </div>
                <div class="form-group"><label class="col-lg-3 control-label">Roles/Akses</label>
                    <div class="col-lg">
                        <select id="roles" name="role" class="form-control" required>
                            <option value="">--Pilih Roles--</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role}}" {{$role==$userRole[0] ? ' selected':' hehe'}}>{{ $role}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="col-md-10">
        <input type="submit" class="btn btn-success btn-send" value="Update">
        <a href="{{ route('user.index') }}"><input type="Button" class="btn btn-primary btn-send" value="Kembali"></a>
    </div>
    <hr>
</form>
@endsection
