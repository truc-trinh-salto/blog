<?php 
namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{

    public function welcome(){

        //Get current Route's name, action
        $route = Route::current(); // Illuminate\Routing\Route
        $name = Route::currentRouteName(); // string
        $action = Route::currentRouteAction(); // String

        echo $name;
        echo $action;
        
        return view('auth.login');
    }

    public function home(){
        // var_dump($categories);
        $categories = Category::where('category_id',1)->cursorPaginate(1);
        
        return view('user.home',['categories' => $categories]);
    }
    public function getAll(Request $request)
    {
        $posts = Post::all();

        foreach($posts as $post){
            echo $post->title;
        }
        return response('Hello World')->cookie('name','value',$minutes=1);
    }

    public function delete($postId){

        $isDeleted = Post::where('post_id', $postId)->delete();;

        return $isDeleted;
    }

    public function restore($postId){
        $isRestore = Post::withTrashed()->where('post_id', $postId)->restore();

        return $isRestore;
    }
}