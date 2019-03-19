<?php

namespace App\Http\Controllers;

use App\Http\Validators\ValidatesEventRequests;
use App\Models\Event;
use App\Transformers\EventTransform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use ValidatesEventRequests;

    public function __construct()
    {
    }

    /**
     * @param int $id
     * @return
     *
     * @OA\Get(
     *     path="/event/{id}",
     *     tags={"Event"},
     *     summary="get event data",
     *     description="Retorna os dados básicos de um perfil.",
     *     operationId="event/{id}",
     *     security={{"bearerToken":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do perfil",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid token"
     *     )
     * )
     */
    public function get($id)
    {
        if (Gate::denies('view', $this->getUserLogged())) {
            return response()->json(['error' => 'policy: cannot view event data'], 403);
        }
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'event not found'], 404);
        }
        return $this->response->item($event, new EventTransform());
    }

    public function getAll()
    {
        if (Gate::denies('view', $this->getUserLogged())) {
            return response()->json(['error' => 'policy: cannot view events data'], 403);
        }
        $events = Event::all();
        if (!$events) {
            return response()->json(['error' => 'there is no events yet'], 404);
        }
        return $this->response->collection($events, new EventTransform());
    }

    public function post(Request $request, $rawData = false)
    {

        if (Gate::denies('create', $this->getUserLogged())) {
            return response()->json(['error' => 'policy: cannot create a new event'], 403);
        }
        $this->validateNew($request);

        // create
        $event = (new Event())->store([
            'title' => $request->post('title'),
            'starts_at' => $request->post('starts_at'),
            'ends_at' => $request->post('ends_at'),
        ]);
        
        if (!$event) {
            return response()->json(['error' => 'an error occurred while trying to create a event', 'error_list' => $event->getErrors()], 404);
        }
        
        return $rawData ? $event : $this->response->item($event, new EventTransform());
        
    }

    public function put(Request $request, $id)
    {

        if (Gate::denies('update', $this->getUserLogged())) {
            return response()->json(['error' => 'policy: cannot update an existent event'], 403);
        }
        $request['id'] = $id;
        $this->validateUpdate($request);

        // create
        $event = (new Event())->put([
            'id' => $id,
            'title' => $request->post('title'),
            'starts_at' => $request->post('starts_at'),
            'ends_at' => $request->post('ends_at'),
        ]);

        if (!$event) {
            return response()->json(['error' => 'an error occurred while trying to create a event', 'error_list' => $event->getErrors()], 404);
        }

        return $this->response->item($event, new EventTransform());

    }

    public function delete($id)
    {

        if (Gate::denies('delete', $this->getUserLogged())) {
            return response()->json(['error' => 'policy: cannot delete an existent event'], 403);
        }

        // create
        $event = (new Event())->del($id);

        if (!$event) {
            return response()->json(['error' => 'an error occurred while trying to create a event'], 404);
        }

        return $this->response->item($event, new EventTransform());

    }
}
