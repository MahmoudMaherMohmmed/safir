<?php

namespace App\Http\Controllers;

use App\Constants\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Http\Repository\ContentRepository;
use App\Http\Repository\PostRepository;
use App\Http\Repository\OperatorRepository;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Services\PostStoreService;
use App\Http\Services\PostUpdateService;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;
    /**
     * @var PostStoreService
     */
    private $postStoreService;
    /**
     * @var PostUpdateService
     */
    private $postUpdateService;
    /**
     * @var OperatorRepository
     */
    private $operatorRepository;
    /**
     * @var ContentRepository
     */
    private $contentRepository;
    /**
     * __construct
     *
     * @param  PostRepository $postRepository
     * @param  OperatorRepository $operatorRepository
     * @param  ContentRepository $contentRepository
     * @param  PostStoreService $postStoreService
     * @param  PostUpdateService $postUpdateService
     * @return void
     */
    public function __construct(
        PostRepository $postRepository,
        OperatorRepository $operatorRepository,
        ContentRepository $contentRepository,
        PostStoreService $postStoreService,
        PostUpdateService $postUpdateService
    ) {

        $this->get_privilege();

        $this->postRepository = $postRepository;
        $this->postStoreService = $postStoreService;
        $this->postUpdateService = $postUpdateService;
        $this->operatorRepository = $operatorRepository;
        $this->contentRepository = $contentRepository;
    }

    /**
     * index
     * get all post data
     * @return View
     */
    public function index(Request $request)
    {
        $pageTitle = '';
        if($request->filled('operator_id')) {
            $pageTitle = $this->operatorRepository->whereId($request->operator_id)->first()->title;

        }
        if($request->filled('content_id')) {
            $pageTitle = $this->contentRepository->whereId($request->content_id)->first()->title;
        }
        return view('post.index', compact('pageTitle'));
    }

    /**
     * Method allData
     *
     * @param \Illuminate\Http\Request $request (parent_id)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allData(Request $request)
    {
        $posts = $this->postRepository
                        ->with(['operator', 'content' , 'operator.country'])
                        ->filter($this->Filter())->get();

        return \DataTables::of($posts)
            ->addColumn('index', function(Post $post) {
                return '<input type="checkbox" name="selected_rows[]" value="'.$post->id.'" class="roles select_all_template">';
            })
            ->addColumn('content', function(Post $post) {
                return $post->content->title;
            })
            ->addColumn('published date', function(Post $post) {
                return $post->published_date;
            })
            ->addColumn('status', function(Post $post) {
                return ActiveStatus::getLabel($post->active);
            })
            ->addColumn('url', function(Post $post) {
                return view('post.post_link', compact('post'))->render();
            })
            ->addColumn('user', function(Post $post) {
                return $post->user->name;
            })
            ->addColumn('action', function(Post $post) {
                return view('post.action', compact('post'))->render();
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  View
     */
    public function create()
    {
        $operators = $this->operatorRepository->all();
        $contents = $this->contentRepository->all();
        $post = null;
        return view('post.form',compact('post' ,'operators', 'contents'));
    }

    /**
     * store post data
     *
     * @param  PostStoreRequest $request
     * @return Redirect
     */
    public function store(PostStoreRequest $request)
    {
        $this->postStoreService->handle($request->validated());

        $request->session()->flash('success', trans('messages.Added Successfully'));

        return redirect('post');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int  $id
     * @return  View
     */
    public function edit($id)
    {
        $post = $this->postRepository->findOrfail($id);
        $operators = $this->operatorRepository->all();
        $contents = $this->contentRepository->all();

        return view('post.form',compact('post', 'operators', 'contents'));
    }

    /**
     * update
     *
     * @param  int $id
     * @param  PostUpdateRequest $request
     * @return Redirect
     */
    public function update($id, PostUpdateRequest $request)
    {
        $post = $this->postRepository->findOrfail($id);

        $this->postUpdateService->handle($request->validated(), $post);

        $request->session()->flash('success', trans('messages.updated successfully'));

        return redirect('post');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->findOrfail($id);

        $post->delete();

        session()->flash('success', trans('messages.has been deleted successfully'));

        return back();
    }
}
