<?php

namespace App\Observers;

use App\Resource;

class ResourceObserver
{
    public function saving(Resource $resource) {
        if ($resource->job_candidated) {
            $resource->enterprise_id = null;
            $resource->department_id = null;
            $resource->status_id = null;
            $resource->position_id = null;
            $resource->job_candidated = 1;
        }
    }
}
