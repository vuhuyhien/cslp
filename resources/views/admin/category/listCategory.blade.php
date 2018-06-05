@extends('admin.layouts.admin')

@section('content')
<div class="container">
<div class="card">
  <div class="card-header">
  List Category
  </div>
  <div class="card-body">
  @if (session('status'))
                <div class="alert alert-info">{{session('status')}}</div>
             @endif
  <table class="table ">
  <thead>
    <tr>
      <th class="table-category-iteam" scope="col ">#</th>
      <th class="table-category-iteam" scope="col">Name</th>
      <th class="table-category-iteam" scope="col">Alias</th>
      <th class="table-category-iteam" scope="col">description</th>
      <th class="table-category-iteam" scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($categories as $key => $category)
  <tr>
      <td  class="table-category-iteam" scope="row">{{$key + ($categories->currentPage() -1) * $categories->perPage() +1}}</td>
      <td  class="table-category-iteam"> {{ $category->name }}</td>
      <td  class="table-category-iteam">{{ $category->alias }}</td>
      <td  class="table-category-iteam">{{ $category->description }}</td>
      <td  class="table-category-iteam">
        <a href="{{route('category.edit', $category->id)}}" class="btn btn-primary" role="button" aria-pressed="true">Edit</a>
        <a href="{{route('category-delete',$category->id)}}" class="btn btn-danger" role="button" aria-pressed="true">Delete</a>
      </td>
    </tr>
    @endforeach

  </tbody>
</table>
<div class="row justify-content-center">
{!! $categories->links() !!}
</div>
  </div>
</div>
</div>
@endsection
