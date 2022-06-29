<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Post;
use App\Category;

class PostController extends Controller
{
    protected $validaionRule =[
        "title" => "required|string|max:100",
        "content" => "required",
        "published" => "sometimes|accepted",
        "category_id" => "nullable|existsù.categories,id",
        "image" => "nullable|image|mimes:jpeg,bmp,png|max:2048",
        "tags" => "nullable|exists:tags,id"
    ]; 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->vallidationRule);
        $data = $request->all();
        $newPost= new Post();
        $newPost->title = $data['title'];
        $newPost->content = $data['content'];
        $newPost->published = isset($data['published']);
        $newPost->category_id = $data['category_id'];

        // $count = 1;
        // while(Post::where('slug',$slug)->first()){  //ripassare le query su eloquent
        //     $slug = Str::of($data['title'])->slug("-") . "-{$count}";
        //     $count++;

        // } 
        $newPost->slug = $this->getSlug($newPost->title);
        $newPost->save();

        return redirect()->route('admin.posts.show',$newPost->id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //Post $post o $id
    {
        $post = Post::findOrFail($id);   //<--- scrviamo questo quando nella show mettiamo $id
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->vallidationRule);
        $data = $request->all();
        if($post->title != $data['title']){
            $post->title = $data['title'];
            $slug = Str::of($post->title)->slug("-");
            if($slug != $post->slug){
                $post->slug = $this->getSlug($post->title);
            }

        };
        $post->category_id = $data['category_id'];
        $post->content = $data['content'];
        $post->published = isset($data["published"]);
        $post->update();
        return redirect()->route('admin.posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.post.index')->with("message","Post with id: [$post->id} successfully deleted !");
    }
     /** 
      *Generate an unique slug
      *
      * @param string $title
      * @return string 
     */
    private function getSlug($title)
    {
        $slug = Str::of($title)->slug("-");
        $count = 1;

        //prendi il primo post il cui slug è uguale a $slug
        //se è presente allora genero un nuovo slug aggiungendo -$count
        while( Post::where("slug", $slug)->first()){ //se non trova niente diventa null 
            $slug = Str::of($title)->slug("-") . "-{$count}";
            $count++;
        }
    }
}
