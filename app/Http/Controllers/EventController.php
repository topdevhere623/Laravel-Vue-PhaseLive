<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\File;
use App\Phase\ImageManager;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Create a new event
     *
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'image' => 'required|image',
        ]);

        $event = Event::create([
            'user_id' => $request->user()->id,
            'image_id' => 1,
            'name' => $validated['name'],
            'url' => $validated['url'],
        ]);
        $event->saveImage($validated['image']);

        $event->refresh();

        return [
            'success' => true,
            'event' => $event,
        ];
    }

    /**
     * List all events for a user
     *
     * @param $userId
     * @return mixed
     */
    public function listForUser($userId)
    {
        $user = User::findOrFail($userId);

        return $user->events;
    }

    /**
     * Get a specific event
     *
     * @param $eventId
     * @return mixed
     */
    public function get($eventId)
    {
        return Event::findOrFail($eventId);
    }

    /**
     * Update an event
     *
     * @param Request $request
     * @param $eventId
     * @return array
     */
    public function update(Request $request, $eventId)
    {
        $event = $this->authorizeRequest($request, $eventId);

        $validated = $request->validate([
            'image' => 'nullable|image',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'date' => 'required|date',
        ]);

        if (! empty($validated['image'])) {
            foreach ($event->image->files as $file) {
                Storage::delete($file->path);
                File::destroy($file->id);
            }

            $manager = ImageManager::resource($validated['image'])
                ->directory('images/events')
                ->altText('Event Image')
                ->square()
                ->storeOriginal()
                ->storeLarge()
                ->storeMedium()
                ->storeThumb();

        }

        $event->update([
            'user_id' => $request->user()->id,
            'image_id' => !empty($validated['image']) ? $manager->asset->id : $event->image->id,
            'name' => $validated['name'],
            'location' => $validated['location'],
            'url' => $validated['url'],
            'date' => Carbon::parse($validated['date'])
        ]);
        
        $event->refresh();

        return [
            'success' => true,
            'event' => $event,
        ];
    }

    /**
     * Delete an event
     *
     * @param Request $request
     * @param $eventId
     * @return array
     */
    public function delete(Request $request, $eventId)
    {
        $event = $this->authorizeRequest($request, $eventId);

        $event->delete();

        return [
            'success' => true,
        ];
    }

    /**
     * Decide whether or not the authenticated user is able to modify the specified event
     *
     * @param $request
     * @param $eventId
     * @return mixed
     */
    private function authorizeRequest($request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        if ($event->user_id == $request->user()->id) {
            return $event;
        } else {
            abort(403);
        }
    }
}
