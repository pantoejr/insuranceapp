{{-- filepath: resources/views/components/section-navigation.blade.php --}}

<div class="row mb-3">
    <div class="col-md-3 mb-3">
        <div class="list-group shadow-sm bg-white p-2" style="min-height: 450px;">
            @foreach ($sections as $section)
                <a href="#" class="list-group-item bg-white  list-group-item-action border-0"
                    id="{{ $section['id'] }}-link">
                    <i class="bi bi-{{ $section['icons'] }}"></i>&nbsp;
                    &nbsp;{{ $section['title'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-9">
        @foreach ($sections as $section)
            <div id="{{ $section['id'] }}" class="section-content {{ $loop->first ? '' : 'd-none' }}">
                @include($section['view'], ['model' => $model])
            </div>
        @endforeach
    </div>
</div>

<script>
    $(document).ready(function() {
        @foreach ($sections as $section)
            $('#{{ $section['id'] }}-link').on('click', function() {
                showSection('{{ $section['id'] }}');
            });
        @endforeach

        function showSection(sectionId) {
            $('.section-content').addClass('d-none');
            $('#' + sectionId).removeClass('d-none');
        }
    });
</script>
