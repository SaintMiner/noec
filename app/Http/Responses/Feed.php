<?php
namespace App\Http\Responses;

use App\Resource;
use Illuminate\Contracts\Support\Responsable;

class Feed implements Responsable
{
    private $resources;


    public function toResponse($request)
    {
        $this->setFeed($request);
        return $this->feedVacations();
    }
    
    public function setFeed($request)
    {
        
        $filters = json_decode($request->get('filters'));

       // $this->resources = Resource::with('department')
        $query = Resource::with("department", "enterprise", "status", "position");


        if($filters->search) {
            $query->where('name', 'like', '%' . $filters->search . '%')->orWhere('surname', 'like', '%' . $filters->search . '%');
        }
        if ($filters->enterprise) {
            $query->where("enterprise_id", "=", $filters->enterprise);
        }
        if ($filters->department) {
            $query->where("department_id", "=", $filters->department);
        }

        $this->resources = $query->get();
        /*
        ->between($filters->interval->date)
        ->get();
        //$this->feedStatuses = AbsenceType::whereAbsenceGroupId("1")->get();
        */
       // $this->feedStatuses = AbsenceGroup::get();
        
        
        
       /* $this->feedPeople = Person::with(['user.avatar'])
        ->ForDepartments($filters->departmentIds)
        ->latest()
        ->get();
        */

    }
    private function feedVacations()
    {
        return [
            $this->resources->map(function ($item) {
                return $this->resourceResource($item);
            }, 
                []
            )
        ];
    }

    private function resourceResource($item)
    {
       
        return [
            "id" => $item->id,
            "name" => $item->name,
            "surname" => $item->surname,
            "nameSurname" => "$item->name $item->surname",
            "department" => $item->department,
            "enterprise" => $item->enterprise,
            "status" => $item->status,
            "position" => $item->position,
        ];
    }

    private function departmentResource($item)
    {
        return [
            'name' => $item->name
        ];
    }

}