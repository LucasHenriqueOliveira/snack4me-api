<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $errors = [];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name'
    ];

    public function store($data) {
        try {
            $event = self::firstOrNew(['title' => strtolower($data['title'])]);
            if (!empty($event->id)) {
                throw new \Exception('event exists');
            }
            $event_fields = [
                'title'      => $data['title'],
                'starts_ad'  => $data['starts_at'],
                'ends_ad'    => $data['ends_ad'],
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
                'starts_ad' => $data['starts_at'],
                'ends_ad'   => $data['ends_ad'],
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