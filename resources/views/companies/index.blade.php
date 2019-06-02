@extends('layouts.app')

@section('title', trans('company.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">

      @if (auth()->user()->role == "admin")
          {{ link_to_route('companies.create', trans('company.create'), [], ['class' => 'btn btn-success']) }}
      @endif
    </div>
    {{ trans('company.list') }}
    <small>{{ trans('app.total') }} : {{ $companies->total() }} {{ trans('company.company') }}</small>
</h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => trans('company.search'), 'class' => 'input-sm']) !!}
                {{ Form::submit(trans('company.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('companies.index', trans('app.reset')) }}
               <div class="bg_green" style="height:26px;display: inline-block; border-radius: 6px;padding:3px;margin-left:4px;"> User Has Access</div>
                {{ Form::close() }}
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('company.name') }}</th>
                        <th>{{ trans('company.email') }}</th>
                        <th>{{ trans('company.website') }}</th>
                        <th>{{ trans('company.address') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $key => $company)
                      @php    auth()->user()->can_manage_company($company) ? $color = "bg_green": $color = ""  @endphp
                        <td  class="text-center {{$color}}  ">{{ $companies->firstItem() + $key }}</td>
                        <td class="{{$color}}">{{ $company->name }}</td>
                        <td class="{{$color}}">{{ $company->email }}</td>
                        <td class="{{$color}}">{{ $company->website }}</td>
                        <td class="{{$color}}">{{ $company->address }}</td>
                        <td class="text-center {{$color}}">
                        @can('view', $company)
                            {!! link_to_route(
                                'companies.show',
                                trans('app.show'),
                                [$company],
                                ['class' => 'btn btn-default btn-xs', 'id' => 'show-company-' . $company->id]
                            ) !!}
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-body">{{ $companies->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>








@endsection
