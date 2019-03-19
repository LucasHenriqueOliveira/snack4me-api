<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $errors = [];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'starts_at',
        'ends_at'
    ];

    public function store($data) {
        try {
            $event = self::firstOrNew(['title' => strtolower($data['title'])]);
            if (!empty($event->id)) {
                throw new \Exception('event exists');
            }
            $event_fields = [
                'title'      => $data['title'],
                'starts_at'  => $data['starts_at'],
                'ends_at'    => $data['ends_at'],
            ];
            $event = self::create($event_fields);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return $e->getMessage();
        }
        return $event;
    }

    public function put($data)
    {
        try {
            $event = self::find($data['id']);
            if (empty($event->id)) {
                throw new \Exception('event not found');
            }
            $event_fields = [
                'id'        => $data['id'],
                'title'     => $data['title'],
                'starts_at' => $data['starts_at'],
                'ends_at'   => $data['ends_at'],
            ];
            $event->update($event_fields);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return $e->getMessage();
        }
        return $event;
    }

    public function del($id) {
        try {
            $event = self::find($id);
            if (empty($event->id)) {
                throw new \Exception('event not found');
            }
            $event->delete();
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return $e->getMessage();
        }
        return $event;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}