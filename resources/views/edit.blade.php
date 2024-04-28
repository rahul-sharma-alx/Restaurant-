<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header dark">Insert Data</div>
                    <div class="card-body">

                        <form method="post" action="{{ url('/upload'.$food->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input id="title" type="text" class="form-control" name="title" value="{{$food->title}}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <input id="category" type="text" class="form-control" value="{{$food->category}}" name="category" required>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input id="image" type="file" class="form-control-file" value="{{$food->image}}" name="image">
                                <img src="{{ asset('uploads/'.$food->image) }}" alt="food image" width="100" class="img-thumbnail">
                            </div>

                            <div class="form-group">
                                <label for="ingredients">Ingredients</label>
                                <textarea id="ingredients" class="form-control" value="{{$food->ingredients}}" name="ingredients" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" value="{{$food->description}}" name="description" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input id="price" type="number" class="form-control" value="{{$food->price}}" name="price" step="0.01" required>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="status" value="{{$food->status}}" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

