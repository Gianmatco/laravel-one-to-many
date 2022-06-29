@extends('layouts.admin')

@section('content')
<form action="{{route('admin.posts.store')}}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">title</label>
      <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="Inseerisci Titolo">
    </div>
    <div class="mb-3">
      <label for="content" class="form-label">Content</label>
      <textarea name="content" id="content"   cols="30" rows="10">{{old('content')}}</textarea>
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">category</label>
      <select name="category_id" id="category" class="form-control">
        <option value="">Select category</option>
        @foreach ($categories as $category )
          <option value="{{$category->id}}">{{$category->name}}</option>
            
        @endforeach
        
      </select>
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" {{old('published') ? 'checked': ''}}    id="Published" name="published">
      <label class="form-check-label" for="published">Pubblicato</label> 
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
    
@endsection