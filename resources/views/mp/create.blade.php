@extends('layouts.app')

@section('title', trans('company.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Add New Manager</h3></div>

            <form class="" action="/managerpermission" method="post">
              {{ csrf_field() }}
            <div class="panel-body">
                <div class="form-group required ">
                  <label for="manager_id" class="control-label">Manager Id</label>&nbsp;

                  <select class="form-control" name="manager_id">
                    @foreach ($managers as $m)
                    <option value="{{$m->id}}">{{$m->name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group required ">
                  <label for="company_id" class="control-label">Company</label>&nbsp;
                  <select class="form-control" name="company_id">
                    <option value="{{$company->id}}">{{$company->name}}</option>

                  </select>

                </div>


            </div>
            <div class="panel-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="Create Permission">
            </div>
              </form>
        </div>
    </div>
</div>
@endsection
