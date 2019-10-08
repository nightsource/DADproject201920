@extends('master')

@section('metatags')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title', 'List departments')

@section('content')

<div><a class="btn btn-primary" href="{{ route('departments.create')}}">Add department</a></div>

@if (count($departments))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($departments as $department)
        <tr>
            <td>{{$department->name}}</td>
            <td>{{$department->created_at}}</td>
            <td> 
                <a class="btn btn-xs btn-primary" href="{{ route('departments.edit', $department )}}">Edit</a>
                
                <form action="{{route('departments.destroy', $department)}}" method="post" class="inline">
                    {{ method_field('DELETE')}}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                    </div>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
@else
    <h2>No departments found</h2>
@endif
@endsection
@section('pagescript')
    <script src="/js/departments.js"></script>
@endsection