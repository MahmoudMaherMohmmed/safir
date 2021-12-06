<?php

namespace App\Http\Controllers;

use App\Constants\ContentTypes;
use App\Http\Controllers\Controller;
use App\Http\Repository\CategoryRepository;
use App\Http\Repository\ContentRepository;
use App\Http\Repository\ContentTypeRepository;
use App\Http\Requests\ContentStoreRequest;
use App\Http\Requests\ContentUpdateRequest;
use App\Http\Services\ContentStoreService;
use App\Http\Services\ContentUpdateService;
use App\Http\Repository\LanguageRepository;
use App\Models\Content;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller
{
    /**
     * languageRepository
     *
     * @var LanguageRepository
     */
    private $languageRepository;
    /**
     *
    /**
     * contentRepository
     *
     * @var ContentRepository
     */
    private $contentRepository;
    /**
     * ContentStoreService
     *
     * @var ContentStoreService
     * @var ContentUpdateService
     */
    private $ContentStoreService;
    private $ContentUpdateService;
    /**
     * contentTypeRepository
     *
     * @var ContentTypeRepository
     */
    private $contentTypeRepository;

    /**
     * categoryRepository
     *
     * @var categoryRepository
     */
    private $categoryRepository;
    /**
     * __construct
     *
     * @param  ContentRepository $contentRepository
     * @param  ContentTypeRepository $contentTypeRepository
     * @param  ContentStoreService $ContentStoreService
     * @param  ContentUpdateService $ContentUpdateService
     * @param  CategoryRepository $categoryRepository
     * @param  LanguageRepository $languageRepository
     * @return void
     */
    public function __construct(

        ContentRepository $contentRepository,
        ContentTypeRepository $contentTypeRepository,
        CategoryRepository $categoryRepository,
        ContentStoreService $ContentStoreService,
        ContentUpdateService $ContentUpdateService,
        LanguageRepository $languageRepository
    ) {
        $this->get_privilege();
        $this->contentRepository = $contentRepository;
        $this->ContentStoreService = $ContentStoreService;
        $this->ContentUpdateService = $ContentUpdateService;
        $this->contentTypeRepository = $contentTypeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->languageRepository    = $languageRepository;
    }

    /**
     * index
     * get all content data
     *
     * @return View
     */
    public function index(Request $request)
    {
        $categoryTitle = '';
        if ($request->filled('category_id')) {
            $categoryTitle = $this->categoryRepository->whereId($request->category_id)->first()->title;
        }
        $languages = $this->languageRepository->all();

        return view('content.index', compact('categoryTitle','languages'));
    }

    /**
     * Method allData
     *
     * @param \Illuminate\Http\Request $request (category_id)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allData(Request $request)
    {

        $contents = $this->contentRepository
            ->with(['type', 'category'])
            ->withCount(['rbt_operators', 'operators'])->get();

        if ($request->filled("category_id")) {
            $contents = $contents->where('category_id', $request->category_id);
        }

        return DataTables::of($contents)
            ->addColumn('index', function (Content $content) {
                return '<input type="checkbox" name="selected_rows[]" value="'.$content->id.'" class="roles select_all_template">';
            })
            ->addColumn('id', function (Content $content) {
                return $content->id;
            })
            ->addColumn('title', function (Content $content) {
                return '<ul>
                <li><span style="font-weight: bold;">AR: </span> ' . $content->getTranslation("title", "ar") . '</li>
                <li> <span style="font-weight: bold;">EN: </span>' . $content->getTranslation("title", "en") . '</li>
                </ul>';
            })
            ->addColumn('content', function (Content $content) {
                $contentTypes = new ContentTypes;
                $languages = $this->languageRepository->all();
                return view('content.type', compact('content', 'contentTypes','languages'))->render();
            })
            ->addColumn('content_type', function (Content $content) {
                return $content->type->title;
            })
            ->addColumn('Category', function (Content $content) {
                if (isset($content->category))
                    return $content->category->title;
            })
            ->addColumn('patch number', function (Content $content) {
                if ($content->patch_number) {
                    return $content->patch_number;
                }
                return '---';
            })
            ->addColumn('action', function (Content $value) {
                return view('content.action', compact('value'))->render();
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
        $content = null;
        $content_types = $this->contentTypeRepository->all();
        $categorys = $this->categoryRepository->when(request()->category_id, function ($query) {
            return $query->where('id', request()->category_id);
        })->get();
        $languages = $this->languageRepository->all();

        return view('content.form', compact('content_types', 'content', 'categorys','languages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = $this->contentRepository->with('type')->findOrfail($id);
        return view('content.show_post', compact('content'));
    }

    /**
     * store content data
     *
     * @param  ContentStoreRequest $request
     * @return Redirect
     */
    public function store(ContentStoreRequest $request)
    {
        $this->ContentStoreService->handle($request->validated());

        $request->session()->flash('success', trans('messages.Added Successfully'));

        return redirect('content');
    }

    /**
     * Show the form for editing the specified resource.
     * @param   int  $id
     * @return  View
     */
    public function edit($id)
    {
        $content = $this->contentRepository->with('type')->findOrfail($id);
        $content_types = $this->contentTypeRepository->all();
        $categorys = $this->categoryRepository->all();
        $languages = $this->languageRepository->all();
        return view('content.form', compact('content_types', 'content', 'categorys','languages'));
    }

    /**
     * update
     *
     * @param  int $id
     * @param  ContentUpdateRequest $request
     * @return Redirect
     */
    public function update($id, ContentUpdateRequest $request)
    {
        //  dd($request->all());

        $content = $this->contentRepository->findOrfail($id);

        $this->ContentUpdateService->handle($request->validated(), $id);

        $request->session()->flash('success', trans('messages.updated successfully'));

        return redirect('content');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = $this->contentRepository->findOrfail($id);

        $content->delete();

        \Session::flash('success', trans('messages.has been deleted successfully'));

        return back();
    }
}
