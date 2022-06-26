@extends('layouts.admin')

@section('content')
<a href="{{route('admin.posts.create')}}" class="btn btn-primary">crea nuovo post</a>
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">title</th>
        <th scope="col">data creazione</th>
        <th scope="col">modifica</th>

        
      </tr>
    </thead>
    <tbody>
    @foreach ($posts as $post)
      <tr>
        <td> <a href="{{route('admin.posts.show',$post->id)}}">{{$post->id}} </td>
        <td> <a href="{{route('admin.posts.show',$post->id)}}">{{$post->title}} </td>
        <td>{{$post->created_at}}</td>
        <td><a href="{{route('admin.posts.edit', $post->id)}}" class="btn btn-primary">modifica</a></td>
      </tr>
          
    @endforeach
      
    </tbody>
</table>
    
@endsection