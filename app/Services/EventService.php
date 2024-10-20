<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventService extends BaseService
{
    /**
     * StockService constructor
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->model = $event;
    }



    public function create(array $data)
    {

        $event = Event::create($data);

        if (isset($data['logo_file']) && $data['logo_file'] instanceof UploadedFile) {
            $this->storeEventImage($event, $data['logo_file']);
        }

        if (isset($data['intro_file']) && $data['intro_file'] instanceof UploadedFile) {
            $this->storeEventIntroImage($event, $data['intro_file']);
        }
        if (isset($data['ticket_file']) && $data['ticket_file'] instanceof UploadedFile) {
            $this->storeEventTicketImage($event, $data['ticket_file']);
        }


        return $event;
    }

    public function update($id, array $data)
    {
        $event = $this->model->findOrFail($id);

        // Simpan nilai event_active sebelum array_filter
        $event_active = $data['event_active'] ?? null;

        // Filter data kecuali event_active
        $filteredData = array_filter($data);

        // Kembalikan event_active ke dalam data (baik true/false atau null)
        $filteredData['event_active'] = $event_active;

        $event->update($filteredData);

        if (isset($data['logo_file']) && $data['logo_file'] instanceof UploadedFile) {
            $this->storeEventImage($event, $data['logo_file']);
        }
        if (isset($data['intro_file']) && $data['intro_file'] instanceof UploadedFile) {
            $this->storeEventIntroImage($event, $data['intro_file']);
        }
        if (isset($data['ticket_file']) && $data['ticket_file'] instanceof UploadedFile) {
            $this->storeEventTicketImage($event, $data['ticket_file']);
        }

        return $event;
    }




    protected function storeEventImage(Event $event, UploadedFile $image)
    {
        $fileExtension = $image->clientExtension();
        $filename = sprintf("%s.%s", $event->event_id, $fileExtension);

        $filepath = $image->storeAs('event/images', $filename);
        $event->update(['logo_file' => $filepath]);
    }

    protected function storeEventTicketImage(Event $event, UploadedFile $image)
    {
        $fileExtension = $image->clientExtension();
        $filename = sprintf("%s.%s", $event->event_id, $fileExtension);

        $filepath = $image->storeAs('event/ticket', $filename);
        $event->update(['ticket_file' => $filepath]);
    }


    protected function storeEventIntroImage(Event $event, UploadedFile $image)
    {
        $fileExtension = $image->clientExtension();
        $filename = sprintf("%s.%s", "intro_$event->event_id", $fileExtension);

        $filepath = $image->storeAs('event/intro', $filename);
        $event->update(['intro_file' => $filepath]);
    }
}
