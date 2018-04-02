<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\Category;
use App\Models\Tag;


class ArticleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('first');
        $this->middleware('exist.article');
	//TODO: add middleware check articleexist.article
    }


    public function index()
    {
        //от {{$article->author()->name}} в категории {{$article->category()->name}}
        $articles = Article::where('status', 'published')->get();//Auth::user()->articles;
        $title = count($articles);
        return view('article.test', ['title' => $title,
                     'articles' => $articles]);

    }


    public function get($id)
    {
        $article = Article::find($id);
	$isOwner=(($article->author->id)==(Auth::user()->id));
	$isModerator=((Auth::user()->role=='moderator')||(Auth::user()->role=='admin'));
        return view('article.view', [
        'title' => $article->name,
        'isOwner' => $isOwner,
        'isModerator' => $isModerator,
        'article' => $article]);
    }


    public function postComment($id, Request $request)
    {
        $article = Article::find($id);
        $user = Auth::user();
        $comment = Comment::create(['text' => $request['text'],
                  'date' => new \DateTime(),
                  'user_id' => $user->id,
                  'article_id' => $article->id]);
        return redirect()->back();

    }


    public function createArticlePage(Request $request)
    {
        $categories = Category::all();
        $alltags = Tag::all();
        return view('article.create', [
        'title' => 'Новая статья',
        'categories' => $categories,
        'alltags' => $alltags]);

    }


    public function editArticlePage($id, Request $request)
    {
        $categories = Category::all();
        $alltags = Tag::all();
	$article=Article::find($id);
	$texttags = '';
	$isFirst=true;
        foreach ($article->tags as $tag) {
                if ($isFirst) {
                    $isFirst = false;
                } else {
                    $texttags .= ',';
                }

                $texttags .= $tag->id;
            }
        return view('article.create', [
        'title' => 'Новая статья',
        'categories' => $categories,
        'article' => $article,
        'texttags' => $texttags,
        'alltags' => $alltags]);

    }

    public function createArticle(Request $request)
    {
        return $this->postArticle(0, $request);

    }


    public function postArticle($id, Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|min:3',
            'description'    => 'required|string|min:6',
            'text' => 'required|string|min:6',
            'categories' => 'required',
        ]);
        $f = $request->file('img');
	$files=$request->file('files');
        $user = Auth::user();
        //$path = Storage::putFileAs('/', $f, $f->getClientOriginalName());
        $tags = Tag::find($request['tags']);
        $destinationPath = public_path('/');
        
        if ($id == 0) {
	    $fname = $f->getClientOriginalName();
            $f->move($destinationPath, $f->getClientOriginalName());
            $file = File::create(['name' => $fname, 'article_id' => $id]);
	
            $article = Article::create(['name' => $validatedData['name'],
                      'description' => $validatedData['description'],
                      'text' => $validatedData['text'],
                      'category_id' => $validatedData['categories'],
                      'file_id' => $file->id,
                      'user_id' => $user->id,
                      'status' => 'new',
                      'comments_count' => 0,
                      'date' => new \DateTime(),
                      'views' => 0]);
	    $id=$article->id;
	    $file->article_id=$article->id;
	    $file->save();
        } else {
	    $article = Article::find($id);
	    $article->name=$validatedData['name'];
	    $article->description=$validatedData['description'];
	    $article->text=$validatedData['text'];
	    $article->category_id=$validatedData['categories'];
	    $article->status='new';
	    if($f!=null){
		$fname = $f->getClientOriginalName();
        	$file=$article->foto;
		unlink(public_path('/'.$file->name));
		$f->move($destinationPath, $f->getClientOriginalName());
		$file->name=$fname;
	    }
	    $article->save();
        }
	if($files){
	    foreach ($files as $file0){
	    	$file0->move($destinationPath, $file0->getClientOriginalName());
	    	$ffile = File::create(['name' => $file0->getClientOriginalName(), 'article_id' => $id]);
	    }
	}
	if($tags!=null){
            $article->tags()->detach();
	    $article->tags()->saveMany($tags);
	}
	return redirect('/article/' . $article->id);

    }

    public function statusModerated($id)
    {
        $article = Article::find($id);
	if(($article->author->id==Auth::user()->id)&&$article->status=='new'){
	    $article->status='moderated';
	    $article->save();
	    return view('moderator.successfully', [
            'title' => 'Ваша статья отправлена на модерацию',
            'listType' => 'user',
            'article' => $article]);
	}
	// TODO: error
        return null;
    }


    public function removeArticle($id)
    {
        $article = Article::find($id);
	$article->delete();
	return redirect()->route('articles');
    }

    /*
    <div class="row">
        @each('comment.view', $article->comments, 'comment')
        <div>
    */
}
