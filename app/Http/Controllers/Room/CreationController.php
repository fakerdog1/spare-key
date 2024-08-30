<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Room\Room;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreationController extends Controller
{
    public function create(Request $request)
    {
        $room = $this->getCreateRoom($request);
        $step = $this->getCurrentStep($request);

        if ($step > 1 && !$room) {
            return redirect()->route('room.create');
        }

        return view('room.create', [
            'step' => $step,
            'roomData' => $room ? $room->toArray() : [],
        ]);
    }

    public function store(Request $request)
    {
        $step = $this->getCurrentStep($request);
        $room = $this->getRoom($request);

        $validatedData = $this->getValidatedData($step, $request);

        if ($validatedData instanceof JsonResponse) {
            return $validatedData;
        }

        $this->fillAndSaveRoom($room, $validatedData, $step);
        $this->setSessionRoomId($request, $room);

        if ($step < 3) {
            return $this->redirectToStep($step);
        }

        $this->forgetSessionRoomId($request);
        return redirect()->route('room.show', $room);
    }

    public function show(Room $room)
    {
        $user = auth()->user();
        $userInRoom = $this->checkUserInRoom($room, $user);
        if (!$userInRoom) {
            throw new NotFoundHttpException('Room not found');
        }

        return view('room.show', [
            'room' => $room->load(['users' => function ($query) use ($user) {
                $query->where('users.id', $user->id);
            }])
        ]);
    }

    /**
     * @param Room $room
     * @param User|Authenticatable|null $user
     * @return bool
     */
    public function checkUserInRoom(
        Room $room,
        User|Authenticatable|null $user
    ): bool {
        return $room->users()->where('users.id', $user->id)->exists();
    }

    /**
     * @param Request $request
     * @return int
     */
    public function getCurrentStep(Request $request): int
    {
        return $request->query('step') ?? $request->input('step', 1);
    }

    /**
     * @param Request $request
     * @return Room|Collection|Model|null
     */
    public function getRoom(Request $request): Room|null|Collection|Model {
        $roomId = $this->getSessionRoomId($request);
        return $roomId ? Room::findOrNew($roomId) : new Room();
    }

    /**
     * @param Model|Collection|Room|null $room
     * @param array $validatedData
     * @param int|null $step
     * @return void
     */
    public function fillAndSaveRoom(
        Model|Collection|Room|null $room,
        array $validatedData,
        ?int $step
    ): void {
        $room->fill($validatedData);
        $room->creation_step = $step + 1;
        $room->save();
    }

    /**
     * @param Request $request
     * @param Model|Collection|Room|null $room
     * @return void
     */
    public function setSessionRoomId(
        Request $request,
        Model|Collection|Room|null $room
    ): void {
        $request->session()->put('room_id', $room->id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getSessionRoomId(Request $request): mixed
    {
        return $request->session()->get('room_id');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateRoomDataUrl(Request $request): array
    {
        return $request->validate([
            'property_url' => ['required', 'string', 'url'],
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateRoomDataSpecifications(Request $request): array
    {
        return $request->validate([
            'max_persons' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'is_booked' => ['boolean'],
            'is_private' => ['boolean'],
            'is_democracy' => ['boolean'],
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateRoomDataDates(Request $request): array
    {
        return $request->validate([
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date']
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function invalidStepResponse(): JsonResponse
    {
        dd('invalid');
        return response()->json(['error' => 'Invalid step'], 400);
    }

    /**
     * @param int $step
     * @return RedirectResponse
     */
    public function redirectToStep(int $step): RedirectResponse
    {
        return redirect()->route('room.create', ['step' => $step + 1]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function forgetSessionRoomId(Request $request): void
    {
        $request->session()->forget('room_id');
    }

    /**
     * @param int $step
     * @param Request $request
     * @return array|JsonResponse
     */
    public function getValidatedData(
        int $step,
        Request $request
    ): array|JsonResponse {
        return match ($step) {
            1 => $this->validateRoomDataUrl($request),
            2 => $this->validateRoomDataSpecifications($request),
            3 => $this->validateRoomDataDates($request),
            default => $this->invalidStepResponse(),
        };
    }

    /**
     * @param Request $request
     * @return Collection|Model|null
     */
    public function getCreateRoom(Request $request): null|Collection|Model
    {
        $roomId = $this->getSessionRoomId($request);
        return $roomId ? Room::find($roomId) : null;
    }
}
