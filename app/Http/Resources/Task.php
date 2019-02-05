<?php

namespace App\Http\Resources;

use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'hours' => $this->hours,
            'completed' => $this->completed,
            'due_date' => $this->due_date,
            'client_reviewed' => $this->client_reviewed,
            'client_approved' => $this->client_approved,
            'user' => new UserResource($this->whenLoaded('user')),
            'project' => new ProjectResource($this->whenLoaded('project')),
        ];
    }
}
