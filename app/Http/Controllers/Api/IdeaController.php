<?php

namespace App\Http\Controllers\Api;

use App\Models\Idea;
use App\Contracts\Query\Analyzer;
use App\Http\Requests\IdeaRequest;
use App\Http\Controllers\Controller;

class IdeaController extends Controller
{
    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Idea::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ideas = Idea::all();

        return response()
            ->json($ideas->load(['tags', 'attachments']), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\IdeaRequest  $request
     * @param  \App\Ideas\Analyzer  $analyzer
     * @return \Illuminate\Http\Response
     */
    public function store(IdeaRequest $request, Analyzer $analyzer)
    {
        dd($analyzer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        return response()
            ->json($idea->load(['tags', 'attachments']), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\IdeaRequest  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        // $idea->delete();

        return response(null, 204);
    }
}
