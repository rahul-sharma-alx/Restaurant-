<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Food List</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="col-md-12 my-10 shadow p-3 mb-5 bg-white rounded">
                <h1 class="text-center">Food List</h1>
                <a href="{{ url('/upload') }}" class="btn btn-primary">Insert new</a>
                <form class="form-inline my-2 my-lg-0" action="{{ route('search_food') }}"  method="get">
                    @csrf
                    <input class="form-control mr-sm-2" type="search" name="search_item" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
                    @if(request()->has('search') && !empty(request()->input('search_item')))
                        <a href="{{ route('food.list') }}" class="btn btn-outline-secondary my-2 my-sm-0 ml-2"><i class="fas fa-undo"></i> Cancel Search</a>
                    @endif
                </form>

                <div class="">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"><a href="{{url('short/1')}}">SN</a><th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Ingredients</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($foods as $fd)
                        <tr>
                            <td>{{ $fd->id }}</td>
                            <td></td>
                            <td><img src="{{ asset('uploads/'.$fd->image) }}" alt="" width="50" class="img-thumbnail"></td>
                            <td>{{ $fd->title }}</td>
                            <td>{{ $fd->category }}</td>
                            <td>{{ $fd->ingredients }}</td>
                            <td>{{ $fd->description }}</td>
                            <td>{{ $fd->price }}</td>
                            <td>{{ $fd->status }}</td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a href="{{ url('edit/'.$fd->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ url('food/'.$fd->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                    </form>
                                    <a href="{{ url('restore/'.$fd->id) }}" class="btn btn-primary">Restore</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>