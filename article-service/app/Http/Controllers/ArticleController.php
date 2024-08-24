<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OpenApi\Annotations as OA;

class ArticleController extends Controller
{

    /**
     * @OA\Post(
     *     path="/articles",
     *     operationId="createArticle",
     *     tags={"Articles"},
     *     summary="Create a new article",
     *     description="Create a new article with the given data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Article created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $article = Article::create($request->all());
        Cache::put('article_'.$article->id, $article, now()->addMinutes(10));
        return response()->json($article, 201);
    }
    
    /**
     * @OA\Get(
     *     path="/articles",
     *     operationId="getArticles",
     *     tags={"Articles"},
     *     summary="Get list of articles",
     *     description="Returns list of articles",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         description="Search keyword in title or body",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="Filter by author's name",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Article"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Article::query();
    
        if ($request->has('query')) {
            $query->where('title', 'like', '%'.$request->query.'%')
                  ->orWhere('body', 'like', '%'.$request->query.'%');
        }
    
        if ($request->has('author')) {
            $query->where('author', $request->author);
        }
    
        $articles = $query->orderBy('created_at', 'desc')->get();
    
        return response()->json($articles);
    }    

    /**
     * @OA\Get(
     *     path="/articles/{id}",
     *     operationId="getArticleById",
     *     tags={"Articles"},
     *     summary="Get article by ID",
     *     description="Returns a single article",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of article to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     )
     * )
     */
    public function show($id)
    {
        $article = Cache::remember('article_'.$id, now()->addMinutes(10), function () use ($id) {
            return Article::findOrFail($id);
        });
    
        return response()->json($article);
    }

}
