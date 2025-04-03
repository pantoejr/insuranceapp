{{-- filepath: resources/views/components/section-navigation.blade.php --}}
<div class="row mb-3">
    <div class="col-12 mb-3">
        <div class="btn-group shadow-sm w-100" role="group" aria-label="Section navigation">
            @foreach ($sections as $section)
                <button type="button" class="btn btn-outline-primary {{ $loop->first ? 'active' : '' }} section-btn"
                    id="{{ $section['id'] }}-btn" data-target="#{{ $section['id'] }}">
                    <span class="d-inline d-sm-none">
                        <i class="bi bi-{{ $section['icons'] }}"></i>
                    </span>
                    <span class="d-none d-sm-inline">
                        <i class="bi bi-{{ $section['icons'] }}"></i> {{ $section['title'] }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>
    <div class="col-12">
        @foreach ($sections as $section)
            <div id="{{ $section['id'] }}" class="section-content {{ $loop->first ? '' : 'd-none' }}">
                @include($section['view'], ['model' => $model])
            </div>
        @endforeach
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle section button clicks
        $('.section-btn').on('click', function(e) {
            // Only process if it's a section button (not a modal trigger)
            if ($(this).hasClass('section-btn')) {
                // Remove active class from all buttons
                $('.section-btn').removeClass('active');

                // Add active class to clicked button
                $(this).addClass('active');

                // Hide all sections
                $('.section-content').addClass('d-none');

                // Show target section
                $($(this).data('target')).removeClass('d-none');
            }
        });

        // Delegate modal events to handle modals in loaded partials
        $(document).on('click', '[data-bs-toggle="modal"]', function() {
            // Let Bootstrap handle the modal normally
            return true;
        });
    });
</script>
