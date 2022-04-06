<html>
    <head>
        <style>
            div.gallery {
                margin: 5px;
                border: 1px solid #ccc;
                float: left;
                width: 180px;
            }

            div.gallery:hover {
                border: 1px solid #777;
            }

            div.gallery img {
                width: 100%;
                height: auto;
            }

            div.desc {
                padding: 15px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1 class="display-one mt-5">Shows the Space Picture of the Day from NASA... with aliens</h1>
        @forelse($pictures as $picture)
            <div class="gallery">
                <a target="_blank" href="{!! $picture->url !!}">
                    <img src="{!! $picture->url !!}" alt="Cinque Terre" width="600" height="400">
                </a>
                <div class="desc">{!! $picture->title !!}</div>
            </div>
        @empty
            No pictures found
        @endforelse
    </body>
</html>