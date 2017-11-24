<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Idea;
use App\Slack\ScriptyBois;
use App\Casters\IdeaCaster;
use Illuminate\Http\Request;
use App\Contracts\Query\Analyzer;
use App\Http\Requests\IdeaRequest;
use App\Notifications\IdeaCreated;
use App\Contracts\Query\ShouldNotify;

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
     * @param  \App\Casters\IdeaCaster  $caster
     * @return \Illuminate\Http\Response
     */
    public function index(IdeaCaster $caster)
    {
        $ideas = Idea::orderBy('id', 'desc')->paginated(20);

        return response()
            ->json($caster->cast($ideas), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\IdeaRequest  $request
     * @param  \App\Ideas\Analyzer  $analyzer
     * @param  \App\Slack\ScriptyBois  $scriptyBois
     * @return \Illuminate\Http\Response
     */
    public function store(IdeaRequest $request, Analyzer $analyzer, ScriptyBois $scriptyBois)
    {
        // First we retrieve parsed data from the query by running it through
        // our glorious analyzer.
        $builder = $analyzer->analyze($request['query'])->builder();
        $data = $builder->build();

        // Then we create the actual idea and assign it to the user, whom we
        // find by the api token.
        $idea = $request->user()->ideas()->create($data);

        // This part makes sure that provided tags will not be duplicates and
        // attaches them to our new idea.
        collect($data['tags'])->each(function ($tag) use ($idea) {
            $idea->tags()->attach(Tag::firstOrCreate(['name' => $tag]));
        });

        // We add all the attachments that we parsed from the query string.
        $idea->attachments()->createMany($data['attachments']);

        // One last thing before sending the response is to make sure that if
        // the users should be notified about our new idea, we do so.
        if ($builder instanceof ShouldNotify) {
            $scriptyBois->notify(new IdeaCreated($idea));
        }

        // Finally we return a 201 CREATED response with all the data about the
        // new idea.
        return response()
            ->json($idea->cast(), 201);
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
            ->json($idea->cast(), 200);
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
        $idea->delete();

        return response(null, 204);
    }
}
