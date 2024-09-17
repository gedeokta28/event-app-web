<div class="row align-items-center gap-1" x-data="{
    deleteUrl: '{{ route('events.destroy', ['event' => $event->event_id]) }}',
}">
    <a href="{{ route('events.edit', ['event' => $event->event_id]) }}" class="btn btn-primary">Edit</a>
    <button type="button" class="btn btn-danger delete"
        x-on:click="
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4444ff',
                    cancelButtonColor: '#ff5272',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(deleteUrl).then(res => {
                            if (res.status == 200) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                ).then(res => {
                                    if (res.isConfirmed) {
                                        window.LaravelDataTables['event-table'].ajax.reload()
                                    }
                                })
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                title: 'Error!',
                                text: err,
                                icon: 'error',
                            })
                        })
                    }
                })
            ">Hapus</button>

    {{-- <a href="{{ route('product-variants.index', ['event' => $event->eventid]) }}"
       class="btn btn-secondary d-flex align-items-center"><i
           class="fas fa-clone me-1"></i>Variant</a> --}}
</div>
