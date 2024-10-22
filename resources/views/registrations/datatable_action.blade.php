<div class="row align-items-center gap-1" x-data="{
    resendUrl: '{{ route('resend.ticket', ['regId' => $registrations->reg_id]) }}',
    loading: false, // Define loading state
    canResend: {{ $registrations->reg_success ? 'true' : 'false' }} // Disable if reg_success is false
}">
    <button type="button" class="btn btn-primary" :disabled="loading || !canResend"
        x-on:click="
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4444ff',
                cancelButtonColor: '#ff5272',
                confirmButtonText: 'Yes, resend it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    loading = true; // Set loading to true
                    axios.post(resendUrl)
                        .then(res => {
                            if (res.status == 200) {
                                Swal.fire(
                                    'Resent!',
                                    'Your ticket has been resent.',
                                    'success'
                                ).then(res => {
                                    if (res.isConfirmed) {
                                        window.LaravelDataTables['event-table'].ajax.reload();
                                    }
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                title: 'Error!',
                                text: err,
                                icon: 'error',
                            });
                        })
                        .finally(() => {
                            loading = false; // Set loading back to false after request completes
                        });
                }
            });
        ">
        <template x-if="!loading">
            <span>Resend Ticket</span>
        </template>
        <template x-if="loading">
            <span>Loading...</span> <!-- You can replace this with a spinner -->
        </template>
    </button>
</div>
