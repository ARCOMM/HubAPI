<script>
    $(document).ready(function(e) {
        $('.mission-media-upload').dropzone({
            url: '{{ url('/hub/missions/media/add-photo?mission_id=' . $mission->id) }}',
            acceptedFiles: 'image/*',
            addedfile: function(file) {},
            success: function(file, data) {
                $('.mission-media').append(data);
            }
        });

        $('.mission-media').magnificPopup({
            delegate: '.mission-media-item-image',
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        $(document).on('click', '.mission-media-item-delete', function(event) {
            var caller = $(this);
            var media = caller.data('media');
            var mission = caller.data('mission');

            $('.mfp-bg').click();

            $.ajax({
                type: 'POST',
                url: '{{ url('/hub/missions/media/delete-photo') }}',
                data: {
                    'media_id': media,
                    'mission_id': mission
                },
                success: function(data) {
                    caller.parents('.mission-media-item').remove();
                    $('.mfp-bg').click();
                }
            });

            event.stopPropagation();
            event.preventDefault();
        });

        $('.mission-media-video-upload').click(function(event) {
            var caller = $(this);
            var mission_id = caller.data('mission');
            var video_url = prompt("Please enter your YouTube video's full URL");

            if (video_url != null) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/hub/missions/media/add-video') }}',
                    data: {
                        'mission_id': mission_id,
                        'video_url': video_url
                    },
                    success: function(data) {
                        $('.mission-media').append(data);
                    }
                });
            }

            event.preventDefault();
        });

        $(document).on('click', '.mission-video-item-delete', function(event) {
            var caller = $(this);
            var video = caller.data('video');

            $.ajax({
                type: 'POST',
                url: '{{ url('/hub/missions/media/delete-video') }}',
                data: {
                    'video_id': video
                },
                success: function(data) {
                    caller.parents('.mission-media-item-video').remove();
                }
            });

            event.stopPropagation();
            event.preventDefault();
        });
    });
</script>

<div class="pull-left w-100 m-b-2" style="padding: .5rem .5rem 0 .5rem;">
    <a href="javascript:void(0)" class="mission-media-video-upload btn btn-primary btn-raised pull-right m-l-1" data-mission="{{ $mission->id }}">
        <i class="fa fa-youtube m-r-1"></i> Video
    </a>

    <a href="javascript:void(0)" class="mission-media-upload btn btn-primary btn-raised pull-right">
        <i class="fa fa-picture-o m-r-1"></i> Photo
    </a>
</div>

<div class="pull-left w-100 mission-media">
    @if ($mission->photos()->isEmpty() && $mission->videos->isEmpty())
        <p class="text-xs-center text-muted">Upload a photo for the mission banner!</p>
    @else
        @foreach ($mission->photos() as $media)
            @include('missions.media.photo', [
                'media' => $media,
                'mission' => $mission
            ])
        @endforeach

        {{-- @foreach ($mission->videos as $video)
            @include('missions.media.video', [
                'video' => $video
            ])
        @endforeach --}}
    @endif
</div>
