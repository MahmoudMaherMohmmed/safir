<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\KannelRepository;
use App\Http\Requests\KannelRequest;
use App\Http\Services\KannelService;

class KannelController extends Controller
{
    /**
     * kannelRepository
     *
     * @var KannelRepository
     */
    private $kannelRepository;

    /**
     * kannelService
     *
     * @var KannelService
     */
    private $kannelService;

    /**
     * __construct
     * inject needed data in constructor
     * @param  KannelRepository $kannelRepository
     * @param  KannelService $kannelService
     * @return void
     */
    public function __construct(KannelService $kannelService, KannelRepository $kannelRepository)
    {
        $this->get_privilege();

        $this->kannelRepository    = $kannelRepository;
        $this->kannelService  = $kannelService;

    }

    /**
     * index
     *
     * @return View
     */
    public function index()
    {
        $kannels = $this->kannelRepository->get();
        return view('kannel.index',compact('kannels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $kannel = null;
        return view('kannel.form',compact('kannel'));
    }

    /**
     * store
     *
     * @param  KannelRequest $request
     * @return Redirect
     */
    public function store(KannelRequest $request)
    {
        $this->kannelService->handle($request->validated());
        $request->session()->flash('success', trans('messages.Added Successfully'));
        return redirect('kannel');
    }

    /**
     * show
     *
     * @param  int $id
     * @return View
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        $kannel = $this->kannelRepository->find($id);
        return view('kannel.form',compact('kannel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  KannelRequest $request
     * @param  int $id
     * @return Redirect
     */
    public function update(KannelRequest $request, $id)
    {
        $this->kannelService->handle($request->validated(), $id);
        $request->session()->flash('success', trans('messages.updated successfully'));
        return redirect('kannel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy($id)
    {
        $kannel = $this->kannelRepository->find($id);
        $kannel->delete();
        session()->flash('success', trans('messages.has been deleted successfully'));
        return redirect('kannel');
    }
}
