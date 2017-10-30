<?php

namespace App;

use App\ApiCall;
use App\Http\Helpers\AgentsHelper;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany('App\AgentPhoto', 'agent_id');
    }

    public static function searchResults($request)
    {
        $shortId       = $request->shortId ?? '';
        $fullName      = $request->fullName ?? '';
        $lastName      = $request->lastName ?? '';
        $firstName     = $request->firstName ?? '';
        $association   = $request->association ?? '';
        $officeShortId = $request->officeShortId ?? '';

        $agents = Agent::when($shortId, function ($query) use ($shortId) {
            return $query->where('short_id', $shortId);
        })
        ->when($fullName, function ($query) use ($fullName) {
            return $query->where('full_name', $fullName);
        })
        ->when($lastName, function ($query) use ($lastName) {
            return $query->where('last_name', $lastName);
        })
        ->when($firstName, function ($query) use ($firstName) {
            return $query->where('first_name', $firstName);
        })
        ->when($association, function ($query) use ($association) {
            return $query->where('association', $association);
        })
        ->when($officeShortId, function ($query) use ($officeShortId) {
            return $query->where('office_short_id', $officeShortId);
        })
        ->with('photos')
        ->orderBy('last_name', 'ASC')
        ->paginate(36);

        // returns paginated links (with GET variables intact!)
        $agents->appends($request->all())->links();

        return $agents;
    }
}