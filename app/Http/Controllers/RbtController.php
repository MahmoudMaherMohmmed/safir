<?php

namespace App\Http\Controllers;

use App\Constants\ContentTypes;
use App\Http\Repository\ContentRepository;
use Illuminate\Http\Request;
use App\Http\Repository\OperatorRepository;
use App\Http\Repository\RbtRepository;
use App\Http\Requests\RbtRequest;
use App\Http\Services\RbtService;
use App\Models\RbtCode;

class RbtController extends Controller
{
    public function __construct(
        RbtRepository $rbtRepository,
        ContentRepository $contentRepository,
        OperatorRepository $operatorRepository,
        RbtService $rbtService
    ) {
        $this->get_privilege();

        $this->rbtService         = $rbtService;
        $this->rbtRepository      = $rbtRepository;
        $this->contentRepository  = $contentRepository;
        $this->operatorRepository = $operatorRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageTitle = '';
        if ($request->filled('operator_id')) {
            $pageTitle = $this->operatorRepository->whereId($request->operator_id)->first()->title;
        }
        if ($request->filled('content_id')) {
            $pageTitle = $this->contentRepository->whereId($request->content_id)->first()->title;
        }

        return view('rbt.index', compact('pageTitle'));
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
        $rbts = $this->rbtRepository
            ->with(['content', 'operator', 'operator.country'])
            ->filter($this->Filter())->get();

        return \DataTables::of($rbts)
            ->addColumn('index', function (RbtCode $rbt) {
                return '<input type="checkbox" name="selected_rows[]" value="'.$rbt->id.'" class="roles select_all_template">';
            })
            ->addColumn('content', function (RbtCode $rbt) {
                return $rbt->content->title;
            })
            ->addColumn('rbt code', function (RbtCode $rbt) {
                return $rbt->rbt_code;
            })
            ->addColumn('operator code', function (RbtCode $rbt) {
                return $rbt->operator->rbt_sms_code;
            })
            ->addColumn('operator', function (RbtCode $rbt) {
                return $rbt->operator->country->title . '-' . $rbt->operator->name;
            })
            ->addColumn('action', function (RbtCode $value) {
                return view('rbt.action', compact('value'))->render();
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contents  = $this->contentRepository->where('content_type_id', ContentTypes::AUDIO)->get();
        $operators = $this->operatorRepository->all();
        $rbt      = NULL;

        return view('rbt.form', compact('contents', 'operators', 'rbt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RbtRequest $request)
    {
        $this->rbtService->handle($request->validated());

        session()->flash('success', trans('messages.Added Successfully'));

        return redirect('rbt/' . $request->content_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contents =  $this->contentRepository->whereId($id)->get();
        return view('rbt.index', compact('contents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $rbt       = $this->rbtRepository->findOrFail($id);
        $contents  = $this->contentRepository->where('content_type_id', ContentTypes::AUDIO)->get();
        $operators = $this->operatorRepository->all();

        return view('rbt.form', compact('rbt', 'contents', 'operators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RbtRequest $request, $id)
    {
        $this->rbtService->handle($request->validated(), $id);

        session()->flash('success', trans('messages.updated successfully'));

        return redirect('rbt/' . $request->content_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $rbt = $this->rbtRepository->findOrFail($id);
        $rbt->delete();
        session()->flash('success', trans('messages.has been deleted successfully'));
        return back();
    }
}
