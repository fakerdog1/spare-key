<?php

namespace App\Http\Controllers;

use App\Models\Room\Invitation;
use App\Models\Room\Room;
use App\Models\User;
use App\Services\InvitationService;
use Exception;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    protected InvitationService $invitationService;

    public function __construct()
    {
        $this->invitationService = new InvitationService();
    }

    public function create()
    {
        $users = User::all();
        return view('invitations.create', [
            'users' => $users,
        ]);
    }

    public function invitePerson(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'invitee_id' => 'nullable|integer|exists:users,id',
            'email' => 'required_if:invitee_id,null|email',
        ]);

        $room = $this->getRoom($validatedData);
        $invitee = $this->getInvitee($validatedData);
        $email = $request->input('email');

        $this->invitationService->invite(
            $invitee,
            $room,
            Invitation::TYPE_PERSONAL,
            $email
        );

        return response()->json([
            'message' => 'Invitation sent successfully',
        ]);
    }

    public function inviteMultiplePerson(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'invitees' => 'required|array',
        ]);

        $room = $this->getRoom($validatedData);
        $invitees = $validatedData['invitees'];


        foreach ($invitees as $invitee) {
            $name = data_get($invitee, 'name');
            $email = data_get($invitee, 'email');

            $inviteeUser = (new User())
                ->when($name, function ($query) use ($name) {
                    return $query->where('name', $name);
                })
                ->when($email, function ($query) use ($email) {
                    return $query->where('email', $email);
                })
                ->first();
            
            $this->invitationService->invite(
                $inviteeUser,
                $room,
                'personal',
                $email
            );
        }

        return response()->json([
            'message' => 'Invitations sent successfully',
        ]);
    }

    public function inviteGroup(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
        ]);

        $room = $this->getRoom($validatedData);
        $this->invitationService->invite(null, $room);

        return response()->json([
            'message' => 'Invitation sent successfully',
        ]);
    }

    /**
     * @throws Exception
     */
    public function accept(Request $request)
    {
        $validatedData = $request->validate([
            'invitation_id' => 'integer|exists:invitations,id',
            'token' => 'required_if:invitation_id,null|string|exists:invitations,token',
        ]);

        $invitation = $this->getInvitation($validatedData);
        $invitationService =
            new InvitationService($invitation, $validatedData['token']);
        $invitationService->acceptInvite();

        return response()->json([
            'message' => 'Invitation accepted successfully',
        ]);
    }

    /**
     * @throws Exception
     */
    public function decline(Request $request)
    {
        $validatedData = $request->validate([
            'invitation_id' => 'integer|exists:invitations,id',
            'token' => 'required_if:invitation_id,null|string|exists:invitations,token',
        ]);

        $invitation = $this->getInvitation($validatedData);
        $invitationService =
            new InvitationService($invitation, $validatedData['token']);
        $invitationService->declineInvite();

        return response()->json([
            'message' => 'Invitation declined successfully',
        ]);
    }

    /**
     * @throws Exception
     */
    public function cancel(Request $request)
    {
        $validatedData = $request->validate([
            'invitation_id' => 'integer|exists:invitations,id',
            'token' => 'required_if:invitation_id,null|string|exists:invitations,token',
        ]);

        $invitation = $this->getInvitation($validatedData);
        $invitationService =
            new InvitationService($invitation, $validatedData['token']);
        $invitationService->cancelInvite();

        return response()->json([
            'message' => 'Invitation canceled successfully',
        ]);
    }

    protected function getRoom(array $validatedData): ?Room
    {
        $roomId = data_get($validatedData, 'room_id');
        return Room::findOrFail($roomId);
    }

    protected function getInvitee(array $validatedData): ?User
    {
        $inviteeId = data_get($validatedData, 'invitee_id');
        return $inviteeId ? User::findOrFail($inviteeId) : null;
    }

    protected function getInvitation(array $validatedData): ?Invitation
    {
        $invitationId = data_get($validatedData, 'invitation_id');
        return $invitationId ? Invitation::findOrFail($invitationId) : null;
    }
}
