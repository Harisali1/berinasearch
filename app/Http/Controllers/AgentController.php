<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Repositories\AgentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Str;
use Response;

class AgentController extends AppBaseController
{
    /** @var  AgentRepository */
    private $agentRepository;

    public function __construct(AgentRepository $agentRepo)
    {
        $this->agentRepository = $agentRepo;
    }

    /**
     * Display a listing of the Agent.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $agents = $this->agentRepository->paginate(10);

        return view('agents.index')
            ->with('agents', $agents);
    }

    /**
     * Show the form for creating a new Agent.
     *
     * @return Response
     */
    public function create()
    {
        return view('agents.create');
    }

    /**
     * Store a newly created Agent in storage.
     *
     * @param CreateAgentRequest $request
     *
     * @return Response
     */
    public function store(CreateAgentRequest $request)
    {
        $agentData = $request->all();

        if($request->file('image')){
            foreach ($request->file('image') as $value) {
                $name = Str::random(4) . '-' . $value->getClientOriginalName();
                $ImagePath = "/assets//assets/frontend/images/agents/". $name;
                $value->move(public_path() . '/assets//assets/frontend/images/agents/', $name);
                $agentData['image'] = $ImagePath;
            }
        }

        $agent = $this->agentRepository->create($agentData);

        Flash::success('Agent saved successfully.');

        return redirect(route('agents.index'));
    }

    /**
     * Display the specified Agent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agent = $this->agentRepository->find($id);

        if (empty($agent)) {
            Flash::error('Agent not found');

            return redirect(route('agents.index'));
        }




        return view('agents.show')->with('agent', $agent);
    }

    /**
     * Show the form for editing the specified Agent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agent = $this->agentRepository->find($id);

        if (empty($agent)) {
            Flash::error('Agent not found');

            return redirect(route('agents.index'));
        }

        return view('agents.edit')->with('agent', $agent);
    }

    /**
     * Update the specified Agent in storage.
     *
     * @param int $id
     * @param UpdateAgentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgentRequest $request)
    {
        $agent = $this->agentRepository->find($id);

        if (empty($agent)) {
            Flash::error('Agent not found');

            return redirect(route('agents.index'));
        }

        $agentData = $request->all();

        if($request->file('image')){
            foreach ($request->file('image') as $value) {
                $name = Str::random(4) . '-' . $value->getClientOriginalName();
                $ImagePath = "/assets//assets/frontend/images/agents/". $name;
                $value->move(public_path() . '/assets//assets/frontend/images/agents/', $name);
                $agentData['image'] = $ImagePath;
            }
        }

        $agent = $this->agentRepository->update($agentData, $id);

        Flash::success('Agent updated successfully.');

        return redirect(route('agents.index'));
    }

    /**
     * Remove the specified Agent from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agent = $this->agentRepository->find($id);

        if (empty($agent)) {
            Flash::error('Agent not found');

            return redirect(route('agents.index'));
        }

        $this->agentRepository->delete($id);

        Flash::success('Agent deleted successfully.');

        return redirect(route('agents.index'));
    }
}
