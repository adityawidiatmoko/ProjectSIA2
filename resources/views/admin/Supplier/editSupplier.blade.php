@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('supplier.update', [$supplier->kd_supp])}}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <fieldset>
        <legend>Ubah Data Supplier</legend>
        <div class="form-group row">
            <div class="col-md-5">
                <label for="addkdsupp">Kode Supplier</label>
                <input class="form-control" type="text" name="addkdsupp" value="{{$supplier->kd_supp}}" readonly>
            </div>
            <div class="col-md-5">
                <label for="addnmsupp">Nama Supplier</label>
                <input id="addnmsupp" type="text" name="addnmsupp" class="form-control" value="{{$supplier->nm_supp}}">
            </div>
            <div class="col-md-5">
                <label for="Alamat">Alamat</label>
                <input id="addalmsupp" type="text" name="addalmsupp" class="form-control" value="{{$supplier->alamat}}">
            </div>
            <div class="col-md-5">
                <label for="Telepon">Telepon</label>
                <input id="addtlpsupp" type="text" name="addtlpsupp" class="form-control"
                    value="{{$supplier->telepon}}">
            </div>
    </fieldset>
    <div class="col-md-10">
        <input type="submit" class="btn btn-success btn-send" value="Update">
        <a href="{{ route('supplier.index') }}"><input type="Button" class="btn btn-primary btn-send"
                value="Kembali"></a>
    </div>
    <hr>
</form>
@endsection
