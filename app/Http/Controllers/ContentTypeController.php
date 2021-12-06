<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\ContentTypeRepository;
use App\Http\Requests\ContentTypeStoreRequest;
use App\Http\Requests\ContentTypeUpdateRequest;
use App\Http\Services\ContentTypeService;
use Illuminate\Support\Facades\Session;
use Config;

class ContentTypeController extends Controller
{
    /**
     * contentTypeRepository
     *
     * @var ContentTypeRepository
     */
    private $contentTypeRepository;
    /**
     * contentTypeService
     *
     * @var ContentTypeService
     */
    private $contentTypeService;

    /**
     * __construct
     * inject needed data in constructor
     * @param  ContentTypeRepository $contentTypeRepository
     * @param  ContentTypeService $contentTypeService
     * @return void
     */
    public function __construct(ContentTypeRepository $contentTypeRepository, ContentTypeService $contentTypeService)
    {
        $this->get_privilege();
        $this->contentTypeRepository    = $contentTypeRepository;
        $this->contentTypeService    = $contentTypeService;
    }
    /**
     * get all contentType
     *
     * @return View
     */
    public function index()
    {
    	$contentTypes = $this->contentTypeRepository->all();
    	return view('content_type.index',compact('contentTypes'));
    }

    /**
     * get page for create contentType
     *
     * @return View
     */
    public function create()
    {
    	$contentType = null;
    	return view('content_type.form',compact('content_type'));
    }

    /**
     * store ContentType Data
     *
     * @param  ContentTypeStoreRequest $request
     * @return Redirect
     */
    public function store(ContentTypeStoreRequest $request)
    {
    	$contentType = $this->contentTypeService->handle($request->validated());
    	$request->session()->flash('success', trans('messages.Added Successfully'));
    	return redirect('contentType');
    }

    /**
     * get page for update contentType
     *
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
    	$contentType = $this->contentTypeRepository->find($id);
    	return view('content_type.form',compact('content_type'));
    }

    /**
     * update ContentType Data
     *
     * @param  int $id
     * @param  ContentTypeUpdateRequest $request
     * @return redirect
     */
    public function update($id,ContentTypeUpdateRequest $request)
    {
    	$this->contentTypeService->handle($request->validated(), $id);
    	$request->session()->flash('success', trans('messages.updated successfully'));
    	return redirect('contentType');
    }

    /**
     * remove contentType data
     *
     * @param  int $id
     * @return redirect
     */
    public function destroy($id)
    {
    	$this->contentTypeRepository->destroy($id);
    	\Session::flash('success', trans('messages.has been deleted successfully'));
    	return redirect('contentType');
    }
}
